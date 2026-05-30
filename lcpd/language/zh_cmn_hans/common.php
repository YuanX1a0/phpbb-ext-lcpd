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

	'LCPD_HELLO'		=> '你好 %s！',
	'LCPD_GOODBYE'		=> '再见 %s！',

	'LCPD_EVENT'		=> ' :: Lcpd 事件 :: ',

	'ACP_LCPD_GOODBYE'			=> '是否在页面上说再见？',
	'ACP_LCPD_SETTING_SAVED'	=> '设置已成功保存。',

	'ACP_LCPD_SHIELD_MANAGE'	=> 'Shield 管理',
	'ACP_LCPD_SHIELD_EXPLAIN'	=> '在这里你可以创建和删除 Shield 记录。图片从 images/shield 目录读取。',
	'ACP_LCPD_SHIELD_NAME'	=> 'Shield 名称',
	'ACP_LCPD_SHIELD_IMAGE'	=> 'Shield 图片',
	'ACP_LCPD_ADD_SHIELD'	=> '添加 Shield',
	'ACP_LCPD_NO_SHIELDS'	=> '当前还没有任何 Shield。',
	'ACP_LCPD_SHIELD_ADDED'	=> 'Shield 已成功添加。',
	'ACP_LCPD_SHIELD_DELETED'	=> 'Shield 已成功删除。',
	'ACP_LCPD_ERROR_NO_NAME'	=> '必须填写 Shield 名称。',
	'ACP_LCPD_ERROR_NO_IMAGE'	=> '必须选择一张 Shield 图片。',
	'ACP_LCPD_CATEGORY_MANAGE'	=> '分类管理',
	'ACP_LCPD_CATEGORY_EXPLAIN'	=> '请先创建分类，然后在分类中添加 Shield。',
	'ACP_LCPD_CATEGORY_NAME'	=> '分类名称',
	'ACP_LCPD_ADD_CATEGORY'	=> '添加分类',
	'ACP_LCPD_NO_CATEGORIES'	=> '当前还没有任何分类。',
	'ACP_LCPD_CATEGORY_ADDED'	=> '分类已成功添加。',
	'ACP_LCPD_CATEGORY_DELETED'	=> '分类及其下的所有 Shield 已被删除。',
	'ACP_LCPD_ERROR_NO_CATEGORY_NAME'	=> '必须填写分类名称。',
	'ACP_LCPD_ERROR_NO_CATEGORY'	=> '必须为该 Shield 选择一个分类。',

	'ACP_LCPD_SHIELD_MODULE'	=> 'Shield 管理',
	'ACP_LCPD_RIBBON_MODULE'	=> 'Ribbons 管理',
	'ACP_LCPD_NAMEBAR_MODULE'	=> 'Namebar 管理',

	'ACP_LCPD_RIBBON_MANAGE'	=> 'Ribbons 管理',
	'ACP_LCPD_RIBBON_EXPLAIN'	=> '在这里你可以创建和删除 Ribbon 记录。图片从 images/ribbons 目录读取。',
	'ACP_LCPD_RIBBON_NAME'	=> 'Ribbon 名称',
	'ACP_LCPD_RIBBON_IMAGE'	=> 'Ribbon 图片',
	'ACP_LCPD_ADD_RIBBON'	=> '添加 Ribbon',
	'ACP_LCPD_NO_RIBBONS'	=> '当前还没有任何 Ribbon。',
	'ACP_LCPD_RIBBON_ADDED'	=> 'Ribbon 已成功添加。',
	'ACP_LCPD_RIBBON_DELETED'	=> 'Ribbon 已成功删除。',
	'ACP_LCPD_RIBBON_CATEGORY_MANAGE'	=> 'Ribbon 分类管理',
	'ACP_LCPD_RIBBON_CATEGORY_EXPLAIN'	=> '请先创建 Ribbon 分类，然后在分类中添加 Ribbon。',
	'ACP_LCPD_ADD_RIBBON_CATEGORY'	=> '添加 Ribbon 分类',
	'ACP_LCPD_NO_RIBBON_CATEGORIES'	=> '当前还没有任何 Ribbon 分类。',
	'ACP_LCPD_RIBBON_CATEGORY_ADDED'	=> 'Ribbon 分类已成功添加。',
	'ACP_LCPD_RIBBON_CATEGORY_DELETED'	=> 'Ribbon 分类及其下的所有 Ribbon 已被删除。',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_NAME'	=> '必须填写 Ribbon 分类名称。',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY'	=> '必须为该 Ribbon 选择一个分类。',

	'ACP_LCPD_NAMEBAR_MANAGE'	=> 'Namebar 管理',
	'ACP_LCPD_NAMEBAR_EXPLAIN'	=> '在这里你可以创建和删除 Namebar 记录。图片从 images/namebar 目录读取。',
	'ACP_LCPD_NAMEBAR_NAME'	=> 'Namebar 名称',
	'ACP_LCPD_NAMEBAR_IMAGE'	=> 'Namebar 图片',
	'ACP_LCPD_ADD_NAMEBAR'	=> '添加 Namebar',
	'ACP_LCPD_NO_NAMEBARS'	=> '当前还没有任何 Namebar。',
	'ACP_LCPD_NAMEBAR_ADDED'	=> 'Namebar 已成功添加。',
	'ACP_LCPD_NAMEBAR_DELETED'	=> 'Namebar 已成功删除。',
	'ACP_LCPD_NAMEBAR_CATEGORY_MANAGE'	=> 'Namebar 分类管理',
	'ACP_LCPD_NAMEBAR_CATEGORY_EXPLAIN'	=> '请先创建 Namebar 分类，然后在分类中添加 Namebar。',
	'ACP_LCPD_ADD_NAMEBAR_CATEGORY'	=> '添加 Namebar 分类',
	'ACP_LCPD_NO_NAMEBAR_CATEGORIES'	=> '当前还没有任何 Namebar 分类。',
	'ACP_LCPD_NAMEBAR_CATEGORY_ADDED'	=> 'Namebar 分类已成功添加。',
	'ACP_LCPD_NAMEBAR_CATEGORY_DELETED'	=> 'Namebar 分类及其下的所有 Namebar 已被删除。',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_NAME'	=> '必须填写 Namebar 分类名称。',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY'	=> '必须为该 Namebar 选择一个分类。',

	'ACP_LCPD_EDIT_CATEGORY'	=> '编辑分类',
	'ACP_LCPD_CATEGORY_UPDATED'	=> '分类已成功更新。',
	'ACP_LCPD_ERROR_NO_CATEGORY_SELECTED'	=> '必须先选择要编辑的分类。',

	'ACP_LCPD_EDIT_SHIELD'	=> '编辑 Shield',
	'ACP_LCPD_SHIELD_UPDATED'	=> 'Shield 已成功更新。',
	'ACP_LCPD_ERROR_NO_SHIELD_SELECTED'	=> '必须先选择要编辑的 Shield。',

	'ACP_LCPD_EDIT_RIBBON_CATEGORY'	=> '编辑 Ribbon 分类',
	'ACP_LCPD_RIBBON_CATEGORY_UPDATED'	=> 'Ribbon 分类已成功更新。',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_SELECTED'	=> '必须先选择要编辑的 Ribbon 分类。',
	'ACP_LCPD_EDIT_RIBBON'	=> '编辑 Ribbon',
	'ACP_LCPD_RIBBON_UPDATED'	=> 'Ribbon 已成功更新。',
	'ACP_LCPD_ERROR_NO_RIBBON_SELECTED'	=> '必须先选择要编辑的 Ribbon。',

	'ACP_LCPD_EDIT_NAMEBAR_CATEGORY'	=> '编辑 Namebar 分类',
	'ACP_LCPD_NAMEBAR_CATEGORY_UPDATED'	=> 'Namebar 分类已成功更新。',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_SELECTED'	=> '必须先选择要编辑的 Namebar 分类。',
	'ACP_LCPD_EDIT_NAMEBAR'	=> '编辑 Namebar',
	'ACP_LCPD_NAMEBAR_UPDATED'	=> 'Namebar 已成功更新。',
	'ACP_LCPD_ERROR_NO_NAMEBAR_SELECTED'	=> '必须先选择要编辑的 Namebar。',

	'ACP_LCPD_USER_BADGES'	=> 'LSPD 徽章设置',
	'ACP_LCPD_USER_SHIELD'	=> '阶级',
	'ACP_LCPD_USER_BADGE_NUMBER' => '编号',
	'ACP_LCPD_USER_RIBBON'	=> '略章',
	'ACP_LCPD_USER_RIBBON1'	=> '略章1',
	'ACP_LCPD_USER_RIBBON2'	=> '略章2',
	'ACP_LCPD_USER_RIBBON3'	=> '略章3',
	'ACP_LCPD_USER_RIBBON4'	=> '略章4',
	'ACP_LCPD_USER_RIBBON5'	=> '略章5',
	'ACP_LCPD_USER_RIBBON6'	=> '略章6',
	'ACP_LCPD_USER_RIBBON7'	=> '略章7',
	'ACP_LCPD_USER_RIBBON8'	=> '略章8',
	'ACP_LCPD_USER_RIBBON9'	=> '略章9',
	'ACP_LCPD_USER_RIBBON10'	=> '略章10',
	'ACP_LCPD_USER_NAMEBAR'	=> '框标',
	'ACP_LCPD_USER_ACTIVE'	=> '是否现役',
	'ACP_LCPD_USER_NONE'	=> '无',

	'ACP_LCPD_DISPLAY_MODULE'	=> '显示尺寸',
	'ACP_LCPD_DISPLAY_EXPLAIN'	=> '在此调整前台帖子作者区徽章的显示大小（单位：像素）。保存后刷新帖子页即可预览，无需编辑配置文件。',
	'ACP_LCPD_DISPLAY_SAVED'	=> '显示尺寸已保存。',
	'ACP_LCPD_DISPLAY_RESET'	=> '显示尺寸已恢复为默认值。',
	'ACP_LCPD_DISPLAY_RESET_DEFAULTS'	=> '恢复默认值',
	'ACP_LCPD_DISPLAY_INVALID'	=> '「%1$s」的数值无效，请输入 %2$d 到 %3$d 之间的整数。',
	'ACP_LCPD_DISPLAY_GENERAL'	=> '整体区域',
	'ACP_LCPD_DISPLAY_SHIELD'	=> '盾牌 (Shield)',
	'ACP_LCPD_DISPLAY_RIBBON'	=> '略章 (Ribbon)',
	'ACP_LCPD_DISPLAY_NAMEBAR'	=> '框标 (Namebar)',
	'ACP_LCPD_DISPLAY_TEXT'	=> '文字',
	'ACP_LCPD_DISPLAY_WRAP_MAX_WIDTH'	=> '区域最大宽度',
	'ACP_LCPD_DISPLAY_WRAP_MAX_WIDTH_EXPLAIN'	=> '整个徽章区块的最大宽度。',
	'ACP_LCPD_DISPLAY_WRAP_MARGIN_V'	=> '区域上下边距',
	'ACP_LCPD_DISPLAY_WRAP_MARGIN_V_EXPLAIN'	=> '徽章区块与上下内容的间距。',
	'ACP_LCPD_DISPLAY_SHIELD_MAX_WIDTH'	=> '盾牌最大宽度',
	'ACP_LCPD_DISPLAY_SHIELD_MAX_HEIGHT'	=> '盾牌最大高度',
	'ACP_LCPD_DISPLAY_RIBBON_MAX_WIDTH'	=> '略章最大宽度',
	'ACP_LCPD_DISPLAY_RIBBON_MAX_HEIGHT'	=> '略章最大高度',
	'ACP_LCPD_DISPLAY_RIBBON_GAP'	=> '略章间距',
	'ACP_LCPD_DISPLAY_NAMEBAR_WRAP_MAX_WIDTH'	=> '框标容器最大宽度',
	'ACP_LCPD_DISPLAY_NAMEBAR_IMG_MAX_WIDTH'	=> '框标图片最大宽度',
	'ACP_LCPD_DISPLAY_NAMEBAR_IMG_MAX_HEIGHT'	=> '框标图片最大高度',
	'ACP_LCPD_DISPLAY_TEXT_FONT_SIZE'	=> '名牌姓名字号',
	'ACP_LCPD_DISPLAY_TEXT_FONT_SIZE_EXPLAIN'	=> '显示在名牌图片上的姓名文字大小（参考 nametag：16px 粗体）。',
	'ACP_LCPD_DISPLAY_POSITION'	=> '文字位置',
	'ACP_LCPD_DISPLAY_POSITION_EXPLAIN'	=> '调整编号在盾牌上、姓名在名牌上的位置（百分比，50 表示居中）。',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_TOP_PCT'	=> '编号垂直位置',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_LEFT_PCT'	=> '编号水平位置',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_FONT_SIZE'	=> '编号字号',
	'ACP_LCPD_DISPLAY_NAMEBAR_TEXT_TOP_PCT'	=> '姓名垂直位置',
	'ACP_LCPD_DISPLAY_NAMEBAR_TEXT_LEFT_PCT'	=> '姓名水平位置',

	'UCP_LCPD_BADGE_NUMBER'	=> '警徽编号',
	'UCP_LCPD_BADGE_NUMBER_EXPLAIN'	=> '填写你的警徽编号，将显示在盾牌徽章上。留空则不显示。',
	'UCP_LCPD_BADGE_NUMBER_TOO_LONG'	=> '警徽编号不能超过 64 个字符。',
	'UCP_LCPD_DISPLAY'	=> '徽章显示',
	'UCP_LCPD_DISPLAY_EXPLAIN'	=> '选择是否在帖子侧栏显示已分配的警徽、略章和名牌。管理员「是否现役」仍会影响整体是否显示。',
	'UCP_LCPD_SHOW_SHIELD'	=> '显示警徽（盾牌）',
	'UCP_LCPD_SHOW_RIBBONS'	=> '显示略章',
	'UCP_LCPD_SHOW_NAMEBAR'	=> '显示名牌',
	'UCP_LCPD_RIBBON_ORDER'	=> '略章排序',
	'UCP_LCPD_RIBBON_ORDER_EXPLAIN'	=> '使用按钮调整已分配略章的显示顺序。此处不能添加或删除略章。',
	'UCP_LCPD_RIBBON_MOVE_UP'	=> '上移',
	'UCP_LCPD_RIBBON_MOVE_DOWN'	=> '下移',
	'UCP_LCPD_RIBBON_ORDER_INVALID'	=> '提交的略章排序无效。',

	'SIWODE_LCPD_NOTIFICATION'	=> 'LSPD论坛徽章 通知',

	'LCPD_PAGE'			=> 'Lcpd 页面',
	'VIEWING_SIWODE_LCPD'		=> '正在查看 LSPD论坛徽章 页面',

]);
