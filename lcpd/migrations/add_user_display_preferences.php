<?php
/**
 * Add per-user display toggles for shield, ribbons and namebar (UCP).
 */

namespace siwode\lcpd\migrations;

class add_user_display_preferences extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_show_shield');
	}

	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\add_display_position_settings',
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_show_shield'  => ['BOOL', 1],
					'user_lcpd_show_ribbons' => ['BOOL', 1],
					'user_lcpd_show_namebar' => ['BOOL', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_show_shield',
					'user_lcpd_show_ribbons',
					'user_lcpd_show_namebar',
				],
			],
		];
	}
}
