<?php

declare(strict_types=1);

use App\System\Model\SystemMenu;
use App\System\Model\SystemRole;
use App\System\Model\SystemRoleMenu;
use App\System\Model\SystemUser;
use App\System\Model\SystemUserRole;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class Permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRoleId = env('SUPER_ADMIN_ROLE_ID', 1);
        $superAdminUserId = env('SUPER_ADMIN_USER_ID', 1);

        $datetime = date('Y-m-d H:i:s');

        Db::table('system_menu')->truncate();
        Db::table('system_role')->truncate();
        Db::table('system_role_menu')->truncate();
        Db::table('system_user')->truncate();
        Db::table('system_user_role')->truncate();

        $menuData = [
            [1000, 0, '0', 'menu.dashboard', 'Dashboard', 'icon-dashboard', 'dashboard', '', NULL, 1, 1, 100, $datetime, $datetime, NULL, NULL],
            [1001, 1000, '0,1000', 'menu.dashboard.workplace', 'Workplace', 'icon-computer', 'workplace', '', NULL, 1, 1, 0, $datetime, $datetime, NULL, NULL],
            [1002, 1000, '0,1000', 'menu.dashboard.userInfo', 'UserInfo', 'icon-user', 'userInfo', '', NULL, 1, 2, 0, $datetime, $datetime, NULL, NULL],

            [1100, 0, '0', 'menu.system', 'System', 'icon-lock', 'system', '', NULL, 1, 1, 99, $datetime, $datetime, NULL, NULL],
            [1101, 1100, '0,1100', 'menu.system.user', 'SystemUser', 'icon-user-group', 'user', '', NULL, 1, 1, 0, $datetime, $datetime, NULL, NULL],
            [1102, 1100, '0,1100', 'menu.system.role', 'SystemRole', 'icon-user-add', 'role', '', NULL, 1, 1, 0, $datetime, $datetime, NULL, NULL],
            [1103, 1100, '0,1100', 'menu.system.menu', 'SystemMenu', 'icon-menu', 'menu', '', NULL, 1, 1, 0, $datetime, $datetime, NULL, NULL],

            [1200, 0, '0', 'menu.tools', 'Tools', 'icon-tool', 'tools', '', NULL, 1, 1, 98, $datetime, $datetime, NULL, NULL],
            [1201, 1200, '0,1200', 'menu.tools.generateCode', 'ToolsGenerateCode', 'icon-code', 'generateCode', '', NULL, 1, 1, 0, $datetime, $datetime, NULL, NULL],
        ];

        $roleMenuData = [];
        foreach ($menuData as $menuDatum) {
            $roleMenuData[] = [$superAdminRoleId, $menuDatum[0]];
        }

        $data = [
            SystemMenu::class => $menuData,
            SystemRoleMenu::class => $roleMenuData,
            SystemRole::class => [
                [$superAdminRoleId, '超级管理员', 'SuperAdmin', 1, 0, $datetime, $datetime, NULL],
            ],
            SystemUser::class => [
                [$superAdminUserId, 'admin', password_hash('123456', PASSWORD_DEFAULT), '超级管理员', NULL, NULL, '', 1, NULL, NULL, $datetime, $datetime, NULL],
            ],
            SystemUserRole::class => [
                [$superAdminUserId, $superAdminRoleId]
            ]
        ];

        foreach ($data as $modelClass => $modelData) {
            $insertData = $this->buildInsertData($this->getTableName($modelClass), $modelData);
            foreach ($insertData as $insertItem) {
                Db::insert($insertItem);
            }
        }
    }

    protected function buildInsertData($table_name, array $data): array
    {
        $sqlData = [];
        foreach ($data as $datum) {
            foreach ($datum as &$val) {
                if (is_string($val)) {
                    $val = "'" . $val . "'";
                } elseif ($val === NULL) {
                    $val = 'NULL';
                }
            }
            $sqlData[] = "INSERT INTO `{$table_name}` VALUES (" . implode(',', $datum) . ")";
        }
        return $sqlData;
    }

    protected function getTableName($model): string
    {
        /**
         * @var Model $model
         */
        return env('DB_PREFIX') . $model::getModel()->getTable();
    }
}
