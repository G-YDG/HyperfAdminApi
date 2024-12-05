<?php

declare(strict_types=1);

namespace App\System\Request;

use HyperfAdminCore\FormRequest;

class SystemConfigRequest extends FormRequest
{
    protected array $scenes = [
        'save' => [
            'key',
            'value',
            'value_type',
            'remark'
        ],
        'update' => [
            'id',
            'key',
            'value',
            'value_type',
            'remark'
        ],
    ];

    /**
     * 验证规则
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'key' => 'required',
            'value' => 'required',
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '配置ID',
            'key' => '配置键值',
            'value' => '配置内容',
            'value_type' => '配置类型',
            'remark' => '备注说明',
            'system_group_id' => '配置分组'
        ];
    }
}
