<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */
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
            [1000, 0, '0', 'menu.dashboard', 'Dashboard', 'icon-dashboard', 'dashboard', '', null, 1, 1, 100, null, $datetime, $datetime, null],
            [1001, 1000, '0,1000', 'menu.dashboard.workplace', 'Workplace', '', 'workplace', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1002, 1000, '0,1000', 'menu.dashboard.userInfo', 'UserInfo', '', 'userInfo', '', null, 1, 2, 0, null, $datetime, $datetime, null],

            [1100, 0, '0', 'menu.system', 'System', 'icon-lock', 'system', '', null, 1, 1, 99, null, $datetime, $datetime, null],
            [1101, 1100, '0,1100', 'menu.system.user', 'SystemUser', '', 'user', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1102, 1100, '0,1100', 'menu.system.role', 'SystemRole', '', 'role', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1103, 1100, '0,1100', 'menu.system.menu', 'SystemMenu', '', 'menu', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1104, 1100, '0,1100', 'menu.system.logs', 'SystemLogs', '', 'logs', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1105, 1104, '0,1100,1104', 'menu.system.logs.login', 'SystemLoginLogs', '', 'login', '', null, 1, 1, 0, null, $datetime, $datetime, null],

            [1200, 0, '0', 'menu.tools', 'Tools', 'icon-tool', 'tools', '', null, 1, 1, 0, null, $datetime, $datetime, null],
            [1201, 1200, '0,1200', 'menu.tools.generateCode', 'ToolsGenerateCode', '', 'generateCode', '', null, 1, 1, 0, null, $datetime, $datetime, null],
        ];

        $roleMenuData = [];
        foreach ($menuData as $menuDatum) {
            $roleMenuData[] = [$superAdminRoleId, $menuDatum[0]];
        }

        $data = [
            SystemMenu::class => $menuData,
            SystemRoleMenu::class => $roleMenuData,
            SystemRole::class => [
                [$superAdminRoleId, '超级管理员', 'SuperAdmin', 1, 0, $datetime, $datetime, null],
            ],
            SystemUser::class => [
                [$superAdminUserId, 'admin', password_hash('123456', PASSWORD_DEFAULT), '超级管理员', null, null, '', 1, null, null, $datetime, $datetime, null],
            ],
            SystemUserRole::class => [
                [$superAdminUserId, $superAdminRoleId],
            ],
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
                } elseif ($val === null) {
                    $val = 'NULL';
                }
            }
            $sqlData[] = "INSERT INTO `{$table_name}` VALUES (" . implode(',', $datum) . ')';
        }
        return $sqlData;
    }

    protected function getTableName($model): string
    {
        /*
         * @var Model $model
         */
        return env('DB_PREFIX') . $model::getModel()->getTable();
    }
}
