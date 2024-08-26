<?php

declare(strict_types=1);

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\SoftDeletes;
use HyperfAdminCore\Model;
use Qbhy\HyperfAuth\AuthAbility;
use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id 用户ID
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname 用户昵称
 * @property string $phone 手机
 * @property string $email 用户邮箱
 * @property string $avatar 用户头像
 * @property int $status 状态 (1正常 2停用)
 * @property string $login_ip 最后登陆IP
 * @property string $login_time 最后登陆时间
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class SystemUser extends Model implements Authenticatable
{
    use AuthAbility, SoftDeletes;

    /**
     * 状态：正常
     */
    public const USER_NORMAL = 1;

    /**
     * 状态：禁用
     */
    public const USER_BAN = 2;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_user';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'id',
        'username',
        'password',
        'nickname',
        'phone',
        'email',
        'avatar',
        'status',
        'login_ip',
        'login_time',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 验证密码
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function passwordVerify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * 通过中间表关联角色
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class, 'system_user_role', 'system_user_id', 'system_role_id');
    }

    /**
     * 密码加密
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
}
