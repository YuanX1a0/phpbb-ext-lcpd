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

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_LCPD_TITLE'	=> 'LSPD论坛徽章 Module',
	'ACP_LCPD'			=> 'LSPD论坛徽章 Settings',

	'LOG_ACP_LCPD_SETTINGS'		=> '<strong>LSPD论坛徽章 settings updated</strong>',
	'LOG_ACP_LCPD_DISPLAY_SETTINGS'	=> '<strong>LSPD badge display size updated</strong> by %1$s',
	'LOG_ACP_LCPD_DISPLAY_RESET'	=> '<strong>LSPD badge display size restored to defaults</strong> by %1$s',
]);
