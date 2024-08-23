<?php

declare(strict_types=1);

namespace App\System\Request;

use HyperfAdminCore\FormRequest;

class SystemRoleRequest extends FormRequest
{
    protected array $scenes = [
        'save' => ['name', 'code'],
        'update' => ['name', 'code'],
    ];

    /**
     * 验证规则
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'status' => 'required',
            'name' => 'required|max:30',
            'code' => 'required|min:3|max:100',
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '角色ID',
            'name' => '角色名称',
            'code' => '角色标识',
            'status' => '角色状态',
        ];
    }
}
