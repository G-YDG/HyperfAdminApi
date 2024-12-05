<?php

declare(strict_types=1);

namespace App\System\Request;

use HyperfAdminCore\FormRequest;

class SystemConfigGroupRequest extends FormRequest
{
    protected array $scenes = [
        'save' => [
            'name'
        ],
        'update' => [
            'id',
            'name'
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
            'id' => 'id',
            'name' => '名称'
        ];
    }
}
