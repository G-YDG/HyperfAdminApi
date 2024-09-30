
# 介绍

HyperfAdmin 是一个后台权限管理系统，内置实现了用户和权限系统，可以帮助你快速构建后台管理系统，提高项目效率，减少重复造轮。

HyperfAdmin 采用前后端分离的架构，前端使用 Vue3 + Vite4 + Pinia + Typescript + ArcoDesign，后端基于 Hyperf 框架进行开发。

### 项目地址
> - [HyperfAdminVue](https://github.com/G-YDG/HyperfAdminVue)
> - [HyperfAdminApi](https://github.com/G-YDG/HyperfAdminApi)

# 快速开始

使用 docker-compose 启动项目

```bash
docker-compose up -d
```

安装依赖并重启容器

```bash
docker-compose exec hyperf-admin composer install && docker-compose restart
```

生成权限配置

```bash
docker-compose exec hyperf-admin php bin/hyperf.php gen:auth-env
```

初始化迁移

```bash
docker-compose exec hyperf-admin php bin/hyperf.php migrate:install
```

执行数据迁移

```bash
docker-compose exec hyperf-admin php bin/hyperf.php migrate
```

执行数据填充

```bash
docker-compose exec hyperf-admin php bin/hyperf.php db:seed
```

重启容器

```bash
docker-compose restart
```

查看容器日志

```bash
docker-compose logs -f -t --tail=100
```

# 开发示例

以下以 `system_login_log` 为例

生成迁移文件
```bash
php bin/hyperf.php gen:migration system_login_log
```

表结构设计完成后，执行迁移
```bash
php bin/hyperf.php migrate
```

根据数据表，快速生成基础代码文件
```bash
php bin/hyperf.php gen-template System system_login_log
```