<?php

declare(strict_types=1);

namespace App\System\Request;

use HyperfAdminCore\FormRequest;

class SystemConfigGroupRequest extends FormRequest
{
    protected array $scenes = [
        'save' => [
            'key',
            'name',
        ],
        'update' => [
            'id',
            'key',
            'name',
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
            'name' => 'required'
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '分组ID',
            'key' => '分组键值',
            'name' => '分组名称',
        ];
    }
}
