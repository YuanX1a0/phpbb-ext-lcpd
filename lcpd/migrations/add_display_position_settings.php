<?php
/**
 * Badge number / namebar text position settings for LCPD extension.
 */

namespace siwode\lcpd\migrations;

class add_display_position_settings extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\update_display_size_defaults',
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['siwode_lcpd_display_badge_number_top_pct', 58]],
			['config.add', ['siwode_lcpd_display_badge_number_left_pct', 50]],
			['config.add', ['siwode_lcpd_display_badge_number_font_size', 17]],
			['config.add', ['siwode_lcpd_display_namebar_text_top_pct', 50]],
			['config.add', ['siwode_lcpd_display_namebar_text_left_pct', 50]],
		];
	}
}
