<?php
/**
 * User-ribbons relation schema for LCPD extension
 */

namespace siwode\lcpd\migrations;

class install_user_ribbons_schema extends \phpbb\db\migration\migration
{
    public function effectively_installed()
    {
        return $this->db_tools->sql_table_exists($this->table_prefix . 'siwode_lcpd_user_ribbons');
    }

    public static function depends_on()
    {
        return [
            '\\siwode\\lcpd\\migrations\\install_ribbons_namebars_schema',
        ];
    }

    public function update_schema()
    {
        return [
            'add_tables' => [
                $this->table_prefix . 'siwode_lcpd_user_ribbons' => [
                    'COLUMNS' => [
                        'user_id'    => ['UINT', 0],
                        'ribbon_id'  => ['UINT', 0],
                        'sort_order' => ['UINT', 0],
                    ],
                    'PRIMARY_KEY' => ['user_id', 'sort_order'],
                    'KEYS' => [
                        'ribbon_id' => ['INDEX', 'ribbon_id'],
                    ],
                ],
            ],
        ];
    }

    public function revert_schema()
    {
        return [
            'drop_tables' => [
                $this->table_prefix . 'siwode_lcpd_user_ribbons',
            ],
        ];
    }
}
