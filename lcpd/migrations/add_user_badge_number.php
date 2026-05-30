<?php
/**
 * Add badge number field for LCPD users
 */

namespace siwode\lcpd\migrations;

class add_user_badge_number extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_badge_number');
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
					'user_lcpd_badge_number' => ['VCHAR:64', ''],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_badge_number',
				],
			],
		];
	}
}
