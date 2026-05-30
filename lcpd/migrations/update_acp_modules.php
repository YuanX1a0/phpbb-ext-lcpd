<?php
/**
 * Update ACP modules for LCPD extension: add shield/ribbons/namebars modes.
 */

namespace siwode\lcpd\migrations;

class update_acp_modules extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\install_acp_module',
		];
	}

	public function update_data()
	{
		return [
			// Remove old single "settings" submodule if it exists
			['module.remove', [
				'acp',
				'ACP_LCPD_TITLE',
				[
					'module_basename' => '\\siwode\\lcpd\\acp\\main_module',
					'modes' => ['settings'],
				],
			]],

			// Add new submodules for shield, ribbons and namebars
			['module.add', [
				'acp',
				'ACP_LCPD_TITLE',
				[
					'module_basename' => '\\siwode\\lcpd\\acp\\main_module',
					'modes' => ['shield'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_LCPD_TITLE',
				[
					'module_basename' => '\\siwode\\lcpd\\acp\\main_module',
					'modes' => ['ribbons'],
				],
			]],
			['module.add', [
				'acp',
				'ACP_LCPD_TITLE',
				[
					'module_basename' => '\\siwode\\lcpd\\acp\\main_module',
					'modes' => ['namebars'],
				],
			]],
		];
	}
}
