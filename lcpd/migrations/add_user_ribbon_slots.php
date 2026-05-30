<?php
/**
 * Add multiple ribbon slots for users
 */

namespace siwode\lcpd\migrations;

class add_user_ribbon_slots extends \phpbb\db\migration\migration
{
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
                    'user_lcpd_ribbon1' => ['UINT', 0],
                    'user_lcpd_ribbon2' => ['UINT', 0],
                    'user_lcpd_ribbon3' => ['UINT', 0],
                    'user_lcpd_ribbon4' => ['UINT', 0],
                    'user_lcpd_ribbon5' => ['UINT', 0],
                    'user_lcpd_ribbon6' => ['UINT', 0],
                    'user_lcpd_ribbon7' => ['UINT', 0],
                ],
            ],
        ];
    }

    public function revert_schema()
    {
        return [
            'drop_columns' => [
                $this->table_prefix . 'users' => [
                    'user_lcpd_ribbon1',
                    'user_lcpd_ribbon2',
                    'user_lcpd_ribbon3',
                    'user_lcpd_ribbon4',
                    'user_lcpd_ribbon5',
                    'user_lcpd_ribbon6',
                    'user_lcpd_ribbon7',
                ],
            ],
        ];
    }
}
