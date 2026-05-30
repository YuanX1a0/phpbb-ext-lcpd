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

	'LCPD_HELLO'		=> 'Hello %s!',
	'LCPD_GOODBYE'		=> 'Goodbye %s!',

	'LCPD_EVENT'		=> ' :: Lcpd Event :: ',

	'ACP_LCPD_GOODBYE'			=> 'Should say goodbye?',
	'ACP_LCPD_SETTING_SAVED'	=> 'Settings have been saved successfully!',

	'ACP_LCPD_SHIELD_MANAGE'	=> 'Manage shields',
	'ACP_LCPD_SHIELD_EXPLAIN'	=> 'Here you can create and delete shield entries. Images are read from the images/shield directory.',
	'ACP_LCPD_SHIELD_NAME'	=> 'Shield name',
	'ACP_LCPD_SHIELD_IMAGE'	=> 'Shield image',
	'ACP_LCPD_ADD_SHIELD'	=> 'Add shield',
	'ACP_LCPD_NO_SHIELDS'	=> 'No shields have been created yet.',
	'ACP_LCPD_SHIELD_ADDED'	=> 'Shield has been added successfully.',
	'ACP_LCPD_SHIELD_DELETED'	=> 'Shield has been deleted successfully.',
	'ACP_LCPD_ERROR_NO_NAME'	=> 'You must enter a shield name.',
	'ACP_LCPD_ERROR_NO_IMAGE'	=> 'You must select a shield image.',
	'ACP_LCPD_CATEGORY_MANAGE'	=> 'Manage shield categories',
	'ACP_LCPD_CATEGORY_EXPLAIN'	=> 'Create categories first, then assign shields into categories.',
	'ACP_LCPD_CATEGORY_NAME'	=> 'Category name',
	'ACP_LCPD_ADD_CATEGORY'	=> 'Add category',
	'ACP_LCPD_NO_CATEGORIES'	=> 'No categories have been created yet.',
	'ACP_LCPD_CATEGORY_ADDED'	=> 'Category has been added successfully.',
	'ACP_LCPD_CATEGORY_DELETED'	=> 'Category and its shields have been deleted successfully.',
	'ACP_LCPD_ERROR_NO_CATEGORY_NAME'	=> 'You must enter a category name.',
	'ACP_LCPD_ERROR_NO_CATEGORY'	=> 'You must select a category for this shield.',

	'ACP_LCPD_SHIELD_MODULE'	=> 'Shield management',
	'ACP_LCPD_RIBBON_MODULE'	=> 'Ribbon management',
	'ACP_LCPD_NAMEBAR_MODULE'	=> 'Namebar management',

	'ACP_LCPD_RIBBON_MANAGE'	=> 'Manage ribbons',
	'ACP_LCPD_RIBBON_EXPLAIN'	=> 'Here you can create and delete ribbon entries. Images are read from the images/ribbons directory.',
	'ACP_LCPD_RIBBON_NAME'	=> 'Ribbon name',
	'ACP_LCPD_RIBBON_IMAGE'	=> 'Ribbon image',
	'ACP_LCPD_ADD_RIBBON'	=> 'Add ribbon',
	'ACP_LCPD_NO_RIBBONS'	=> 'No ribbons have been created yet.',
	'ACP_LCPD_RIBBON_ADDED'	=> 'Ribbon has been added successfully.',
	'ACP_LCPD_RIBBON_DELETED'	=> 'Ribbon has been deleted successfully.',
	'ACP_LCPD_RIBBON_CATEGORY_MANAGE'	=> 'Manage ribbon categories',
	'ACP_LCPD_RIBBON_CATEGORY_EXPLAIN'	=> 'Create ribbon categories first, then assign ribbons into categories.',
	'ACP_LCPD_ADD_RIBBON_CATEGORY'	=> 'Add ribbon category',
	'ACP_LCPD_NO_RIBBON_CATEGORIES'	=> 'No ribbon categories have been created yet.',
	'ACP_LCPD_RIBBON_CATEGORY_ADDED'	=> 'Ribbon category has been added successfully.',
	'ACP_LCPD_RIBBON_CATEGORY_DELETED'	=> 'Ribbon category and its ribbons have been deleted successfully.',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_NAME'	=> 'You must enter a ribbon category name.',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY'	=> 'You must select a category for this ribbon.',

	'ACP_LCPD_NAMEBAR_MANAGE'	=> 'Manage namebars',
	'ACP_LCPD_NAMEBAR_EXPLAIN'	=> 'Here you can create and delete namebar entries. Images are read from the images/namebar directory.',
	'ACP_LCPD_NAMEBAR_NAME'	=> 'Namebar name',
	'ACP_LCPD_NAMEBAR_IMAGE'	=> 'Namebar image',
	'ACP_LCPD_ADD_NAMEBAR'	=> 'Add namebar',
	'ACP_LCPD_NO_NAMEBARS'	=> 'No namebars have been created yet.',
	'ACP_LCPD_NAMEBAR_ADDED'	=> 'Namebar has been added successfully.',
	'ACP_LCPD_NAMEBAR_DELETED'	=> 'Namebar has been deleted successfully.',
	'ACP_LCPD_NAMEBAR_CATEGORY_MANAGE'	=> 'Manage namebar categories',
	'ACP_LCPD_NAMEBAR_CATEGORY_EXPLAIN'	=> 'Create namebar categories first, then assign namebars into categories.',
	'ACP_LCPD_ADD_NAMEBAR_CATEGORY'	=> 'Add namebar category',
	'ACP_LCPD_NO_NAMEBAR_CATEGORIES'	=> 'No namebar categories have been created yet.',
	'ACP_LCPD_NAMEBAR_CATEGORY_ADDED'	=> 'Namebar category has been added successfully.',
	'ACP_LCPD_NAMEBAR_CATEGORY_DELETED'	=> 'Namebar category and its namebars have been deleted successfully.',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_NAME'	=> 'You must enter a namebar category name.',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY'	=> 'You must select a category for this namebar.',

	'ACP_LCPD_EDIT_CATEGORY'	=> 'Edit category',
	'ACP_LCPD_CATEGORY_UPDATED'	=> 'Category has been updated successfully.',
	'ACP_LCPD_ERROR_NO_CATEGORY_SELECTED'	=> 'You must select a category to edit.',

	'ACP_LCPD_EDIT_SHIELD'	=> 'Edit shield',
	'ACP_LCPD_SHIELD_UPDATED'	=> 'Shield has been updated successfully.',
	'ACP_LCPD_ERROR_NO_SHIELD_SELECTED'	=> 'You must select a shield to edit.',

	'ACP_LCPD_EDIT_RIBBON_CATEGORY'	=> 'Edit ribbon category',
	'ACP_LCPD_RIBBON_CATEGORY_UPDATED'	=> 'Ribbon category has been updated successfully.',
	'ACP_LCPD_ERROR_NO_RIBBON_CATEGORY_SELECTED'	=> 'You must select a ribbon category to edit.',
	'ACP_LCPD_EDIT_RIBBON'	=> 'Edit ribbon',
	'ACP_LCPD_RIBBON_UPDATED'	=> 'Ribbon has been updated successfully.',
	'ACP_LCPD_ERROR_NO_RIBBON_SELECTED'	=> 'You must select a ribbon to edit.',

	'ACP_LCPD_EDIT_NAMEBAR_CATEGORY'	=> 'Edit namebar category',
	'ACP_LCPD_NAMEBAR_CATEGORY_UPDATED'	=> 'Namebar category has been updated successfully.',
	'ACP_LCPD_ERROR_NO_NAMEBAR_CATEGORY_SELECTED'	=> 'You must select a namebar category to edit.',
	'ACP_LCPD_EDIT_NAMEBAR'	=> 'Edit namebar',
	'ACP_LCPD_NAMEBAR_UPDATED'	=> 'Namebar has been updated successfully.',
	'ACP_LCPD_ERROR_NO_NAMEBAR_SELECTED'	=> 'You must select a namebar to edit.',

	'ACP_LCPD_USER_BADGES'	=> 'LCPD badges',
	'ACP_LCPD_USER_SHIELD'	=> 'Shield',
	'ACP_LCPD_USER_RIBBON'	=> 'Ribbon',
	'ACP_LCPD_USER_RIBBON1'	=> 'Ribbon 1',
	'ACP_LCPD_USER_RIBBON2'	=> 'Ribbon 2',
	'ACP_LCPD_USER_RIBBON3'	=> 'Ribbon 3',
	'ACP_LCPD_USER_RIBBON4'	=> 'Ribbon 4',
	'ACP_LCPD_USER_RIBBON5'	=> 'Ribbon 5',
	'ACP_LCPD_USER_RIBBON6'	=> 'Ribbon 6',
	'ACP_LCPD_USER_RIBBON7'	=> 'Ribbon 7',
	'ACP_LCPD_USER_RIBBON8'	=> 'Ribbon 8',
	'ACP_LCPD_USER_RIBBON9'	=> 'Ribbon 9',
	'ACP_LCPD_USER_RIBBON10'	=> 'Ribbon 10',
	'ACP_LCPD_USER_NAMEBAR'	=> 'Namebar',
	'ACP_LCPD_USER_ACTIVE'	=> 'Active duty',
	'ACP_LCPD_USER_NONE'	=> 'None',

	'ACP_LCPD_DISPLAY_MODULE'	=> 'Display size',
	'ACP_LCPD_DISPLAY_EXPLAIN'	=> 'Adjust badge display sizes in the post author area (pixels). Save and refresh a topic page to preview.',
	'ACP_LCPD_DISPLAY_SAVED'	=> 'Display size settings saved.',
	'ACP_LCPD_DISPLAY_RESET'	=> 'Display size settings restored to defaults.',
	'ACP_LCPD_DISPLAY_RESET_DEFAULTS'	=> 'Restore defaults',
	'ACP_LCPD_DISPLAY_INVALID'	=> 'Invalid value for “%1$s”. Enter an integer between %2$d and %3$d.',
	'ACP_LCPD_DISPLAY_GENERAL'	=> 'General area',
	'ACP_LCPD_DISPLAY_SHIELD'	=> 'Shield',
	'ACP_LCPD_DISPLAY_RIBBON'	=> 'Ribbon',
	'ACP_LCPD_DISPLAY_NAMEBAR'	=> 'Namebar',
	'ACP_LCPD_DISPLAY_TEXT'	=> 'Text',
	'ACP_LCPD_DISPLAY_WRAP_MAX_WIDTH'	=> 'Area max width',
	'ACP_LCPD_DISPLAY_WRAP_MAX_WIDTH_EXPLAIN'	=> 'Maximum width of the whole badge block.',
	'ACP_LCPD_DISPLAY_WRAP_MARGIN_V'	=> 'Area vertical margin',
	'ACP_LCPD_DISPLAY_WRAP_MARGIN_V_EXPLAIN'	=> 'Space above and below the badge block.',
	'ACP_LCPD_DISPLAY_SHIELD_MAX_WIDTH'	=> 'Shield max width',
	'ACP_LCPD_DISPLAY_SHIELD_MAX_HEIGHT'	=> 'Shield max height',
	'ACP_LCPD_DISPLAY_RIBBON_MAX_WIDTH'	=> 'Ribbon max width',
	'ACP_LCPD_DISPLAY_RIBBON_MAX_HEIGHT'	=> 'Ribbon max height',
	'ACP_LCPD_DISPLAY_RIBBON_GAP'	=> 'Ribbon gap',
	'ACP_LCPD_DISPLAY_NAMEBAR_WRAP_MAX_WIDTH'	=> 'Namebar container max width',
	'ACP_LCPD_DISPLAY_NAMEBAR_IMG_MAX_WIDTH'	=> 'Namebar image max width',
	'ACP_LCPD_DISPLAY_NAMEBAR_IMG_MAX_HEIGHT'	=> 'Namebar image max height',
	'ACP_LCPD_DISPLAY_TEXT_FONT_SIZE'	=> 'Namebar name font size',
	'ACP_LCPD_DISPLAY_TEXT_FONT_SIZE_EXPLAIN'	=> 'Font size for the name on the namebar image (nametag style: 16px bold).',
	'ACP_LCPD_DISPLAY_POSITION'	=> 'Text position',
	'ACP_LCPD_DISPLAY_POSITION_EXPLAIN'	=> 'Adjust badge number on shield and name on namebar (percent, 50 = centered).',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_TOP_PCT'	=> 'Badge number vertical position',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_LEFT_PCT'	=> 'Badge number horizontal position',
	'ACP_LCPD_DISPLAY_BADGE_NUMBER_FONT_SIZE'	=> 'Badge number font size',
	'ACP_LCPD_DISPLAY_NAMEBAR_TEXT_TOP_PCT'	=> 'Name vertical position',
	'ACP_LCPD_DISPLAY_NAMEBAR_TEXT_LEFT_PCT'	=> 'Name horizontal position',

	'UCP_LCPD_SECTION_TITLE'	=> 'LSPD badge settings',
	'UCP_LCPD_SECTION_EXPLAIN'	=> 'Manage how your shield, ribbons and namebar appear in post profiles.',
	'UCP_LCPD_BADGE_NUMBER'	=> 'Badge number',
	'UCP_LCPD_BADGE_NUMBER_EXPLAIN'	=> 'Enter your badge number to display on the shield. Leave blank to hide.',
	'UCP_LCPD_BADGE_NUMBER_PLACEHOLDER'	=> 'e.g. 02764',
	'UCP_LCPD_BADGE_NUMBER_TOO_LONG'	=> 'Badge number must not exceed 64 characters.',
	'UCP_LCPD_DISPLAY'	=> 'Badge display',
	'UCP_LCPD_DISPLAY_EXPLAIN'	=> 'Choose whether to show your assigned shield, ribbons and namebar in post profiles. Admin “active duty” still controls overall visibility.',
	'UCP_LCPD_SHOW_SHIELD'	=> 'Show shield badge',
	'UCP_LCPD_SHOW_RIBBONS'	=> 'Show ribbons',
	'UCP_LCPD_SHOW_NAMEBAR'	=> 'Show namebar',
	'UCP_LCPD_STATUS_ON'	=> 'ON',
	'UCP_LCPD_STATUS_OFF'	=> 'OFF',
	'UCP_LCPD_RIBBON_ORDER'	=> 'Ribbon order',
	'UCP_LCPD_RIBBON_ORDER_EXPLAIN'	=> 'Use the buttons to change the display order of your assigned ribbons. You cannot add or remove ribbons here.',
	'UCP_LCPD_RIBBON_MOVE_UP'	=> 'Move up',
	'UCP_LCPD_RIBBON_MOVE_DOWN'	=> 'Move down',
	'UCP_LCPD_RIBBON_ORDER_INVALID'	=> 'Invalid ribbon order submitted.',

	'SIWODE_LCPD_NOTIFICATION'	=> 'LSPD论坛徽章 notification',

	'LCPD_PAGE'			=> 'Lcpd Page',
	'VIEWING_SIWODE_LCPD'			=> 'Viewing LSPD论坛徽章 page',

]);
