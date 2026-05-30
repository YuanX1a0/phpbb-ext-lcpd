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

namespace siwode\lcpd\acp;

/**
 * LSPD论坛徽章 ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\\siwode\\lcpd\\acp\\main_module',
			'title'		=> 'ACP_LCPD_TITLE',
			'modes'		=> [
				'shield'	=> [
					'title'	=> 'ACP_LCPD_SHIELD_MODULE',
					'auth'	=> 'ext_siwode/lcpd && acl_a_new_siwode_lcpd',
					'cat'	=> ['ACP_LCPD_TITLE'],
				],
				'ribbons'	=> [
					'title'	=> 'ACP_LCPD_RIBBON_MODULE',
					'auth'	=> 'ext_siwode/lcpd && acl_a_new_siwode_lcpd',
					'cat'	=> ['ACP_LCPD_TITLE'],
				],
				'namebars'	=> [
					'title'	=> 'ACP_LCPD_NAMEBAR_MODULE',
					'auth'	=> 'ext_siwode/lcpd && acl_a_new_siwode_lcpd',
					'cat'	=> ['ACP_LCPD_TITLE'],
				],
				'display'	=> [
					'title'	=> 'ACP_LCPD_DISPLAY_MODULE',
					'auth'	=> 'ext_siwode/lcpd && acl_a_new_siwode_lcpd',
					'cat'	=> ['ACP_LCPD_TITLE'],
				],
			],
		];
	}
}
