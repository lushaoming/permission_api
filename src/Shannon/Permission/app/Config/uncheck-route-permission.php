<?php
/**
 * 无需权限的路由-权限配置，即无需登录都可访问
 * 配置规则：键名：uri，键值：权限key
 * User: Shannon
 * Date: 2019/6/11
 * Time: 14:20
 */
return [
    'login',
    'permission/login',
    'permission/verify-code',
    'register',
    'logout',
    'feedback',
    'test',
];
// 超管专属路由
//$admin = [
//    'permission/index' => 'permission/index',
//    'permission/user' => 'permission/user',
//    'permission/role' => 'permission/role',
//    'permission/resource' => 'permission/resource',
//    'permission/get-users' => 'permission-getUsers',
//    'permission/get-role-users' => 'permission-getRoleUsers',
//    'permission/add-user' => 'permission-addUser',
//    'permission/get-roles' => 'permission-getRoles',
//    'permission/get-permissions' => 'permission-getPermissions',
//    'permission/get-user-roles' => 'permission-getUserRoles',
//    'permission/get-role-permissions' => 'permission-getRolePermissions',
//
//];
//$permissions = [
//    'test/index/{param}' => 'test-index',
//];
//return [
//    'except' => $except,
//    'permissions' => array_merge($admin, $permissions),
//];