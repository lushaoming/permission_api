<?php

namespace App\Http\Controllers;

use App\Http\Services\PermissionService;
use App\Permission;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $userId = null;
    protected $user;

    public function __construct()
    {
        $this->checkPermission();
    }

    private function checkPermission()
    {
        $this->middleware(function ($request, $next) {
            $uri = request()->route()->uri;
            // 加载无需权限的路由-权限配置文件
            $routePermissions = include(APP_PATH . '/app/Config/uncheck-route-permission.php');
            // 检查无需权限的路由
            $unckeckUris = $routePermissions;
            if (in_array($uri, $unckeckUris)) {
                return $next($request);
            }

            // 获取登录用户信息
            $config = include(APP_PATH . '/app/Config/permission-config.php');
            $this->userId = $this->getUserId($config['priority'], $config['session_key'], $config['token_key']);
            if (empty($this->userId)) {
                return redirect('/permission/login');
            }

            // 超管
            if ($this->userId == $config['admin_id']) return $next($request);



            if (empty($this->userId)) {
                echo view(PERMISSION_DENY_VIEW);exit;
            }
            $permission = Permission::where('route', '=', $uri)->first();
            if (empty($permission)) {
                echo view(PERMISSION_NONE_VIEW);exit;
            }
            $permissionKey = $permission->name;
            $this->user = User::find($this->userId);
            $hasPermission = PermissionService::can($this->user, [$permissionKey], true);
            if ($hasPermission === false) {
                echo view(PERMISSION_DENY_VIEW);exit;
            }
            return $next($request);
        });
    }

    protected function getUserId($priority, $sessionKey = '', $tokenKey = '')
    {
        return -1;
        $id = 0;
        if ($priority == 'session') {
            if (session($sessionKey)) $id = session($sessionKey);
            else $id = get_user_id_by_token($_REQUEST[$tokenKey] ? $_REQUEST[$tokenKey] : null);
        } else {
            if (isset($_REQUEST[$tokenKey])) $id = get_user_id_by_token(isset($_REQUEST[$tokenKey]) ? $_REQUEST[$tokenKey] : null);
            else $id = session($sessionKey);
        }
        return $id;
    }


}
