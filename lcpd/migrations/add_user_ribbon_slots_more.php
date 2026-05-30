<?php
/**
 * Add additional ribbon slots (8-10) for users
 */

namespace siwode\lcpd\migrations;

class add_user_ribbon_slots_more extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		// Consider migration done if the highest new column exists
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_ribbon10');
	}

	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\add_user_ribbon_slots',
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_ribbon8' => ['UINT', 0],
					'user_lcpd_ribbon9' => ['UINT', 0],
					'user_lcpd_ribbon10' => ['UINT', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_ribbon8',
					'user_lcpd_ribbon9',
					'user_lcpd_ribbon10',
				],
			],
		];
	}
}
