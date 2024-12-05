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
            'remark'
        ],
        'update' => [
            'id',
            'key',
            'value',
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
            //主键
            'id' => 'required',
            //配置项
            'key' => 'required',
            //配置项
            'value' => 'required',
            //备注
            'remark' => 'required'
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '主键',
            'key' => '配置项',
            'value' => '配置项',
            'remark' => '备注'
        ];
    }
}
