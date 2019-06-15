<?php
/**
 * 权限控制路由
 * User: Shannon
 * Date: 2019/6/11
 * Time: 11:36
 */
Route::any('permission/config', 'PermissionController@config');
Route::any('permission/login', 'PermissionController@login');
Route::get('permission/verify-code', 'PermissionController@verifyCode');
Route::get('permission/test', 'PermissionController@test');
Route::get('permission/index', 'PermissionController@index');
Route::get('permission/user', 'PermissionController@user');
Route::get('permission/role', 'PermissionController@role');
/* 角色编辑 */
Route::any('permission/role/edit/{id}', 'PermissionController@roleEdit');
/* 角色权限编辑 */
Route::any('permission/role/permission-edit/{id}', 'PermissionController@rolePermissionEdit');
Route::get('permission/resource', 'PermissionController@resource');
Route::get('permission/route', 'PermissionController@route');
/* 获取所有角色 */
Route::get('permission/get-roles', 'PermissionController@getRoles');
/* 获取所有权限 */
Route::get('permission/get-permissions', 'PermissionController@getPermissions');
/* 获取所有用户 */
Route::get('permission/get-users', 'PermissionController@getUsers');
/* 获取用户的角色（一个用户可有多个角色） */
Route::get('permission/get-user-roles', 'PermissionController@getUserRoles');
/* 获取角色的权限（一个角色有多个权限） */
Route::get('permission/get-role-permissions', 'PermissionController@getRolePermissions');
/* 获取角色的下的用户（一个角色可对应多个用户） */
Route::get('permission/get-role-users', 'PermissionController@getRoleUsers');
/* 获取权限下的角色（一个权限可对应多个角色） */
Route::get('permission/get-permission-roles', 'PermissionController@getPermissionRoles');
// 新增用户
Route::post('permission/add-user', 'PermissionController@addUser');
/* 保存路由资源节点 */
Route::post('permission/save-resource-node', 'PermissionController@saveResourceNode');
