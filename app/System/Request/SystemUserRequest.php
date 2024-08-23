<?php

declare(strict_types=1);

namespace App\System\Request;

use App\System\Model\SystemUser;
use App\System\Service\SystemUserService;
use HyperfAdminCore\FormRequest;

class SystemUserRequest extends FormRequest
{
    protected array $scenes = [
        'login' => ['username', 'password'],
        'save' => ['username', 'password', 'role_ids'],
        'update' => ['username', 'role_ids'],
        'changeStatus' => ['id', 'status'],
        'modifyUserInfo' => ['nickname', 'avatar', 'phone', 'email'],
        'modifyPassword' => ['oldPassword', 'newPassword', 'newPassword_confirmation'],
    ];

    /**
     * 验证规则
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'nickname' => 'required|string',
            'avatar' => 'required|url',
            'phone' => ['numeric', function ($attribute, $value, $fail) {
                if (!preg_match('/^(1[3-9])\d{9}$/', $value)) {
                    $fail('手机号格式有误');
                }
            }],
            'email' => 'email',
            'username' => 'required|max:20',
            'password' => 'required|min:6',
            'role_ids' => 'required',
            'oldPassword' => ['required', function ($attribute, $value, $fail) {
                $service = $this->container->get(SystemUserService::class);
                /* @var SystemUser $model */
                $model = $service->mapper->getModel()::find((int)auth()->id(), ['password']);
                if (!$service->mapper->checkPass($value, $model->password)) {
                    $fail('密码验证失败');
                }
            }],
            'newPassword' => 'required|confirmed|min:6',
            'newPassword_confirmation' => 'required',
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'password' => '密码',
            'oldPassword' => '旧密码',
            'newPassword' => '新密码',
            'newPassword_confirmation' => '确认密码',
            'status' => '状态',
            'role_ids' => '角色',
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.required' => '请填写用户昵称',
            'avatar.required' => '请上传头像',
            'avatar.url' => '头像链接格式有误',
            'phone.digits' => '手机号格式有误',
            'email.email' => '邮箱格式有误',
            'role_ids.required' => '请选择角色',
            'username.max' => '用户名最大长度为20位',
            'password.min' => '密码长度最小为6位',
            'oldPassword.required' => '请输入旧密码',
            'newPassword.required' => '请输入新密码',
            'newPassword.min' => '密码长度最小为6位',
            'newPassword.confirmed' => '新密码输入不一致',
            'newPassword_confirmation.required' => '请确认新密码',
        ];
    }
}
