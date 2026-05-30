<?php
/**
 * Display size settings and ACP module for LCPD extension.
 */

namespace siwode\lcpd\migrations;

class add_display_settings extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\update_acp_modules',
		];
	}

	public function update_data()
	{
		$data = [];

		foreach (\siwode\lcpd\service\display_settings::FIELDS as $field => $meta)
		{
			$data[] = ['config.add', ['siwode_lcpd_display_' . $field, (int) $meta['default']]];
		}

		$data[] = ['module.add', [
			'acp',
			'ACP_LCPD_TITLE',
			[
				'module_basename' => '\\siwode\\lcpd\\acp\\main_module',
				'modes'           => ['display'],
			],
		]];

		return $data;
	}
}
