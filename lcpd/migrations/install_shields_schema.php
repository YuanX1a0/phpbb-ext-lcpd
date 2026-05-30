<?php

namespace siwode\lcpd\migrations;

class install_shields_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_shields');
	}

	public static function depends_on()
	{
		return ['\\phpbb\\db\\migration\\data\\v320\\v320'];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'siwode_lcpd_shields' => [
					'COLUMNS' => [
						'shield_id' => ['UINT', null, 'auto_increment'],
						'shield_name' => ['VCHAR:255', ''],
						'shield_image' => ['VCHAR:255', ''],
					],
					'PRIMARY_KEY' => 'shield_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'siwode_lcpd_shields',
			],
		];
	}
}
