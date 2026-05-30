<?php
/**
 * Add user badge fields (shield/ribbon/namebar) to users table for LCPD extension
 */

namespace siwode\lcpd\migrations;

class add_user_badge_fields extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_shield')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_ribbon')
			&& $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_lcpd_namebar');
	}

	public static function depends_on()
	{
		return [
			'\\phpbb\\db\\migration\\data\\v320\\v320',
			'\\siwode\\lcpd\\migrations\\install_shields_schema',
			'\\siwode\\lcpd\\migrations\\install_ribbons_namebars_schema',
		];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_shield' => ['UINT', 0],
					'user_lcpd_ribbon' => ['UINT', 0],
					'user_lcpd_namebar' => ['UINT', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_lcpd_shield',
					'user_lcpd_ribbon',
					'user_lcpd_namebar',
				],
			],
		];
	}
}
