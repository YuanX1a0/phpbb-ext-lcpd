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

namespace siwode\lcpd\service;

/**
 * Badge display size settings stored in phpBB config.
 */
class display_settings
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var array Field definitions: default, min, max (px) */
	const FIELDS = [
		'wrap_max_width'              => ['default' => 160, 'min' => 40, 'max' => 500],
		'wrap_margin_v'               => ['default' => 4, 'min' => 0, 'max' => 50],
		'shield_max_width'            => ['default' => 48, 'min' => 8, 'max' => 300],
		'shield_max_height'           => ['default' => 48, 'min' => 8, 'max' => 300],
		'ribbon_max_width'            => ['default' => 28, 'min' => 8, 'max' => 200],
		'ribbon_max_height'           => ['default' => 20, 'min' => 8, 'max' => 200],
		'ribbon_gap'                  => ['default' => 2, 'min' => 0, 'max' => 20],
		'namebar_wrap_max_width'      => ['default' => 140, 'min' => 40, 'max' => 500],
		'namebar_img_max_width'       => ['default' => 120, 'min' => 20, 'max' => 400],
		'namebar_img_max_height'      => ['default' => 22, 'min' => 8, 'max' => 200],
		'text_font_size'              => ['default' => 16, 'min' => 6, 'max' => 36],
		'badge_number_top_pct'        => ['default' => 58, 'min' => 0, 'max' => 100],
		'badge_number_left_pct'       => ['default' => 50, 'min' => 0, 'max' => 100],
		'badge_number_font_size'      => ['default' => 17, 'min' => 6, 'max' => 36],
		'namebar_text_top_pct'        => ['default' => 50, 'min' => 0, 'max' => 100],
		'namebar_text_left_pct'       => ['default' => 50, 'min' => 0, 'max' => 100],
	];

	/**
	 * @param \phpbb\config\config $config
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	public static function get_fields()
	{
		return self::FIELDS;
	}

	/**
	 * @param string $field
	 * @return string
	 */
	public function get_config_key($field)
	{
		return 'siwode_lcpd_display_' . $field;
	}

	/**
	 * @return array
	 */
	public function get_all()
	{
		$values = [];

		foreach (self::FIELDS as $field => $meta)
		{
			$config_key = $this->get_config_key($field);
			$values[$field] = isset($this->config[$config_key])
				? (int) $this->config[$config_key]
				: (int) $meta['default'];
		}

		return $values;
	}

	/**
	 * @return array
	 */
	public function get_defaults()
	{
		$defaults = [];

		foreach (self::FIELDS as $field => $meta)
		{
			$defaults[$field] = (int) $meta['default'];
		}

		return $defaults;
	}

	/**
	 * Restore all display settings to built-in defaults.
	 *
	 * @return array Saved default values
	 */
	public function reset_to_defaults()
	{
		$defaults = $this->get_defaults();
		$this->save($defaults);

		return $defaults;
	}

	/**
	 * @param array $values
	 * @return void
	 */
	public function save(array $values)
	{
		foreach (self::FIELDS as $field => $meta)
		{
			if (!isset($values[$field]))
			{
				continue;
			}

			$this->config->set($this->get_config_key($field), (int) $values[$field]);
		}
	}

	/**
	 * @param array $values
	 * @return array List of invalid field keys
	 */
	public function get_invalid_fields(array $values)
	{
		$invalid = [];

		foreach (self::FIELDS as $field => $meta)
		{
			if (!isset($values[$field]))
			{
				$invalid[] = $field;
				continue;
			}

			$value = (int) $values[$field];

			if ($value < $meta['min'] || $value > $meta['max'])
			{
				$invalid[] = $field;
			}
		}

		return $invalid;
	}

	/**
	 * Inline style for shield images (beats theme CSS overrides).
	 *
	 * @return string
	 */
	public function get_shield_img_style()
	{
		$c = $this->get_all();

		return sprintf(
			'max-width:%1$dpx!important;max-height:%2$dpx!important;width:auto!important;height:auto!important;display:block!important;',
			$c['shield_max_width'],
			$c['shield_max_height']
		);
	}

	/**
	 * Inline style for ribbon images.
	 *
	 * @return string
	 */
	public function get_ribbon_img_style()
	{
		$c = $this->get_all();

		return sprintf(
			'max-width:%1$dpx!important;max-height:%2$dpx!important;width:auto!important;height:auto!important;display:block!important;',
			$c['ribbon_max_width'],
			$c['ribbon_max_height']
		);
	}

	/**
	 * Inline style for namebar images.
	 *
	 * @return string
	 */
	public function get_namebar_img_style()
	{
		$c = $this->get_all();

		return sprintf(
			'max-width:%1$dpx!important;max-height:%2$dpx!important;width:auto!important;height:auto!important;display:block!important;',
			$c['namebar_img_max_width'],
			$c['namebar_img_max_height']
		);
	}

	/**
	 * Inline style for badge wrapper.
	 *
	 * @return string
	 */
	public function get_wrap_style()
	{
		$c = $this->get_all();

		return sprintf(
			'max-width:%1$dpx!important;margin:%2$dpx auto!important;overflow:hidden!important;box-sizing:border-box!important;display:flex!important;flex-direction:column!important;align-items:center!important;',
			$c['wrap_max_width'],
			$c['wrap_margin_v']
		);
	}

	/**
	 * Inline style for shield container (badge number overlay).
	 *
	 * @return string
	 */
	public function get_shield_wrap_style()
	{
		return 'position:relative!important;display:inline-block!important;line-height:0!important;';
	}

	/**
	 * Inline style for badge number on shield (nametag reference styling).
	 *
	 * @return string
	 */
	public function get_badge_number_style()
	{
		$c = $this->get_all();

		return sprintf(
			'position:absolute!important;top:%1$d%%!important;left:%2$d%%!important;transform:translate(-50%%,-50%%)!important;font-size:%3$dpx!important;color:#22255B!important;font-family:Arial,Helvetica,sans-serif!important;font-weight:bold!important;text-transform:uppercase!important;text-align:center!important;line-height:1!important;white-space:nowrap!important;pointer-events:none!important;z-index:2!important;text-shadow:0 1px 0 rgba(255,255,255,.5)!important;margin:0!important;padding:0!important;',
			$c['badge_number_top_pct'],
			$c['badge_number_left_pct'],
			$c['badge_number_font_size']
		);
	}

	/**
	 * Inline style for namebar container.
	 *
	 * @return string
	 */
	public function get_namebar_wrap_style()
	{
		$c = $this->get_all();

		return sprintf(
			'max-width:%1$dpx!important;margin:2px 0!important;position:relative!important;display:inline-block!important;line-height:0!important;right:auto!important;box-sizing:border-box!important;',
			$c['namebar_wrap_max_width']
		);
	}

	/**
	 * Inline style for name text overlaid on the namebar image.
	 *
	 * @return string
	 */
	public function get_namebar_text_style()
	{
		$c = $this->get_all();

		return sprintf(
			'position:absolute!important;top:%1$d%%!important;left:%2$d%%!important;transform:translate(-50%%,-50%%)!important;width:92%%!important;text-align:center!important;line-height:1.2!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important;margin:0!important;padding:0!important;pointer-events:none!important;z-index:1!important;font-size:%3$dpx!important;color:#000!important;font-weight:bold!important;font-family:Arial,Helvetica,sans-serif!important;text-transform:uppercase!important;',
			$c['namebar_text_top_pct'],
			$c['namebar_text_left_pct'],
			$c['text_font_size']
		);
	}

	/**
	 * Inline style for printed name / badge number text.
	 *
	 * @return string
	 */
	public function get_text_style()
	{
		$c = $this->get_all();

		return sprintf(
			'font-size:%1$dpx!important;line-height:1.2!important;margin:0!important;font-weight:normal!important;word-break:break-word!important;',
			$c['text_font_size']
		);
	}

	/**
	 * Head CSS with !important rules for themes (e.g. ravaio) that override extension styles.
	 *
	 * @return string
	 */
	public function build_css_vars()
	{
		$c = $this->get_all();

		return sprintf(
			':root {
	--lcpd-wrap-max-width: %1$dpx;
	--lcpd-wrap-margin-v: %2$dpx;
	--lcpd-shield-max-width: %3$dpx;
	--lcpd-shield-max-height: %4$dpx;
	--lcpd-ribbon-max-width: %5$dpx;
	--lcpd-ribbon-max-height: %6$dpx;
	--lcpd-ribbon-gap: %7$dpx;
	--lcpd-namebar-wrap-max-width: %8$dpx;
	--lcpd-namebar-img-max-width: %9$dpx;
	--lcpd-namebar-img-max-height: %10$dpx;
	--lcpd-text-font-size: %11$dpx;
	--lcpd-badge-number-top-pct: %12$d%%;
	--lcpd-badge-number-left-pct: %13$d%%;
	--lcpd-badge-number-font-size: %14$dpx;
	--lcpd-namebar-text-top-pct: %15$d%%;
	--lcpd-namebar-text-left-pct: %16$d%%;
}
.lcpd-badge-wrap,
.postprofile .lcpd-badge-wrap,
.postauthor .lcpd-badge-wrap,
.poster-info .lcpd-badge-wrap,
.online .lcpd-badge-wrap {
	max-width: %1$dpx !important;
	margin: %2$dpx auto !important;
	overflow: hidden !important;
	box-sizing: border-box !important;
	display: flex !important;
	flex-direction: column !important;
	align-items: center !important;
}
.lcpd-badge-wrap .shieldboard,
.lcpd-badge-wrap .ribbons {
	width: auto !important;
	display: flex !important;
	flex-direction: column !important;
	align-items: center !important;
}
.lcpd-badge-wrap .ribbons {
	flex-direction: row !important;
	flex-wrap: wrap !important;
	justify-content: center !important;
}
.lcpd-badge-wrap .shieldboard .shield {
	position: relative !important;
	display: inline-block !important;
	line-height: 0 !important;
}
.lcpd-badge-wrap .shieldboard .shield img,
.lcpd-badge-wrap .shield img,
.postprofile .lcpd-badge-wrap img.shield-img,
.postprofile .shieldboard img {
	max-width: %3$dpx !important;
	max-height: %4$dpx !important;
	width: auto !important;
	height: auto !important;
}
.lcpd-badge-wrap .shieldboard .shield .lcpd-shield-number,
.lcpd-badge-wrap .lcpd-shield-number {
	position: absolute !important;
	top: %12$d%% !important;
	left: %13$d%% !important;
	transform: translate(-50%%, -50%%) !important;
	font-size: %14$dpx !important;
	color: #22255B !important;
	font-family: Arial, Helvetica, sans-serif !important;
	font-weight: bold !important;
	text-transform: uppercase !important;
	text-align: center !important;
	line-height: 1 !important;
	white-space: nowrap !important;
	text-shadow: 0 1px 0 rgba(255, 255, 255, .5) !important;
	pointer-events: none !important;
	z-index: 2 !important;
}
.lcpd-badge-wrap .ribbons img,
.postprofile .lcpd-badge-wrap .ribbons img {
	max-width: %5$dpx !important;
	max-height: %6$dpx !important;
	width: auto !important;
	height: auto !important;
}
.lcpd-badge-wrap .ribbons {
	gap: %7$dpx !important;
}
.lcpd-badge-wrap .namebar,
.postprofile .lcpd-badge-wrap .namebar {
	position: relative !important;
	display: inline-block !important;
	max-width: %8$dpx !important;
	right: auto !important;
	margin: 2px 0 !important;
	line-height: 0 !important;
}
.lcpd-badge-wrap .namebar img,
.lcpd-badge-wrap .namebar img.name,
.postprofile .namebar img {
	max-width: %9$dpx !important;
	max-height: %10$dpx !important;
	width: auto !important;
	height: auto !important;
}
.lcpd-badge-wrap .namebar .printedname,
.postprofile .lcpd-badge-wrap .namebar .printedname {
	position: absolute !important;
	top: %15$d%% !important;
	left: %16$d%% !important;
	transform: translate(-50%%, -50%%) !important;
	width: 92%% !important;
	max-width: 100%% !important;
	margin: 0 !important;
	padding: 0 !important;
	text-align: center !important;
	line-height: 1.2 !important;
	white-space: nowrap !important;
	overflow: hidden !important;
	text-overflow: ellipsis !important;
	pointer-events: none !important;
	z-index: 1 !important;
	font-size: %11$dpx !important;
	color: #000 !important;
	font-weight: bold !important;
	font-family: Arial, Helvetica, sans-serif !important;
	text-transform: uppercase !important;
}',
			$c['wrap_max_width'],
			$c['wrap_margin_v'],
			$c['shield_max_width'],
			$c['shield_max_height'],
			$c['ribbon_max_width'],
			$c['ribbon_max_height'],
			$c['ribbon_gap'],
			$c['namebar_wrap_max_width'],
			$c['namebar_img_max_width'],
			$c['namebar_img_max_height'],
			$c['text_font_size'],
			$c['badge_number_top_pct'],
			$c['badge_number_left_pct'],
			$c['badge_number_font_size'],
			$c['namebar_text_top_pct'],
			$c['namebar_text_left_pct']
		);
	}
}
