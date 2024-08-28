
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
