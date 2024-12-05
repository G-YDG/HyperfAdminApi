<?php

declare(strict_types=1);

use App\System\Dictionary\DicConfigGroupKey;
use App\System\Dictionary\DicConfigKey;
use App\System\Model\SystemConfig;
use App\System\Model\SystemConfigGroup;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class Config extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('system_config_group')->truncate();
        Db::table('system_config')->truncate();

        $datetime = date('Y-m-d H:i:s');

        $config = [
            [1, DicConfigKey::WEBSITE_SETTING_TITLE, 'HyperfAdmin', DicConfigKey::VALUE_TYPE_TEXT, DicConfigKey::IS_SYSTEM, '网站名称', 1, $datetime, $datetime],
            [2, DicConfigKey::WEBSITE_SETTING_LOGO, '//p3-armor.byteimg.com/tos-cn-i-49unhts6dw/dfdba5317c0c20ce20e64fac803d52bc.svg~tplv-49unhts6dw-image.image', DicConfigKey::VALUE_TYPE_IMAGE, DicConfigKey::IS_SYSTEM, '网站LOGO', 1, $datetime, $datetime],
            [3, DicConfigKey::WEBSITE_SETTING_RECORD_NUMBER, '京ICP备1xxx8号', DicConfigKey::VALUE_TYPE_TEXT, DicConfigKey::IS_SYSTEM, '备案号', 1, $datetime, $datetime],
            [4, DicConfigKey::WEBSITE_SETTING_URL, 'https://www.baidu.com', DicConfigKey::VALUE_TYPE_TEXT, DicConfigKey::IS_SYSTEM, '网址', 1, $datetime, $datetime],
            [5, DicConfigKey::WEBSITE_SETTING_COMPANY, 'HyperfAdmin', DicConfigKey::VALUE_TYPE_TEXT, DicConfigKey::IS_SYSTEM, '公司', 1, $datetime, $datetime],
            [6, DicConfigKey::WEBSITE_SETTING_TIME, '@2023-2024', DicConfigKey::VALUE_TYPE_TEXT, DicConfigKey::IS_SYSTEM, '日期', 1, $datetime, $datetime],
        ];

        $data = [
            SystemConfig::class => $config,
            SystemConfigGroup::class => [
                [1, DicConfigGroupKey::WEBSITE_SETTING, '网站设置', DicConfigGroupKey::IS_SYSTEM, $datetime, $datetime],
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