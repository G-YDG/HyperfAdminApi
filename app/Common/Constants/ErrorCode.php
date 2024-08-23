<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\Common\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("请求有误")
     */
    public const BAD_REQUEST = 400;         // 请求有误

    /**
     * @Message("系统繁忙，请稍后再试")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("登录状态过期")
     */
    public const TOKEN_EXPIRED = 1001;      // TOKEN过期、不存在

    /**
     * @Message("数据验证失败")
     */
    public const VALIDATE_FAILED = 1002;    // 数据验证失败

    /**
     * @Message("权限不足")
     */
    public const NO_PERMISSION = 1003;      // 没有权限

    /**
     * @Message("数据不存在")
     */
    public const NO_DATA = 1004;            // 没有数据

    /**
     * @Message("状态异常")
     */
    public const NORMAL_STATUS = 1005;      // 正常状态异常代码

    /**
     * @Message("用户名或密码错误")
     */
    public const NO_USER = 1010;            // 用户不存在

    /**
     * @Message("用户名或密码错误")
     */
    public const PASSWORD_ERROR = 1011;     // 密码错误

    /**
     * @Message("用户异常")
     */
    public const USER_BAN = 1012;           // 用户被禁
}
