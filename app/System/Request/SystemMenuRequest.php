<?php

declare(strict_types=1);

namespace App\System\Request;

use Hyperf\Validation\Rule;
use HyperfAdminCore\FormRequest;
use HyperfAdminCore\Model;

class SystemMenuRequest extends FormRequest
{
    protected array $scenes = [
        'save' => [
            'parent_id',
            'name',
            'icon',
            'code',
            'route',
            'sort',
            'hide_menu',
            'status',
        ],
        'update' => [
            'id',
            'parent_id',
            'name',
            'icon',
            'code',
            'route',
            'sort',
            'hide_menu',
            'status',
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
            'parent_id' => 'required',
            'name' => 'required|max:30',
            'icon' => 'required|string',
            'code' => 'required|min:3|max:50',
            'route' => 'required|string',
            'status' => ['integer', Rule::in([Model::ENABLE, Model::DISABLE])],
            'hide_menu' => ['integer', Rule::in([Model::ENABLE, Model::DISABLE])],
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '菜单ID',
            'parent_id' => '父级菜单ID',
            'name' => '菜单名称',
            'icon' => '菜单图标',
            'code' => '菜单标识',
            'route' => '菜单路由',
            'status' => '菜单状态',
            'hide_menu' => '隐藏状态',
        ];
    }
}
