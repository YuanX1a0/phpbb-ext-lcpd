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

// 所有语言文件应使用 UTF-8 编码且不包含 BOM。

$lang = array_merge($lang, [
	'ACP_LCPD_TITLE'	=> 'LSPD论坛徽章 模块',
	'ACP_LCPD'		=> 'LSPD论坛徽章 设置',

	'LOG_ACP_LCPD_SETTINGS'	=> '<strong>已更新 LSPD论坛徽章 设置</strong>',
	'LOG_ACP_LCPD_DISPLAY_SETTINGS'	=> '<strong>已更新 LSPD论坛徽章 显示尺寸</strong>（作者：%1$s）',
	'LOG_ACP_LCPD_DISPLAY_RESET'	=> '<strong>已恢复 LSPD论坛徽章 显示尺寸为默认值</strong>（作者：%1$s）',
]);
