<?php
/**
 * Add user_lcpd_active flag to users table for LCPD extension
 */

namespace siwode\lcpd\migrations;

class add_user_lcpd_active extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_active');
	}

	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\add_user_badge_fields',
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_active' => ['BOOL', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_active',
				],
			],
		];
	}
}
