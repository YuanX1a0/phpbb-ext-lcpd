<?php
/**
 * Restore display size defaults to original v1.0.1 values.
 */

namespace siwode\lcpd\migrations;

class update_display_size_defaults extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\add_display_settings',
		];
	}

	public function update_data()
	{
		$data = [];

		foreach (\siwode\lcpd\service\display_settings::FIELDS as $field => $meta)
		{
			$data[] = ['config.update', ['siwode_lcpd_display_' . $field, (int) $meta['default']]];
		}

		return $data;
	}
}
