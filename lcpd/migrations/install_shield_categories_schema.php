<?php
/**
 * Shield categories schema for LCPD extension
 */

namespace siwode\lcpd\migrations;

class install_shield_categories_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_shield_categories');
	}

	public static function depends_on()
	{
		return [
			'\\siwode\\lcpd\\migrations\\install_shields_schema',
		];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'siwode_lcpd_shield_categories' => [
					'COLUMNS' => [
						'category_id' => ['UINT', null, 'auto_increment'],
						'category_name' => ['VCHAR:255', ''],
					],
					'PRIMARY_KEY' => 'category_id',
				],
			],
			'add_columns' => [
				$this->table_prefix . 'siwode_lcpd_shields' => [
					'category_id' => ['UINT', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'siwode_lcpd_shields' => [
					'category_id',
				],
			],
			'drop_tables' => [
				$this->table_prefix . 'siwode_lcpd_shield_categories',
			],
		];
	}
}
