<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\Tools\Request;

use HyperfAdminCore\FormRequest;

class GenerateCodeRequest extends FormRequest
{
    /**
     * 验证规则.
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'module' => 'required|string',
            'name' => 'required|string',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'module' => '模块名',
            'name' => '表名',
        ];
    }
}
