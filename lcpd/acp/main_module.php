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
 * LSPD论坛徽章 ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/**
	 * Main ACP module
	 *
	 * @param int    $id   The module ID
	 * @param string $mode The module mode (for example: manage or settings)
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \siwode\lcpd\controller\acp_controller $acp_controller */
		$acp_controller = $phpbb_container->get('siwode.lcpd.controller.acp');

		switch ($mode)
		{
			case 'ribbons':
				$this->tpl_name = 'acp_lcpd_ribbons';
				$this->page_title = 'ACP_LCPD_RIBBON_MODULE';
				break;

			case 'namebars':
				$this->tpl_name = 'acp_lcpd_namebars';
				$this->page_title = 'ACP_LCPD_NAMEBAR_MODULE';
				break;

			case 'display':
				$this->tpl_name = 'acp_lcpd_display';
				$this->page_title = 'ACP_LCPD_DISPLAY_MODULE';
				break;

			case 'shield':
			default:
				$this->tpl_name = 'acp_lcpd_body';
				$this->page_title = 'ACP_LCPD_SHIELD_MODULE';
				break;
		}

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action);

		// Load the display options handle in our ACP controller based on mode
		switch ($mode)
		{
			case 'ribbons':
				$acp_controller->display_ribbons();
				break;

			case 'namebars':
				$acp_controller->display_namebars();
				break;

			case 'display':
				$acp_controller->display_display_settings();
				break;

			case 'shield':
			default:
				$acp_controller->display_options();
				break;
		}
	}
}
