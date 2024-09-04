<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Request;

use HyperfAdminCore\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * 验证规则.
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'file' => '文件',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => '请上传文件',
        ];
    }
}
