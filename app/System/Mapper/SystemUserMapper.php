<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemUser;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use HyperfAdminCore\Abstracts\AbstractMapper;
use HyperfAdminCore\Annotation\Transaction;

class SystemUserMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemUser::class;
    }

    /**
     * 通过用户名检查用户
     * @param string $username
     * @return SystemUser|Builder|Model
     */
    public function checkUserByUsername(string $username): Model|SystemUser|Builder
    {
        return $this->model::query()->where('username', $username)->firstOrFail();
    }

    /**
     * 通过用户名检查是否存在
     * @param string $username
     * @return bool
     */
    public function existsByUsername(string $username): bool
    {
        return $this->model::query()->where('username', $username)->exists();
    }

    /**
     * 检查用户密码
     * @param String $password
     * @param string $hash
     * @return bool
     */
    public function checkPass(string $password, string $hash): bool
    {
        return $this->model::passwordVerify($password, $hash);
    }

    /**
     * 初始化用户密码
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function initUserPassword(int $id, string $password): bool
    {
        $model = $this->model::find($id);
        if ($model) {
            $model->password = $password;
            return $model->save();
        }
        return false;
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    #[Transaction]
    public function save(array $data): int
    {
        $role_ids = $data['role_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $user = $this->model::create($data);
        $user->roles()->sync($role_ids, false);
        return $user->id;
    }

    /**
     * 更新用户
     * @param int $id
     * @param array $data
     * @return bool
     */
    #[Transaction]
    public function update(int $id, array $data): bool
    {
        $role_ids = $data['role_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $result = parent::update($id, $data);
        $user = $this->model::find($id);
        if ($user && $result) {
            !empty($role_ids) && $user->roles()->sync($role_ids);
            return true;
        }
        return false;
    }

    public function handleSearch(Builder $query, ?array $params): Builder
    {
        if (!empty($params['username'])) {
            $query->whereRaw("username like '%" . $params['username'] . "%'");
        }
        if (isset($params['status']) && is_numeric($params['status'])) {
            $query->where(['status' => $params['status']]);
        }
        if (isset($params['role_id']) && is_numeric($params['role_id'])) {
            $query->whereRaw(
                "id IN ( SELECT system_user_id FROM system_user_role WHERE system_role_id = ? )",
                [$params['role_id']]
            );
        }
        $query->with('roles');
        return $query;
    }
}
