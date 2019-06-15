<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/11
 * Time: 12:15
 */
namespace App\Http\Services;

use App\Permission;
use App\Role;
use App\User;

class PermissionService
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * 验证用户是否含有该角色
     * @param User $user
     * @param array $role
     * @param bool $all true: 需所有角色都有才返回true，false: 只要有其中一个角色就返回true
     * @return bool
     */
    public static function hasRole(User $user, array $role, bool $all = false) : bool
    {
        return $user->hasRole($role, $all);
    }

    /**
     * 验证角色是否含有该权限
     * @param User $user
     * @param array $permissions 权限的name，非id
     * @param bool $all true: 需所有权限都有才返回true，false: 只要有其中一个权限就返回true
     * @return bool
     */
    public static function can(User $user, array $permissions, bool $all = false) : bool
    {
        return $user->can($permissions, $all);
    }

    /**
     * 获取权限信息
     * @param $name
     * @return mixed
     */
    public static function getPermissionByName($name)
    {
        return Permission::where('name', '=', $name)->first();
    }

    /**
     * 获取权限信息
     * @param $name
     * @return mixed
     */
    public static function getPermissionByRoute($route)
    {
        return Permission::where('route', '=', $route)->first();
    }

    public function updateRolePermission(Role $role, $permission)
    {
        if (empty($permission)) $permission = null;
        $role->perms()->sync($permission);
    }



}