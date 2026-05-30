<?php
/**
 *
 * LSPD论坛徽章. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, siwode, https://my.siwode.net
 * @copyright (c) 2025-2026, Yuanx1a0
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace siwode\lcpd\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * LSPD论坛徽章 Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/**
	 * Map phpBB core events to the listener methods that should handle those events
	 *
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header'					=> 'add_page_header_link',
			'core.viewonline_overwrite_location'		=> 'viewonline_page',
			'core.display_forums_modify_template_vars'	=> 'display_forums_modify_template_vars',
			'core.permissions'					=> 'add_permissions',
			'core.acp_users_modify_profile'			=> 'acp_users_modify_profile',
			'core.acp_users_profile_modify_sql_ary'	=> 'acp_users_profile_modify_sql_ary',
			'core.memberlist_view_profile'			=> 'memberlist_view_profile',
			'core.viewtopic_post_rowset_data'		=> 'viewtopic_post_rowset_data',
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.viewtopic_post_row_after'			=> 'viewtopic_post_row_after',
			'core.ucp_profile_modify_profile_info'		=> 'ucp_profile_modify_profile_info',
			'core.ucp_profile_validate_profile_info'	=> 'ucp_profile_validate_profile_info',
			'core.ucp_profile_info_modify_sql_ary'		=> 'ucp_profile_info_modify_sql_ary',
		];
	}

	/* @var \phpbb\language\language */
	protected $language;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string Shields table */
	protected $shields_table;

	/** @var string Ribbons table */
	protected $ribbons_table;

	/** @var string Namebars table */
	protected $namebars_table;

	/** @var array */
	protected $shield_cache = [];

	/** @var array */
	protected $ribbon_cache = [];

	/** @var array */
	protected $namebar_cache = [];

	/** @var bool */
	protected $badges_loaded = false;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string User-ribbons relation table */
	protected $user_ribbons_table;

	/** @var array */
	protected $user_ribbons_cache = [];

	/** @var \siwode\lcpd\service\display_settings */
	protected $display_settings;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\controller\helper	$helper		Controller helper object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\request\request	$request	Request object
	 * @param \phpbb\db\driver\driver_interface $db	Database object
	 * @param string						$shields_table	Shields table name
	 * @param string						$ribbons_table	Ribbons table name
	 * @param string						$namebars_table	Namebars table name
	 * @param string                    $php_ext    phpEx
	 * @param string                    $user_ribbons_table User ribbons table
	 * @param \siwode\lcpd\service\display_settings $display_settings Display settings
	 * @param \phpbb\user               $user       User object
	 */
	public function __construct(\phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, $shields_table, $ribbons_table, $namebars_table, $php_ext, $user_ribbons_table, \siwode\lcpd\service\display_settings $display_settings, \phpbb\user $user)
	{
		$this->language = $language;
		$this->helper   = $helper;
		$this->template = $template;
		$this->request  = $request;
		$this->db       = $db;
		$this->shields_table = $shields_table;
		$this->ribbons_table = $ribbons_table;
		$this->namebars_table = $namebars_table;
		$this->php_ext  = $php_ext;
		$this->user_ribbons_table = $user_ribbons_table;
		$this->display_settings = $display_settings;
		$this->user = $user;
	}

	/**
	 * Get all ribbon IDs for a given user from the relation table.
	 *
	 * @param int $user_id
	 * @return array
	 */
	protected function get_user_ribbon_ids($user_id)
	{
		$user_id = (int) $user_id;

		if ($user_id <= 0)
		{
			return [];
		}

		if (!isset($this->user_ribbons_cache[$user_id]))
		{
			$sql = 'SELECT ribbon_id
				FROM ' . $this->user_ribbons_table . '
				WHERE user_id = ' . $user_id . '
				ORDER BY sort_order ASC, ribbon_id ASC';
			$result = $this->db->sql_query($sql);

			$ribbon_ids = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ribbon_ids[] = (int) $row['ribbon_id'];
			}
			$this->db->sql_freeresult($result);

			$this->user_ribbons_cache[$user_id] = $ribbon_ids;
		}

		return $this->user_ribbons_cache[$user_id];
	}

	/**
	 * Load ribbon id => name map for the given ribbon IDs.
	 *
	 * @param array $ribbon_ids
	 * @return array
	 */
	protected function get_ribbon_name_map(array $ribbon_ids)
	{
		$ribbon_ids = array_values(array_filter(array_map('intval', $ribbon_ids)));

		if (empty($ribbon_ids))
		{
			return [];
		}

		$sql = 'SELECT ribbon_id, ribbon_name
			FROM ' . $this->ribbons_table . '
			WHERE ' . $this->db->sql_in_set('ribbon_id', $ribbon_ids);
		$result = $this->db->sql_query($sql);

		$names = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$names[(int) $row['ribbon_id']] = (string) $row['ribbon_name'];
		}
		$this->db->sql_freeresult($result);

		return $names;
	}

	/**
	 * Persist a user's ribbon order.
	 *
	 * @param int   $user_id
	 * @param array $ribbon_ids
	 * @return void
	 */
	protected function save_user_ribbon_ids($user_id, array $ribbon_ids)
	{
		$user_id = (int) $user_id;

		if ($user_id <= 0)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->user_ribbons_table . '
			WHERE user_id = ' . $user_id;
		$this->db->sql_query($sql);

		unset($this->user_ribbons_cache[$user_id]);

		$sort_order = 0;
		foreach ($ribbon_ids as $ribbon_id)
		{
			$ribbon_id = (int) $ribbon_id;

			if ($ribbon_id <= 0)
			{
				continue;
			}

			$sql = 'INSERT INTO ' . $this->user_ribbons_table . ' '
				. $this->db->sql_build_array('INSERT', [
					'user_id'    => $user_id,
					'ribbon_id'  => $ribbon_id,
					'sort_order' => $sort_order++,
				]);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Normalize submitted ribbon IDs for reorder validation.
	 *
	 * @param array $ribbon_ids
	 * @return array
	 */
	protected function normalize_ribbon_ids(array $ribbon_ids)
	{
		$normalized = [];

		foreach ($ribbon_ids as $ribbon_id)
		{
			$ribbon_id = (int) $ribbon_id;

			if ($ribbon_id <= 0)
			{
				continue;
			}

			$normalized[] = $ribbon_id;
		}

		return $normalized;
	}

	/**
	 * Read user display preferences for shield, ribbons and namebar.
	 *
	 * @param array $row
	 * @return array
	 */
	protected function get_user_display_prefs(array $row)
	{
		return [
			'show_shield'  => !isset($row['user_lcpd_show_shield']) || (int) $row['user_lcpd_show_shield'],
			'show_ribbons' => !isset($row['user_lcpd_show_ribbons']) || (int) $row['user_lcpd_show_ribbons'],
			'show_namebar' => !isset($row['user_lcpd_show_namebar']) || (int) $row['user_lcpd_show_namebar'],
		];
	}

	/**
	 * Resolve which badge parts should render for a user.
	 *
	 * @param array $row
	 * @param bool  $has_shield_content
	 * @param bool  $has_namebar_content
	 * @param bool  $has_ribbons_content
	 * @return array
	 */
	protected function resolve_badge_display_flags(array $row, $has_shield_content, $has_namebar_content, $has_ribbons_content)
	{
		$prefs = $this->get_user_display_prefs($row);

		return [
			'show_shield'  => $prefs['show_shield'] && $has_shield_content,
			'show_namebar' => $prefs['show_namebar'] && $has_namebar_content,
			'show_ribbons' => $prefs['show_ribbons'] && $has_ribbons_content,
		];
	}

	/**
	 * Load a user's display preference from session data.
	 *
	 * @param string $field
	 * @return int
	 */
	protected function get_ucp_display_pref($field)
	{
		return isset($this->user->data[$field]) ? (int) $this->user->data[$field] : 1;
	}

	/**
	 * Integrate LCPD badges into ACP user profile form.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function acp_users_modify_profile($event)
	{
		$data = $event['data'];
		$submit = $event['submit'];
		$user_row = $event['user_row'];

		if ($submit)
		{
			$data['user_lcpd_shield'] = $this->request->variable('user_lcpd_shield', 0);
			$data['user_lcpd_namebar'] = $this->request->variable('user_lcpd_namebar', 0);
			$data['user_lcpd_active'] = $this->request->variable('user_lcpd_active', 0);
			$data['user_lcpd_badge_number'] = $this->request->variable('user_lcpd_badge_number', '', true);

			$ribbon_ids = $this->request->variable('user_lcpd_ribbon_ids', [0]);
			$ribbon_ids = array_map('intval', $ribbon_ids);
			$ribbon_ids = array_values(array_filter($ribbon_ids, function ($id) {
				return $id > 0;
			}));

			$data['user_lcpd_ribbon_ids'] = $ribbon_ids;
		}
		else
		{
			$data['user_lcpd_shield'] = isset($user_row['user_lcpd_shield']) ? (int) $user_row['user_lcpd_shield'] : 0;
			$data['user_lcpd_namebar'] = isset($user_row['user_lcpd_namebar']) ? (int) $user_row['user_lcpd_namebar'] : 0;
			$data['user_lcpd_active'] = isset($user_row['user_lcpd_active']) ? (int) $user_row['user_lcpd_active'] : 0;
			$data['user_lcpd_badge_number'] = isset($user_row['user_lcpd_badge_number']) ? (string) $user_row['user_lcpd_badge_number'] : '';

			$user_id = isset($user_row['user_id']) ? (int) $user_row['user_id'] : 0;
			$data['user_lcpd_ribbon_ids'] = $this->get_user_ribbon_ids($user_id);
		}

		$data['user_lcpd_user_id'] = isset($user_row['user_id']) ? (int) $user_row['user_id'] : 0;

		if (empty($data['user_lcpd_ribbon_ids']))
		{
			$data['user_lcpd_ribbon_ids'] = [0];
		}

		$this->template->assign_vars([
			'USER_LCPD_SHIELD_ID' => (int) $data['user_lcpd_shield'],
			'USER_LCPD_NAMEBAR_ID' => (int) $data['user_lcpd_namebar'],
			'USER_LCPD_ACTIVE' => (int) $data['user_lcpd_active'],
			'USER_LCPD_BADGE_NUMBER' => (string) $data['user_lcpd_badge_number'],
		]);

		// Load available shields grouped by category for ACP dropdown
		$shield_categories_table = preg_replace('/_shields$/', '_shield_categories', $this->shields_table);
		$sql = 'SELECT s.shield_id, s.shield_name, c.category_name
			FROM ' . $this->shields_table . ' s
			LEFT JOIN ' . $shield_categories_table . ' c
				ON c.category_id = s.category_id
			ORDER BY c.category_name ASC, s.shield_id ASC';
		$result = $this->db->sql_query($sql);
		$current_category = null;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$category_name = (string) $row['category_name'];
			if ($category_name !== $current_category)
			{
				$current_category = $category_name;
				$this->template->assign_block_vars('lcpd_shields', [
					'IS_CATEGORY' => true,
					'ID'         => 0,
					'NAME'       => $category_name,
				]);
			}
			$this->template->assign_block_vars('lcpd_shields', [
				'IS_CATEGORY' => false,
				'ID'         => (int) $row['shield_id'],
				'NAME'       => $row['shield_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		// Load available ribbons grouped by category for ACP dropdown
		$ribbon_categories_table = preg_replace('/_ribbons$/', '_ribbon_categories', $this->ribbons_table);
		$sql = 'SELECT r.ribbon_id, r.ribbon_name, c.category_name
			FROM ' . $this->ribbons_table . ' r
			LEFT JOIN ' . $ribbon_categories_table . ' c
				ON c.category_id = r.category_id
			ORDER BY c.category_name ASC, r.ribbon_id ASC';
		$result = $this->db->sql_query($sql);
		$current_category = null;
		$ribbon_choices = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$category_name = (string) $row['category_name'];
			if ($category_name !== $current_category)
			{
				$current_category = $category_name;
				if ($category_name !== '')
				{
					$ribbon_choices[] = [
						'IS_CATEGORY' => true,
						'ID'         => 0,
						'NAME'       => $category_name,
					];
				}
			}

			$ribbon_choices[] = [
				'IS_CATEGORY' => false,
				'ID'         => (int) $row['ribbon_id'],
				'NAME'       => $row['ribbon_name'],
			];
		}
		$this->db->sql_freeresult($result);

		$position = 1;
		foreach ($data['user_lcpd_ribbon_ids'] as $ribbon_id)
		{
			$selected_id = (int) $ribbon_id;
			$options_html = '';

			foreach ($ribbon_choices as $choice)
			{
				if (!empty($choice['IS_CATEGORY']))
				{
					$options_html .= '<option value="0" style="font-weight: bold; color: #000;">' . htmlspecialchars($choice['NAME']) . '</option>';
				}
				else
				{
					$options_html .= '<option value="' . $choice['ID'] . '"';
					if ($choice['ID'] === $selected_id)
					{
						$options_html .= ' selected="selected"';
					}
					$options_html .= '>&nbsp;&nbsp;&nbsp;' . htmlspecialchars($choice['NAME']) . '</option>';
				}
			}

			$none_label = $this->language->lang('ACP_LCPD_USER_NONE');
			$options_html .= '<option value="0"' . ($selected_id <= 0 ? ' selected="selected"' : '') . '>' . htmlspecialchars($none_label) . '</option>';

			$this->template->assign_block_vars('lcpd_user_ribbons', [
				'POSITION' => $position++,
				'ID'       => $selected_id,
				'OPTIONS'  => $options_html,
			]);
		}

		// Load available namebars grouped by category for ACP dropdown
		$namebar_categories_table = preg_replace('/_namebars$/', '_namebar_categories', $this->namebars_table);
		$sql = 'SELECT n.namebar_id, n.namebar_name, c.category_name
			FROM ' . $this->namebars_table . ' n
			LEFT JOIN ' . $namebar_categories_table . ' c
				ON c.category_id = n.category_id
			ORDER BY c.category_name ASC, n.namebar_id ASC';
		$result = $this->db->sql_query($sql);
		$current_category = null;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$category_name = (string) $row['category_name'];
			if ($category_name !== $current_category)
			{
				$current_category = $category_name;
				$this->template->assign_block_vars('lcpd_namebars', [
					'IS_CATEGORY' => true,
					'ID'         => 0,
					'NAME'       => $category_name,
				]);
			}
			$this->template->assign_block_vars('lcpd_namebars', [
				'IS_CATEGORY' => false,
				'ID'         => (int) $row['namebar_id'],
				'NAME'       => $row['namebar_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$event['data'] = $data;
	}

	/**
	 * Save LCPD badge selections when ACP user profile is submitted.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function acp_users_profile_modify_sql_ary($event)
	{
		$data = $event['data'];
		$sql_ary = $event['sql_ary'];

		$sql_ary['user_lcpd_shield'] = isset($data['user_lcpd_shield']) ? (int) $data['user_lcpd_shield'] : 0;
		$sql_ary['user_lcpd_namebar'] = isset($data['user_lcpd_namebar']) ? (int) $data['user_lcpd_namebar'] : 0;
		$sql_ary['user_lcpd_active'] = isset($data['user_lcpd_active']) ? (int) $data['user_lcpd_active'] : 0;
		$sql_ary['user_lcpd_badge_number'] = isset($data['user_lcpd_badge_number']) ? (string) $data['user_lcpd_badge_number'] : '';

		$first_ribbon_id = 0;
		if (!empty($data['user_lcpd_ribbon_ids']) && is_array($data['user_lcpd_ribbon_ids']))
		{
			foreach ($data['user_lcpd_ribbon_ids'] as $rid)
			{
				$rid = (int) $rid;
				if ($rid > 0)
				{
					$first_ribbon_id = $rid;
					break;
				}
			}
		}
		$sql_ary['user_lcpd_ribbon'] = $first_ribbon_id;

		$event['sql_ary'] = $sql_ary;

		$user_id = isset($data['user_lcpd_user_id']) ? (int) $data['user_lcpd_user_id'] : 0;
		if (!$user_id && isset($event['user_id']))
		{
			$user_id = (int) $event['user_id'];
		}

		if ($user_id > 0)
		{
			$this->save_user_ribbon_ids($user_id, isset($data['user_lcpd_ribbon_ids']) ? $data['user_lcpd_ribbon_ids'] : []);
		}
	}

	/**
	 * Copy LCPD user badge fields into the rowset data used later in viewtopic.
	 * This makes user_lcpd_* available in $event['row'] for viewtopic_modify_post_row.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function viewtopic_post_rowset_data($event)
	{
		$rowset_data = $event['rowset_data'];
		$row = $event['row'];

		$rowset_data['user_lcpd_shield'] = isset($row['user_lcpd_shield']) ? (int) $row['user_lcpd_shield'] : 0;
		$rowset_data['user_lcpd_namebar'] = isset($row['user_lcpd_namebar']) ? (int) $row['user_lcpd_namebar'] : 0;
		$rowset_data['user_lcpd_active'] = isset($row['user_lcpd_active']) ? (int) $row['user_lcpd_active'] : 0;
		$rowset_data['user_lcpd_badge_number'] = isset($row['user_lcpd_badge_number']) ? (string) $row['user_lcpd_badge_number'] : '';
		$rowset_data['user_lcpd_show_shield'] = isset($row['user_lcpd_show_shield']) ? (int) $row['user_lcpd_show_shield'] : 1;
		$rowset_data['user_lcpd_show_ribbons'] = isset($row['user_lcpd_show_ribbons']) ? (int) $row['user_lcpd_show_ribbons'] : 1;
		$rowset_data['user_lcpd_show_namebar'] = isset($row['user_lcpd_show_namebar']) ? (int) $row['user_lcpd_show_namebar'] : 1;

		for ($i = 1; $i <= 10; $i++)
		{
			$field = 'user_lcpd_ribbon' . $i;
			$rowset_data[$field] = isset($row[$field]) ? (int) $row[$field] : 0;
		}

		$event['rowset_data'] = $rowset_data;
	}

	/**
	 * Inject LCPD badge info into user profile (memberlist view).
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function memberlist_view_profile($event)
	{
		$member = $event['member'];

		$shield_id = isset($member['user_lcpd_shield']) ? (int) $member['user_lcpd_shield'] : 0;
		$namebar_id = isset($member['user_lcpd_namebar']) ? (int) $member['user_lcpd_namebar'] : 0;
		$active_flag = isset($member['user_lcpd_active']) ? (int) $member['user_lcpd_active'] : 0;
		$badge_number = isset($member['user_lcpd_badge_number']) ? (string) $member['user_lcpd_badge_number'] : '';

		$ribbon_ids = $this->get_user_ribbon_ids(isset($member['user_id']) ? (int) $member['user_id'] : 0);

		if (!$shield_id && !$namebar_id && empty($ribbon_ids))
		{
			return;
		}

		$this->load_badge_cache();

		$shield = ($shield_id && isset($this->shield_cache[$shield_id])) ? $this->shield_cache[$shield_id] : null;
		$namebar = ($namebar_id && isset($this->namebar_cache[$namebar_id])) ? $this->namebar_cache[$namebar_id] : null;

		$shield_img = ($shield && !empty($shield['shield_image'])) ? 'images/shield/' . $shield['shield_image'] : '';
		$namebar_img = ($namebar && !empty($namebar['namebar_image'])) ? 'images/namebar/' . $namebar['namebar_image'] : '';

		$has_ribbons = false;
		$ribbon_blocks = [];
		foreach ($ribbon_ids as $ribbon_id)
		{
			if (!isset($this->ribbon_cache[$ribbon_id]))
			{
				continue;
			}

			$ribbon = $this->ribbon_cache[$ribbon_id];
			if (empty($ribbon['ribbon_image']))
			{
				continue;
			}

			$has_ribbons = true;
			$ribbon_blocks[] = [
				'IMG_SRC' => 'images/ribbons/' . $ribbon['ribbon_image'],
				'NAME'   => $ribbon['ribbon_name'],
				'INDEX'  => $ribbon_id,
			];
		}

		// Derive badge display name from username, same logic as viewtopic
		$badge_name = '';
		if (!empty($member['username']))
		{
			$username_normalized = str_replace('_', ' ', $member['username']);
			$parts = preg_split('/\s+/', $username_normalized);
			if (is_array($parts) && count($parts) > 1)
			{
				$badge_name = (string) end($parts);
			}
			else
			{
				$badge_name = (string) $member['username'];
			}
		}

		$badge_name = utf8_strtoupper($badge_name);

		$display_flags = $this->resolve_badge_display_flags(
			$member,
			(bool) $shield_img,
			(bool) $namebar_img,
			$has_ribbons
		);

		if (!$display_flags['show_shield'])
		{
			$shield_img = '';
			$badge_number = '';
		}

		if (!$display_flags['show_namebar'])
		{
			$namebar_img = '';
		}

		if (!$display_flags['show_ribbons'])
		{
			$ribbon_blocks = [];
			$has_ribbons = false;
		}

		$this->template->assign_vars([
			'LCPD_SHIELD_IMG_SRC' => $shield_img,
			'LCPD_SHIELD_NAME'    => $shield ? $shield['shield_name'] : '',
			'LCPD_NAMEBAR_IMG_SRC'=> $namebar_img,
			'LCPD_NAMEBAR_NAME'   => $namebar ? $namebar['namebar_name'] : '',
			'LCPD_BADGE_NAME'     => $badge_name,
			'LCPD_BADGE_NUMBER'   => $badge_number,
			'S_LCPD_ACTIVE'       => (bool) $active_flag,
			'S_LCPD_SHOW_SHIELD'  => (bool) $display_flags['show_shield'],
			'S_LCPD_SHOW_NAMEBAR' => (bool) $display_flags['show_namebar'],
			'S_LCPD_SHOW_RIBBONS' => (bool) $display_flags['show_ribbons'],
			'S_LCPD_BADGES'       => (bool) ($display_flags['show_shield'] || $display_flags['show_namebar'] || $display_flags['show_ribbons']),
			'LCPD_RIBBON_IDS'     => implode(',', $ribbon_ids),
		]);

		foreach ($ribbon_blocks as $block)
		{
			$this->template->assign_block_vars('lcpd_post_ribbons', $block);
		}
	}

	/**
	 * Load all shields/ribbons/namebars into local caches (once per request).
	 */
	protected function load_badge_cache()
	{
		if ($this->badges_loaded)
		{
			return;
		}

		// Shields
		$sql = 'SELECT shield_id, shield_name, shield_image
			FROM ' . $this->shields_table;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->shield_cache[(int) $row['shield_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		// Ribbons
		$sql = 'SELECT ribbon_id, ribbon_name, ribbon_image
			FROM ' . $this->ribbons_table;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->ribbon_cache[(int) $row['ribbon_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		// Namebars
		$sql = 'SELECT namebar_id, namebar_name, namebar_image
			FROM ' . $this->namebars_table;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->namebar_cache[(int) $row['namebar_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$this->badges_loaded = true;
	}

	/**
	 * Inject LCPD badge info into viewtopic post_row data.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function viewtopic_modify_post_row($event)
	{
		$row = $event['row'];
		$post_row = $event['post_row'];

		$shield_id = isset($row['user_lcpd_shield']) ? (int) $row['user_lcpd_shield'] : 0;
		$namebar_id = isset($row['user_lcpd_namebar']) ? (int) $row['user_lcpd_namebar'] : 0;
		$active_flag = isset($row['user_lcpd_active']) ? (int) $row['user_lcpd_active'] : 0;
		$badge_number = isset($row['user_lcpd_badge_number']) ? (string) $row['user_lcpd_badge_number'] : '';

		$ribbon_ids = $this->get_user_ribbon_ids(isset($row['user_id']) ? (int) $row['user_id'] : 0);

		if (!$shield_id && !$namebar_id && empty($ribbon_ids))
		{
			return;
		}

		$this->load_badge_cache();

		$shield = ($shield_id && isset($this->shield_cache[$shield_id])) ? $this->shield_cache[$shield_id] : null;
		$namebar = ($namebar_id && isset($this->namebar_cache[$namebar_id])) ? $this->namebar_cache[$namebar_id] : null;

		// Build image paths relative to board root
		$post_row['LCPD_SHIELD_IMG_SRC'] = ($shield && !empty($shield['shield_image'])) ? 'images/shield/' . $shield['shield_image'] : '';
		$post_row['LCPD_SHIELD_NAME'] = $shield ? $shield['shield_name'] : '';

		$post_row['LCPD_NAMEBAR_IMG_SRC'] = ($namebar && !empty($namebar['namebar_image'])) ? 'images/namebar/' . $namebar['namebar_image'] : '';
		$post_row['LCPD_NAMEBAR_NAME'] = $namebar ? $namebar['namebar_name'] : '';

		$has_ribbons = false;
		foreach ($ribbon_ids as $index => $ribbon_id)
		{
			if (!isset($this->ribbon_cache[$ribbon_id]))
			{
				continue;
			}

			$ribbon = $this->ribbon_cache[$ribbon_id];
			if (empty($ribbon['ribbon_image']))
			{
				continue;
			}

			$has_ribbons = true;
		}

		// Derive badge display name from username: use last token split by space/underscore
		$badge_name = '';
		if (!empty($row['username']))
		{
			$username_normalized = str_replace('_', ' ', $row['username']);
			$parts = preg_split('/\s+/', $username_normalized);
			if (is_array($parts) && count($parts) > 1)
			{
				$badge_name = (string) end($parts);
			}
			else
			{
				$badge_name = (string) $row['username'];
			}
		}
		$post_row['LCPD_BADGE_NAME'] = utf8_strtoupper($badge_name);
		$post_row['LCPD_BADGE_NUMBER'] = $badge_number;

		$display_flags = $this->resolve_badge_display_flags(
			$row,
			(bool) $post_row['LCPD_SHIELD_IMG_SRC'],
			(bool) $post_row['LCPD_NAMEBAR_IMG_SRC'],
			$has_ribbons
		);

		if (!$display_flags['show_shield'])
		{
			$post_row['LCPD_SHIELD_IMG_SRC'] = '';
			$post_row['LCPD_BADGE_NUMBER'] = '';
		}

		if (!$display_flags['show_namebar'])
		{
			$post_row['LCPD_NAMEBAR_IMG_SRC'] = '';
		}

		$post_row['S_LCPD_ACTIVE'] = (bool) $active_flag;
		$post_row['S_LCPD_SHOW_SHIELD'] = (bool) $display_flags['show_shield'];
		$post_row['S_LCPD_SHOW_NAMEBAR'] = (bool) $display_flags['show_namebar'];
		$post_row['S_LCPD_SHOW_RIBBONS'] = (bool) $display_flags['show_ribbons'];
		$post_row['S_LCPD_BADGES'] = (bool) ($display_flags['show_shield'] || $display_flags['show_namebar'] || $display_flags['show_ribbons']);
		$post_row['LCPD_RIBBON_IDS'] = implode(',', $ribbon_ids);
		$post_row['LCPD_WRAP_STYLE'] = $this->display_settings->get_wrap_style();
		$post_row['LCPD_SHIELD_IMG_STYLE'] = $this->display_settings->get_shield_img_style();
		$post_row['LCPD_SHIELD_WRAP_STYLE'] = $this->display_settings->get_shield_wrap_style();
		$post_row['LCPD_BADGE_NUMBER_STYLE'] = $this->display_settings->get_badge_number_style();
		$post_row['LCPD_NAMEBAR_WRAP_STYLE'] = $this->display_settings->get_namebar_wrap_style();
		$post_row['LCPD_NAMEBAR_IMG_STYLE'] = $this->display_settings->get_namebar_img_style();
		$post_row['LCPD_NAMEBAR_TEXT_STYLE'] = $this->display_settings->get_namebar_text_style();
		$post_row['LCPD_TEXT_STYLE'] = $this->display_settings->get_text_style();

		$event['post_row'] = $post_row;
	}

	/**
	 * After the core postrow has been assigned, attach ribbon image blocks
	 * as a nested template block: postrow.lcpd_post_ribbons
	 *
	 * @param \phpbb\event\data $event
	 */
	public function viewtopic_post_row_after($event)
	{
		$row = $event['row'];

		$prefs = $this->get_user_display_prefs($row);

		if (!$prefs['show_ribbons'])
		{
			return;
		}

		$ribbon_ids = $this->get_user_ribbon_ids(isset($row['user_id']) ? (int) $row['user_id'] : 0);

		$this->load_badge_cache();

		foreach ($ribbon_ids as $index => $ribbon_id)
		{
			// 检查缓存是否存在
			if (!isset($this->ribbon_cache[$ribbon_id]))
			{
				continue;
			}

			$ribbon = $this->ribbon_cache[$ribbon_id];

			if (empty($ribbon['ribbon_image']))
			{
				continue;
			}

			$this->template->assign_block_vars('postrow.lcpd_post_ribbons', [
				'IMG_SRC'   => 'images/ribbons/' . $ribbon['ribbon_image'],
				'NAME'      => $ribbon['ribbon_name'],
				'INDEX'     => $ribbon_id,
				'IMG_STYLE' => $this->display_settings->get_ribbon_img_style(),
			]);
		}
	}

	/**
	 * Add badge number field to UCP profile edit page.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function ucp_profile_modify_profile_info($event)
	{
		$data = $event['data'];
		$user_id = (int) $this->user->data['user_id'];
		$ribbon_ids = $this->get_user_ribbon_ids($user_id);
		$ribbon_names = $this->get_ribbon_name_map($ribbon_ids);
		$has_shield = isset($this->user->data['user_lcpd_shield']) && (int) $this->user->data['user_lcpd_shield'] > 0;
		$has_namebar = isset($this->user->data['user_lcpd_namebar']) && (int) $this->user->data['user_lcpd_namebar'] > 0;
		$has_ribbons = !empty($ribbon_ids);

		if ($event['submit'])
		{
			$data['user_lcpd_badge_number'] = $this->request->variable('user_lcpd_badge_number', '', true);
		}
		else
		{
			$data['user_lcpd_badge_number'] = isset($this->user->data['user_lcpd_badge_number'])
				? (string) $this->user->data['user_lcpd_badge_number']
				: '';
		}

		$this->template->assign_vars([
			'USER_LCPD_BADGE_NUMBER' => (string) $data['user_lcpd_badge_number'],
			'S_LCPD_HAS_UCP_RIBBONS' => $has_ribbons,
			'S_LCPD_HAS_UCP_DISPLAY' => ($has_shield || $has_namebar || $has_ribbons),
			'S_LCPD_UCP_HAS_SHIELD' => $has_shield,
			'S_LCPD_UCP_HAS_NAMEBAR' => $has_namebar,
			'S_LCPD_UCP_HAS_RIBBONS' => $has_ribbons,
			'USER_LCPD_SHOW_SHIELD' => $has_shield
				? ($event['submit'] ? $this->request->variable('user_lcpd_show_shield', 0) : $this->get_ucp_display_pref('user_lcpd_show_shield'))
				: $this->get_ucp_display_pref('user_lcpd_show_shield'),
			'USER_LCPD_SHOW_RIBBONS' => $has_ribbons
				? ($event['submit'] ? $this->request->variable('user_lcpd_show_ribbons', 0) : $this->get_ucp_display_pref('user_lcpd_show_ribbons'))
				: $this->get_ucp_display_pref('user_lcpd_show_ribbons'),
			'USER_LCPD_SHOW_NAMEBAR' => $has_namebar
				? ($event['submit'] ? $this->request->variable('user_lcpd_show_namebar', 0) : $this->get_ucp_display_pref('user_lcpd_show_namebar'))
				: $this->get_ucp_display_pref('user_lcpd_show_namebar'),
		]);

		$position = 1;
		foreach ($ribbon_ids as $ribbon_id)
		{
			if (!isset($ribbon_names[$ribbon_id]))
			{
				continue;
			}

			$this->template->assign_block_vars('lcpd_ucp_ribbons', [
				'ID'       => $ribbon_id,
				'NAME'     => $ribbon_names[$ribbon_id],
				'POSITION' => $position++,
			]);
		}

		$event['data'] = $data;
	}

	/**
	 * Validate badge number in UCP profile edit.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function ucp_profile_validate_profile_info($event)
	{
		$errors = $event['error'];
		$badge_number = $this->request->variable('user_lcpd_badge_number', '', true);

		if (utf8_strlen($badge_number) > 64)
		{
			$errors[] = $this->language->lang('UCP_LCPD_BADGE_NUMBER_TOO_LONG');
		}

		$user_id = (int) $this->user->data['user_id'];
		$assigned = $this->get_user_ribbon_ids($user_id);
		$submitted = $this->normalize_ribbon_ids($this->request->variable('user_lcpd_ribbon_ids', [0]));

		if (!empty($assigned))
		{
			$assigned_sorted = $assigned;
			$submitted_sorted = $submitted;
			sort($assigned_sorted);
			sort($submitted_sorted);

			if ($assigned_sorted !== $submitted_sorted)
			{
				$errors[] = $this->language->lang('UCP_LCPD_RIBBON_ORDER_INVALID');
			}
		}

		$event['error'] = $errors;
	}

	/**
	 * Save badge number from UCP profile edit.
	 *
	 * @param \phpbb\event\data $event Event object
	 */
	public function ucp_profile_info_modify_sql_ary($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['user_lcpd_badge_number'] = $this->request->variable('user_lcpd_badge_number', '', true);

		$ribbon_ids = $this->normalize_ribbon_ids($this->request->variable('user_lcpd_ribbon_ids', [0]));
		$sql_ary['user_lcpd_ribbon'] = !empty($ribbon_ids) ? (int) $ribbon_ids[0] : 0;

		$this->save_user_ribbon_ids((int) $this->user->data['user_id'], $ribbon_ids);

		$assigned_ribbon_ids = $this->get_user_ribbon_ids((int) $this->user->data['user_id']);

		if (isset($this->user->data['user_lcpd_shield']) && (int) $this->user->data['user_lcpd_shield'] > 0)
		{
			$sql_ary['user_lcpd_show_shield'] = $this->request->variable('user_lcpd_show_shield', 0);
		}

		if (isset($this->user->data['user_lcpd_namebar']) && (int) $this->user->data['user_lcpd_namebar'] > 0)
		{
			$sql_ary['user_lcpd_show_namebar'] = $this->request->variable('user_lcpd_show_namebar', 0);
		}

		if (!empty($assigned_ribbon_ids))
		{
			$sql_ary['user_lcpd_show_ribbons'] = $this->request->variable('user_lcpd_show_ribbons', 0);
		}

		$event['sql_ary'] = $sql_ary;
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'siwode/lcpd',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Add a link to the controller in the forum navbar
	 */
	public function add_page_header_link($event)
	{
		global $user;

		$styles = $event['stylesheets'];
		$styles[] = 'ext/siwode/lcpd/styles/all/theme/lcpd.css';

		if (!empty($user->style['style_path']) && strtolower($user->style['style_path']) === 'ravaio')
		{
			$styles[] = 'ext/siwode/lcpd/styles/ravaio/theme/lcpd.css';
		}

		$event['stylesheets'] = $styles;

		$this->template->assign_vars([
			'U_LCPD_PAGE'		=> $this->helper->route('siwode_lcpd_controller', ['name' => 'world']),
			'LCPD_DISPLAY_CSS'	=> $this->display_settings->build_css_vars(),
		]);
	}

	/**
	 * Show users viewing LSPD论坛徽章 page on the Who Is Online page
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function viewonline_page($event)
	{
		if ($event['on_page'][1] === 'app' && strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/demo') === 0)
		{
			$event['location'] = $this->language->lang('VIEWING_SIWODE_LCPD');
			$event['location_url'] = $this->helper->route('siwode_lcpd_controller', ['name' => 'world']);
		}
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$event['forum_row'] = $forum_row;
	}

	/**
	 * Add permissions to the ACP -> Permissions settings page
	 * This is where permissions are assigned language keys and
	 * categories (where they will appear in the Permissions table):
	 * actions|content|forums|misc|permissions|pm|polls|post
	 * post_actions|posting|profile|settings|topic_actions|user_group
	 *
	 * Developers note: To control access to ACP, MCP and UCP modules, you
	 * must assign your permissions in your module_info.php file. For example,
	 * to allow only users with the a_new_siwode_lcpd permission
	 * access to your ACP module, you would set this in your acp/main_info.php:
	 *    'auth' => 'ext_siwode/lcpd && acl_a_new_siwode_lcpd'
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function add_permissions($event)
	{
		$permissions = $event['permissions'];

		$permissions['a_new_siwode_lcpd'] = ['lang' => 'ACL_A_NEW_SIWODE_LCPD', 'cat' => 'misc'];
		$permissions['m_new_siwode_lcpd'] = ['lang' => 'ACL_M_NEW_SIWODE_LCPD', 'cat' => 'post_actions'];
		$permissions['u_new_siwode_lcpd'] = ['lang' => 'ACL_U_NEW_SIWODE_LCPD', 'cat' => 'post'];

		$event['permissions'] = $permissions;
	}
}
