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

namespace siwode\lcpd\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['siwode_lcpd_goodbye']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

	public function update_data()
	{
		return [
			['config.add', ['siwode_lcpd_goodbye', 0]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_LCPD_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_LCPD_TITLE',
				[
					'module_basename'	=> '\siwode\lcpd\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
