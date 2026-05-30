<?php
/**
 * Ribbons and Namebars schema for LCPD extension
 */

namespace siwode\lcpd\migrations;

class install_ribbons_namebars_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_ribbons')
			&& $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_ribbon_categories')
			&& $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_namebars')
			&& $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_namebar_categories');
	}

	public static function depends_on()
	{
		return [
			'\\phpbb\\db\\migration\\data\\v320\\v320',
		];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'siwode_lcpd_ribbon_categories' => [
					'COLUMNS' => [
						'category_id' => ['UINT', null, 'auto_increment'],
						'category_name' => ['VCHAR:255', ''],
					],
					'PRIMARY_KEY' => 'category_id',
				],
				$this->table_prefix . 'siwode_lcpd_ribbons' => [
					'COLUMNS' => [
						'ribbon_id' => ['UINT', null, 'auto_increment'],
						'ribbon_name' => ['VCHAR:255', ''],
						'ribbon_image' => ['VCHAR:255', ''],
						'category_id' => ['UINT', 0],
					],
					'PRIMARY_KEY' => 'ribbon_id',
				],
				$this->table_prefix . 'siwode_lcpd_namebar_categories' => [
					'COLUMNS' => [
						'category_id' => ['UINT', null, 'auto_increment'],
						'category_name' => ['VCHAR:255', ''],
					],
					'PRIMARY_KEY' => 'category_id',
				],
				$this->table_prefix . 'siwode_lcpd_namebars' => [
					'COLUMNS' => [
						'namebar_id' => ['UINT', null, 'auto_increment'],
						'namebar_name' => ['VCHAR:255', ''],
						'namebar_image' => ['VCHAR:255', ''],
						'category_id' => ['UINT', 0],
					],
					'PRIMARY_KEY' => 'namebar_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'siwode_lcpd_ribbons',
				$this->table_prefix . 'siwode_lcpd_ribbon_categories',
				$this->table_prefix . 'siwode_lcpd_namebars',
				$this->table_prefix . 'siwode_lcpd_namebar_categories',
			],
		];
	}
}
