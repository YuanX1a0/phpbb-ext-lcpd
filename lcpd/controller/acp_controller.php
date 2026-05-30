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

namespace siwode\lcpd\controller;

/**
 * LSPD论坛徽章 ACP controller.
 */
class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	protected $db;

	protected $shields_table;

	protected $shield_categories_table;

	protected $ribbons_table;

	protected $namebars_table;

	protected $ribbon_categories_table;

	protected $namebar_categories_table;

	/** @var \siwode\lcpd\service\display_settings */
	protected $display_settings;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\log\log			$log		Log object
	 * @param \phpbb\request\request	$request	Request object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user				$user		User object
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\language\language $language, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $shields_table, $shield_categories_table, $ribbons_table, $ribbon_categories_table, $namebars_table, $namebar_categories_table, \siwode\lcpd\service\display_settings $display_settings)
	{
		$this->config	= $config;
		$this->language	= $language;
		$this->log		= $log;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
		$this->db		= $db;
		$this->shields_table = $shields_table;
		$this->shield_categories_table = $shield_categories_table;
		$this->ribbons_table = $ribbons_table;
		$this->ribbon_categories_table = $ribbon_categories_table;
		$this->namebars_table = $namebars_table;
		$this->namebar_categories_table = $namebar_categories_table;
		$this->display_settings = $display_settings;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options()
	{
		// Add our common language file
		$this->language->add_lang('common', 'siwode/lcpd');

		// Internal view switch inside the Shield ACP module
		$view = $this->request->variable('view', '');

		// Create a form key for preventing CSRF attacks
		add_form_key('siwode_lcpd_acp');

		// Create an array to collect errors that will be output to the user
		$errors = [];

		$shield_name = $this->request->variable('shield_name', '', true);
		$shield_image = $this->request->variable('shield_image', '', true);
		$category_id = $this->request->variable('category_id', 0);
		$category_name = $this->request->variable('category_name', '', true);
		$category_name_quick = $this->request->variable('category_name_quick', '', true);
		$edit_shield_id = $this->request->variable('edit_shield_id', 0);
		$edit_shield_name = $this->request->variable('edit_shield_name', '', true);
		$edit_shield_image = $this->request->variable('edit_shield_image', '', true);
		$edit_category_id = $this->request->variable('edit_category_id', 0);
		$edit_category_name = $this->request->variable('edit_category_name', '', true);

		// Is the form being submitted to us?
		$is_add_shield = $this->request->is_set_post('add_shield');
		$is_delete_shield = $this->request->is_set_post('delete_shield');
		$is_add_category = $this->request->is_set_post('add_category');
		$is_delete_category = $this->request->is_set_post('delete_category');
		$is_edit_shield = $this->request->is_set_post('edit_shield');
		$is_edit_category = $this->request->is_set_post('edit_category');

		if ($is_add_shield || $is_delete_shield || $is_add_category || $is_delete_category || $is_edit_shield || $is_edit_category)
		{
			// Test if the submitted form is valid
			if (!check_form_key('siwode_lcpd_acp'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				if ($is_add_category)
				{
					$new_category_name = ($category_name !== '') ? $category_name : $category_name_quick;
					
					if ($new_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_CATEGORY_NAME');
					}
					
					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->shield_categories_table . ' ' . $this->db->sql_build_array('INSERT', [
							'category_name' => $new_category_name,
						]);
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_CATEGORY_ADDED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_delete_category)
				{
					$delete_category_id = $this->request->variable('delete_category', 0);

					if ($delete_category_id)
					{
						// Delete shields under this category first
						$sql = 'DELETE FROM ' . $this->shields_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);

						// Then delete the category
						$sql = 'DELETE FROM ' . $this->shield_categories_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_CATEGORY_DELETED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_edit_category)
				{
					if (!$edit_category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_CATEGORY_SELECTED');
					}

					if ($edit_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_CATEGORY_NAME');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->shield_categories_table . "
							SET category_name = '" . $this->db->sql_escape($edit_category_name) . "'
							WHERE category_id = " . (int) $edit_category_id;
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_CATEGORY_UPDATED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_add_shield)
				{
					if ($shield_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($shield_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (!$category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_CATEGORY');
					}

					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->shields_table . ' ' . $this->db->sql_build_array('INSERT', [
							'shield_name' => $shield_name,
							'shield_image' => $shield_image,
							'category_id' => (int) $category_id,
						]);
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_SHIELD_ADDED') . adm_back_link($this->u_action . '&view=shields'));
					}
				}
				else if ($is_delete_shield)
				{
					$delete_id = $this->request->variable('delete_shield', 0);

					if ($delete_id)
					{
						$sql = 'DELETE FROM ' . $this->shields_table . '
							WHERE shield_id = ' . (int) $delete_id;
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_SHIELD_DELETED') . adm_back_link($this->u_action . '&view=shields'));
					}
				}
				else if ($is_edit_shield)
				{
					if (!$edit_shield_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_SHIELD_SELECTED');
					}

					if ($edit_shield_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($edit_shield_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->shields_table . ' SET ' . $this->db->sql_build_array('UPDATE', [
							'shield_name' => $edit_shield_name,
							'shield_image' => $edit_shield_image,
						]) . '
							WHERE shield_id = ' . (int) $edit_shield_id;
						$this->db->sql_query($sql);
						
						trigger_error($this->language->lang('ACP_LCPD_SHIELD_UPDATED') . adm_back_link($this->u_action . '&view=shields'));
					}
				}
			}
		}

		$shield_images = [];
		global $phpbb_root_path;
		$images_dir = $phpbb_root_path . 'images/shield';

		if (is_dir($images_dir))
		{
			$dir = @opendir($images_dir);

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file[0] === '.' || !is_file($images_dir . '/' . $file))
					{
						continue;
					}

					$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

					if (!in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
					{
						continue;
					}

					$shield_images[] = $file;
				}

				closedir($dir);
			}
		}

		sort($shield_images);

		foreach ($shield_images as $file)
		{
			$this->template->assign_block_vars('shield_images', [
				'FILE' => $file,
			]);
		}

		// Load categories
		$sql = 'SELECT category_id, category_name
			FROM ' . $this->shield_categories_table . '
			ORDER BY category_id ASC';
		$result = $this->db->sql_query($sql);

		$categories = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$categories[(int) $row['category_id']] = $row['category_name'];
			$this->template->assign_block_vars('categories', [
				'CATEGORY_ID' => (int) $row['category_id'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		// Load shields with category names
		$sql = 'SELECT s.shield_id, s.shield_name, s.shield_image, s.category_id, c.category_name
			FROM ' . $this->shields_table . ' s
			LEFT JOIN ' . $this->shield_categories_table . ' c
				ON s.category_id = c.category_id
			ORDER BY s.shield_id ASC';
		$result = $this->db->sql_query($sql);
		
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($edit_shield_id && (int) $row['shield_id'] === (int) $edit_shield_id)
			{
				if ($edit_shield_name === '')
				{
					$edit_shield_name = $row['shield_name'];
				}
				
				if ($edit_shield_image === '')
				{
					$edit_shield_image = $row['shield_image'];
				}
			}
			
			$this->template->assign_block_vars('shields', [
				'SHIELD_ID' => (int) $row['shield_id'],
				'SHIELD_NAME' => $row['shield_name'],
				'SHIELD_IMAGE' => $row['shield_image'],
				'SHIELD_IMAGE_URL' => '../images/shield/' . $row['shield_image'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$s_errors = !empty($errors);
		
		// Set output variables for display in the template
		$this->template->assign_vars([
			'S_ERROR'		=> $s_errors,
			'ERROR_MSG'		=> $s_errors ? implode('<br>', $errors) : '',
			'U_ACTION'		=> $this->u_action,
			'SHIELD_NAME'	=> $shield_name,
			'SHIELD_IMAGE'	=> $shield_image,
			'CATEGORY_ID'	=> $category_id,
			'CATEGORY_NAME'	=> $category_name,
			'EDIT_SHIELD_ID'	=> $edit_shield_id,
			'EDIT_SHIELD_NAME'	=> $edit_shield_name,
			'EDIT_SHIELD_IMAGE'	=> $edit_shield_image,
			// Internal submenu view flags
			'S_LCPD_VIEW_INDEX'		=> ($view === ''),
			'S_LCPD_VIEW_CATEGORIES'	=> ($view === 'categories'),
			'S_LCPD_VIEW_SHIELDS'		=> ($view === 'shields'),
			'S_LCPD_VIEW_SHIELD_EDIT'	=> ($view === 'shield_edit'),
			'U_LCPD_VIEW_CATEGORIES'	=> $this->u_action . '&view=categories',
			'U_LCPD_VIEW_SHIELDS'		=> $this->u_action . '&view=shields',
		]);
	}

	public function display_ribbons()
	{
		$this->language->add_lang('common', 'siwode/lcpd');

		add_form_key('siwode_lcpd_ribbons');

		$errors = [];
		$view = $this->request->variable('view', '');

		$ribbon_name = $this->request->variable('ribbon_name', '', true);
		$ribbon_image = $this->request->variable('ribbon_image', '', true);
		$ribbon_category_id = $this->request->variable('ribbon_category_id', 0);
		$ribbon_category_name = $this->request->variable('ribbon_category_name', '', true);
		$edit_ribbon_id = $this->request->variable('edit_ribbon_id', 0);
		$edit_ribbon_name = $this->request->variable('edit_ribbon_name', '', true);
		$edit_ribbon_image = $this->request->variable('edit_ribbon_image', '', true);
		$edit_ribbon_category_id = $this->request->variable('edit_ribbon_category_id', 0);
		$edit_ribbon_category_name = $this->request->variable('edit_ribbon_category_name', '', true);

		$is_add_ribbon = $this->request->is_set_post('add_ribbon');
		$is_delete_ribbon = $this->request->is_set_post('delete_ribbon');
		$is_add_category = $this->request->is_set_post('add_ribbon_category');
		$is_delete_category = $this->request->is_set_post('delete_ribbon_category');
		$is_edit_ribbon = $this->request->is_set_post('edit_ribbon');
		$is_edit_category = $this->request->is_set_post('edit_ribbon_category');

		if ($is_add_ribbon || $is_delete_ribbon || $is_add_category || $is_delete_category || $is_edit_ribbon || $is_edit_category)
		{
			if (!check_form_key('siwode_lcpd_ribbons'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			if (empty($errors))
			{
				if ($is_add_category)
				{
					if ($ribbon_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_NAME');
					}

					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->ribbon_categories_table . ' ' . $this->db->sql_build_array('INSERT', [
							'category_name' => $ribbon_category_name,
						]);
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_RIBBON_CATEGORY_ADDED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_delete_category)
				{
					$delete_category_id = $this->request->variable('delete_ribbon_category', 0);

					if ($delete_category_id)
					{
						$sql = 'DELETE FROM ' . $this->ribbons_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);

						$sql = 'DELETE FROM ' . $this->ribbon_categories_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_RIBBON_CATEGORY_DELETED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_edit_category)
				{
					if (!$edit_ribbon_category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_SELECTED');
					}

					if ($edit_ribbon_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_NAME');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->ribbon_categories_table . "
							SET category_name = '" . $this->db->sql_escape($edit_ribbon_category_name) . "'
							WHERE category_id = " . (int) $edit_ribbon_category_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_RIBBON_CATEGORY_UPDATED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_add_ribbon)
				{
					if ($ribbon_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($ribbon_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (!$ribbon_category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_RIBBON_CATEGORY');
					}

					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->ribbons_table . ' ' . $this->db->sql_build_array('INSERT', [
							'ribbon_name' => $ribbon_name,
							'ribbon_image' => $ribbon_image,
							'category_id' => (int) $ribbon_category_id,
						]);
						$this->db->sql_query($sql);
						trigger_error($this->language->lang('ACP_LCPD_RIBBON_ADDED') . adm_back_link($this->u_action . '&view=ribbons'));
					}
				}
				else if ($is_delete_ribbon)
				{
					$delete_id = $this->request->variable('delete_ribbon', 0);

					if ($delete_id)
					{
						$sql = 'DELETE FROM ' . $this->ribbons_table . '
							WHERE ribbon_id = ' . (int) $delete_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_RIBBON_DELETED') . adm_back_link($this->u_action . '&view=ribbons'));
					}
				}
				else if ($is_edit_ribbon)
				{
					if (!$edit_ribbon_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_RIBBON_SELECTED');
					}

					if ($edit_ribbon_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($edit_ribbon_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->ribbons_table . ' SET ' . $this->db->sql_build_array('UPDATE', [
							'ribbon_name' => $edit_ribbon_name,
							'ribbon_image' => $edit_ribbon_image,
						]) . '
							WHERE ribbon_id = ' . (int) $edit_ribbon_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_RIBBON_UPDATED') . adm_back_link($this->u_action . '&view=ribbons'));
					}
				}
			}
		}

		$ribbon_images = [];
		global $phpbb_root_path;
		$images_dir = $phpbb_root_path . 'images/ribbons';

		if (is_dir($images_dir))
		{
			$dir = @opendir($images_dir);

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file[0] === '.' || !is_file($images_dir . '/' . $file))
					{
						continue;
					}

					$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

					if (!in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
					{
						continue;
					}

					$ribbon_images[] = $file;
				}

				closedir($dir);
			}
		}

		sort($ribbon_images);

		foreach ($ribbon_images as $file)
		{
			$this->template->assign_block_vars('ribbon_images', [
				'FILE' => $file,
			]);
		}

		$sql = 'SELECT category_id, category_name
			FROM ' . $this->ribbon_categories_table . '
			ORDER BY category_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('ribbon_categories', [
				'CATEGORY_ID' => (int) $row['category_id'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT r.ribbon_id, r.ribbon_name, r.ribbon_image, r.category_id, c.category_name
			FROM ' . $this->ribbons_table . ' r
			LEFT JOIN ' . $this->ribbon_categories_table . ' c
				ON r.category_id = c.category_id
			ORDER BY r.ribbon_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($edit_ribbon_id && (int) $row['ribbon_id'] === (int) $edit_ribbon_id)
			{
				if ($edit_ribbon_name === '')
				{
					$edit_ribbon_name = $row['ribbon_name'];
				}
				
				if ($edit_ribbon_image === '')
				{
					$edit_ribbon_image = $row['ribbon_image'];
				}
			}
			
			$this->template->assign_block_vars('ribbons', [
				'RIBBON_ID' => (int) $row['ribbon_id'],
				'RIBBON_NAME' => $row['ribbon_name'],
				'RIBBON_IMAGE' => $row['ribbon_image'],
				'RIBBON_IMAGE_URL' => '../images/ribbons/' . $row['ribbon_image'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$s_errors = !empty($errors);

		$this->template->assign_vars([
			'S_ERROR' => $s_errors,
			'ERROR_MSG' => $s_errors ? implode('<br>', $errors) : '',
			'U_ACTION' => $this->u_action,
			'RIBBON_NAME' => $ribbon_name,
			'RIBBON_IMAGE' => $ribbon_image,
			'RIBBON_CATEGORY_ID' => $ribbon_category_id,
			'RIBBON_CATEGORY_NAME' => $ribbon_category_name,
			'EDIT_RIBBON_ID' => $edit_ribbon_id,
			'EDIT_RIBBON_NAME' => $edit_ribbon_name,
			'EDIT_RIBBON_IMAGE' => $edit_ribbon_image,
			'EDIT_RIBBON_CATEGORY_ID' => $edit_ribbon_category_id,
			'EDIT_RIBBON_CATEGORY_NAME' => $edit_ribbon_category_name,
			'S_LCPD_RIBBONS_VIEW_INDEX' => ($view === ''),
			'S_LCPD_RIBBONS_VIEW_CATEGORIES' => ($view === 'categories'),
			'S_LCPD_RIBBONS_VIEW_MAIN' => ($view === 'ribbons'),
			'S_LCPD_RIBBONS_VIEW_EDIT' => ($view === 'ribbon_edit'),
			'U_LCPD_RIBBONS_VIEW_CATEGORIES' => $this->u_action . '&view=categories',
			'U_LCPD_RIBBONS_VIEW_MAIN' => $this->u_action . '&view=ribbons',
		]);
	}

	public function display_namebars()
	{
		$this->language->add_lang('common', 'siwode/lcpd');

		add_form_key('siwode_lcpd_namebars');

		$errors = [];
		$view = $this->request->variable('view', '');

		$namebar_name = $this->request->variable('namebar_name', '', true);
		$namebar_image = $this->request->variable('namebar_image', '', true);
		$namebar_category_id = $this->request->variable('namebar_category_id', 0);
		$namebar_category_name = $this->request->variable('namebar_category_name', '', true);
		$edit_namebar_id = $this->request->variable('edit_namebar_id', 0);
		$edit_namebar_name = $this->request->variable('edit_namebar_name', '', true);
		$edit_namebar_image = $this->request->variable('edit_namebar_image', '', true);
		$edit_namebar_category_id = $this->request->variable('edit_namebar_category_id', 0);
		$edit_namebar_category_name = $this->request->variable('edit_namebar_category_name', '', true);

		$is_add_namebar = $this->request->is_set_post('add_namebar');
		$is_delete_namebar = $this->request->is_set_post('delete_namebar');
		$is_add_category = $this->request->is_set_post('add_namebar_category');
		$is_delete_category = $this->request->is_set_post('delete_namebar_category');
		$is_edit_namebar = $this->request->is_set_post('edit_namebar');
		$is_edit_category = $this->request->is_set_post('edit_namebar_category');

		if ($is_add_namebar || $is_delete_namebar || $is_add_category || $is_delete_category || $is_edit_namebar || $is_edit_category)
		{
			if (!check_form_key('siwode_lcpd_namebars'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			if (empty($errors))
			{
				if ($is_add_category)
				{
					if ($namebar_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_NAME');
					}

					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->namebar_categories_table . ' ' . $this->db->sql_build_array('INSERT', [
							'category_name' => $namebar_category_name,
						]);
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_CATEGORY_ADDED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_delete_category)
				{
					$delete_category_id = $this->request->variable('delete_namebar_category', 0);

					if ($delete_category_id)
					{
						$sql = 'DELETE FROM ' . $this->namebars_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);

						$sql = 'DELETE FROM ' . $this->namebar_categories_table . '
							WHERE category_id = ' . (int) $delete_category_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_CATEGORY_DELETED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_edit_category)
				{
					if (!$edit_namebar_category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_SELECTED');
					}

					if ($edit_namebar_category_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_NAME');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->namebar_categories_table . "
							SET category_name = '" . $this->db->sql_escape($edit_namebar_category_name) . "'
							WHERE category_id = " . (int) $edit_namebar_category_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_CATEGORY_UPDATED') . adm_back_link($this->u_action . '&view=categories'));
					}
				}
				else if ($is_add_namebar)
				{
					if ($namebar_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($namebar_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (!$namebar_category_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY');
					}

					if (empty($errors))
					{
						$sql = 'INSERT INTO ' . $this->namebars_table . ' ' . $this->db->sql_build_array('INSERT', [
							'namebar_name' => $namebar_name,
							'namebar_image' => $namebar_image,
							'category_id' => (int) $namebar_category_id,
						]);
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_ADDED') . adm_back_link($this->u_action . '&view=namebars'));
					}
				}
				else if ($is_delete_namebar)
				{
					$delete_id = $this->request->variable('delete_namebar', 0);

					if ($delete_id)
					{
						$sql = 'DELETE FROM ' . $this->namebars_table . '
							WHERE namebar_id = ' . (int) $delete_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_DELETED') . adm_back_link($this->u_action . '&view=namebars'));
					}
				}
				else if ($is_edit_namebar)
				{
					if (!$edit_namebar_id)
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAMEBAR_SELECTED');
					}

					if ($edit_namebar_name === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_NAME');
					}

					if ($edit_namebar_image === '')
					{
						$errors[] = $this->language->lang('ACP_LCPD_ERROR_NO_IMAGE');
					}

					if (empty($errors))
					{
						$sql = 'UPDATE ' . $this->namebars_table . ' SET ' . $this->db->sql_build_array('UPDATE', [
							'namebar_name' => $edit_namebar_name,
							'namebar_image' => $edit_namebar_image,
						]) . '
							WHERE namebar_id = ' . (int) $edit_namebar_id;
						$this->db->sql_query($sql);

						trigger_error($this->language->lang('ACP_LCPD_NAMEBAR_UPDATED') . adm_back_link($this->u_action . '&view=namebars'));
					}
				}
			}
		}

		$namebar_images = [];
		global $phpbb_root_path;
		$images_dir = $phpbb_root_path . 'images/namebar';

		if (is_dir($images_dir))
		{
			$dir = @opendir($images_dir);

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file[0] === '.' || !is_file($images_dir . '/' . $file))
					{
						continue;
					}

					$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

					if (!in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp']))
					{
						continue;
					}

					$namebar_images[] = $file;
				}

				closedir($dir);
			}
		}

		sort($namebar_images);

		foreach ($namebar_images as $file)
		{
			$this->template->assign_block_vars('namebar_images', [
				'FILE' => $file,
			]);
		}

		$sql = 'SELECT category_id, category_name
			FROM ' . $this->namebar_categories_table . '
			ORDER BY category_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('namebar_categories', [
				'CATEGORY_ID' => (int) $row['category_id'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT n.namebar_id, n.namebar_name, n.namebar_image, n.category_id, c.category_name
			FROM ' . $this->namebars_table . ' n
			LEFT JOIN ' . $this->namebar_categories_table . ' c
				ON n.category_id = c.category_id
			ORDER BY n.namebar_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($edit_namebar_id && (int) $row['namebar_id'] === (int) $edit_namebar_id)
			{
				if ($edit_namebar_name === '')
				{
					$edit_namebar_name = $row['namebar_name'];
				}
				
				if ($edit_namebar_image === '')
				{
					$edit_namebar_image = $row['namebar_image'];
				}
			}
			
			$this->template->assign_block_vars('namebars', [
				'NAMEBAR_ID' => (int) $row['namebar_id'],
				'NAMEBAR_NAME' => $row['namebar_name'],
				'NAMEBAR_IMAGE' => $row['namebar_image'],
				'NAMEBAR_IMAGE_URL' => '../images/namebar/' . $row['namebar_image'],
				'CATEGORY_NAME' => $row['category_name'],
			]);
		}
		$this->db->sql_freeresult($result);

		$s_errors = !empty($errors);

		$this->template->assign_vars([
			'S_ERROR' => $s_errors,
			'ERROR_MSG' => $s_errors ? implode('<br>', $errors) : '',
			'U_ACTION' => $this->u_action,
			'NAMEBAR_NAME' => $namebar_name,
			'NAMEBAR_IMAGE' => $namebar_image,
			'NAMEBAR_CATEGORY_ID' => $namebar_category_id,
			'NAMEBAR_CATEGORY_NAME' => $namebar_category_name,
			'EDIT_NAMEBAR_ID' => $edit_namebar_id,
			'EDIT_NAMEBAR_NAME' => $edit_namebar_name,
			'EDIT_NAMEBAR_IMAGE' => $edit_namebar_image,
			'EDIT_NAMEBAR_CATEGORY_ID' => $edit_namebar_category_id,
			'EDIT_NAMEBAR_CATEGORY_NAME' => $edit_namebar_category_name,
			'S_LCPD_NAMEBARS_VIEW_INDEX' => ($view === ''),
			'S_LCPD_NAMEBARS_VIEW_CATEGORIES' => ($view === 'categories'),
			'S_LCPD_NAMEBARS_VIEW_MAIN' => ($view === 'namebars'),
			'S_LCPD_NAMEBARS_VIEW_EDIT' => ($view === 'namebar_edit'),
			'U_LCPD_NAMEBARS_VIEW_CATEGORIES' => $this->u_action . '&view=categories',
			'U_LCPD_NAMEBARS_VIEW_MAIN' => $this->u_action . '&view=namebars',
		]);
	}

	/**
	 * Display badge size settings in ACP.
	 *
	 * @return void
	 */
	public function display_display_settings()
	{
		$this->language->add_lang(['common', 'info_acp_lcpd'], 'siwode/lcpd');

		add_form_key('siwode_lcpd_display');

		$errors = [];
		$values = $this->display_settings->get_all();

		if ($this->request->is_set_post('reset_defaults'))
		{
			if (!check_form_key('siwode_lcpd_display'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}
			else
			{
				$values = $this->display_settings->reset_to_defaults();

				$this->log->add(
					'admin',
					$this->user->data['user_id'],
					$this->user->ip,
					'LOG_ACP_LCPD_DISPLAY_RESET',
					false,
					[$this->user->data['username']]
				);

				trigger_error($this->language->lang('ACP_LCPD_DISPLAY_RESET') . adm_back_link($this->u_action));
			}
		}
		else if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('siwode_lcpd_display'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}
			else
			{
				$input = [];

				foreach (array_keys(\siwode\lcpd\service\display_settings::FIELDS) as $field)
				{
					$input[$field] = $this->request->variable('lcpd_' . $field, 0);
				}

				$invalid = $this->display_settings->get_invalid_fields($input);

				if (!empty($invalid))
				{
					foreach ($invalid as $field)
					{
						$meta = \siwode\lcpd\service\display_settings::FIELDS[$field];
						$errors[] = $this->language->lang(
							'ACP_LCPD_DISPLAY_INVALID',
							$this->language->lang('ACP_LCPD_DISPLAY_' . strtoupper($field)),
							$meta['min'],
							$meta['max']
						);
					}
				}
				else
				{
					$this->display_settings->save($input);

					$this->log->add(
						'admin',
						$this->user->data['user_id'],
						$this->user->ip,
						'LOG_ACP_LCPD_DISPLAY_SETTINGS',
						false,
						[$this->user->data['username']]
					);

					trigger_error($this->language->lang('ACP_LCPD_DISPLAY_SAVED') . adm_back_link($this->u_action));
				}

				$values = $input;
			}
		}

		$template_vars = [
			'S_ERROR'   => !empty($errors),
			'ERROR_MSG' => !empty($errors) ? implode('<br>', $errors) : '',
			'U_ACTION'  => $this->u_action,
		];

		foreach ($values as $field => $value)
		{
			$template_vars['LCPD_' . strtoupper($field)] = (int) $value;
		}

		$this->template->assign_vars($template_vars);
	}

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
