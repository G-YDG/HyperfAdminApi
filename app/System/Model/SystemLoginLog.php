<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\System\Model;

use HyperfAdminCore\Model;

/**
 * @property int $id 主键
 * @property string $username 用户名
 * @property string $ip 登录IP地址
 * @property string $ip_location IP所属地
 * @property string $os 操作系统
 * @property string $browser 浏览器
 * @property int $status 登录状态 (1成功 2失败)
 * @property string $message 提示消息
 * @property string $login_time 登录时间
 * @property string $remark 备注
 */
class SystemLoginLog extends Model
{
    public const SUCCESS = 1;

    public const FAIL = 2;

    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_login_log';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'username',
        'ip',
        'ip_location',
        'os',
        'browser',
        'status',
        'message',
        'login_time',
        'remark',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'status' => 'integer'];
}
