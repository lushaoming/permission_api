<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/11
 * Time: 10:50
 */
namespace App\Http\Controllers;

use App\Http\Services\PermissionService;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LsmVerify\Verify\VerifyCode;

class PermissionController extends Controller
{
    const OR_CODE = 200;
    const ERROR_CODE = 400;
    const version = '20190615';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 数据库配置
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function config(Request $request)
    {
        if ($request->isMethod('POST')) {
            $tableName = $this->get_not_empty_var('table_name');
            $keyName = $this->get_not_empty_var('key_name');
            $length = $this->get_not_empty_var('key_length');
            $data = DB::select("SHOW columns FROM `{$tableName}` WHERE Field='{$keyName}'");
            if (count($data) == 0) {
                return $this->ajaxReturn(self::ERROR_CODE, [], '不存在该字段');
            }
            if ($data[0]->Type != "int({$length}) unsigned") {
                return $this->ajaxReturn(self::ERROR_CODE, [], "字段类型不是int({$length}) unsigned");
            }
            $sqlFile = APP_PATH . '/app/Config/permission_api'.self::version . '.sql';
            $sqlData = file_get_contents($sqlFile);
            $sqlData = str_replace(['{{userIdLength20190615}}', '{{userTable20190615}}', '{{userKey20190615}}'], [$length, $tableName, $keyName], $sqlData);

            $sqlDatas = explode(';', trim($sqlData));
            foreach ($sqlDatas as $sql) {
                DB::statement($sql);
            }
            // 创建entrust.php并写入数据
            $entrustFile = APP_PATH . '/app/Config/entrust'.self::version . '.conf';
            $entrustData = file_get_contents($entrustFile);
            $entrustData = str_replace('{{user_table_20190615}}', $tableName, $entrustData);
            file_put_contents(APP_PATH . '/config/entrust.php', $entrustData);
            return $this->ajaxReturn();
        } else {
            $database = config('database.connections.mysql.database');
            $tables = DB::select('SELECT TABLE_NAME as table_name FROM information_schema.TABLES WHERE table_schema="'.$database.'"');
            return view('permission.config', [
                'tables' => $tables,
            ]);
        }
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {

        } else {
            return view('permission.login');
        }
    }

    public function verifyCode()
    {
        VerifyCode::getInstance()->createComputeCode();
//        echo '<img src="'.VerifyCode::getInstance()->createComputeCode().'">';

    }

    public function index(Request $request)
    {
//        $owner = new Role();
//        $owner->name = 'owner';
//        $owner->display_name = 'Project Owner';
//        $owner->description = 'User is the owner of a given project';
//        $owner->save();
//
//        $admin = new Role();
//        $admin->name = 'admin';
//        $admin->display_name = 'User Administrator';
//        $admin->description = 'User is allowed to manage and edit other users';
//        $admin->save();
//        $user = User::where('name', '=', 'lushaoming')->first();
        //调用EntrustUserTrait提供的attachRole方法
//        $user->attachRole(2); // 参数可以是Role对象，数组或id

//        $permission = new Permission();exit;
//        $permission->name = 'edit-user';
//        $permission->display_name = 'Edit Users';
//        $permission->description = 'edit existing users';
//        $permission->save();

//        $role = Role::where('name', '=', 'owner')->first();
//        $role->attachPermission(1);
        return view('permission.index');
    }

    public function test()
    {
//        $a = null;
//        var_dump(explode(',', $a));
        return view('permission.test');
    }

    public function user(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            $roles = $user->roles()->get()->toArray();

            $tempRoles = [];
            foreach ($roles as $role) {
                $tempRoles[] = $role['display_name'];
            }
            $user->roles = implode(',', $tempRoles);
        }


        return view('permission.user', [
            'users' => $users
        ]);
    }

    public function role(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        foreach ($roles as $role) {
            $users = $role->users()->get()->toArray();

            $tempUsers = [];
            foreach ($users as $user) {
                $tempUsers[] = $user['nickname'];
            }
            $role->users = implode(',', $tempUsers);
        }
        return view('permission.role', [
            'roles' => $roles
        ]);
    }

    public function roleEdit(Request $request)
    {
        if ($request->isMethod('POST')) {

        } else {
            $id = $request->route('id');
            $roleInfo = Role::where('id', '=', $id)->first();
            if (empty($roleInfo)) {
                return view('error.error', [
                    'msg' => 'Error role id'
                ]);
            }
            $roleInfo->permissions = $roleInfo->permissions()->get();
            return view('permission.role-edit', [
                'role_info' => $roleInfo,
            ]);

        }
    }

    /**
     * 角色权限编辑
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rolePermissionEdit(Request $request)
    {
        $id = $request->route('id');
        $roleInfo = Role::where('id', '=', $id)->first();
        if ($request->isMethod('POST')) {
            $permissions = $this->get_var('permissions');
            PermissionService::getInstance()->updateRolePermission($roleInfo, $permissions ? explode(',', $permissions) : null);
            return $this->ajaxReturn();
        } else {
            if (empty($roleInfo)) {
                return view('error.error', [
                    'msg' => 'Error role id'
                ]);
            }
            $roleInfo->permissions = $roleInfo->permissions()->get();
            return view('permission.role-permission-edit', [
                'role_info' => $roleInfo,
            ]);

        }
    }

    public function resource(Request $request)
    {
        $permissions = Permission::get();
//        $permissions = List2Tree2($permissions, 'id', 'pid', 'child');
        return view('permission.resource', [
            'permissions' => $permissions
        ]);
    }

    public function route(Request $request)
    {
        $routes = Permission::select(['id', 'type', 'display_name','route'])->orderBy('id', 'DESC')->get();
        return view('permission.route', [
            'routes' => $routes
        ]);
    }

    public function saveResourceNode(Request $request)
    {
        $nodeType = $this->get_not_empty_var('node_type');
        if (!in_array($nodeType, [1,2])) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '节点类型错误');
        }
        $nodeName = $this->get_not_empty_var('node_name');
        $nodeFlag = $this->get_not_empty_var('node_flag');
        $nodeDesc = $this->get_var('node_desc');
        if ($nodeType == 2) {
            $routeUri = $this->get_not_empty_var('route_uri');
        } else {
            $routeUri = '';
        }
        $nodeParentId = $this->get_var('node_parent_id', 0);

        if (PermissionService::getPermissionByName($nodeFlag)) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '节点标志已存在');
        }
        if ($routeUri && PermissionService::getPermissionByRoute($routeUri)) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '路由地址已存在');
        }
        $permission = new Permission();
        $permission->type = $nodeType;
        $permission->name = $nodeFlag;
        $permission->display_name = $nodeName;
        $permission->description = $nodeDesc;
        $permission->pid = $nodeParentId;
        $permission->route = $routeUri;
        $permission->save();
        return $this->ajaxReturn();
//        $permission->getKey();
    }


    public function getRoles(Request $request)
    {
        $roles = Role::get()->toArray();
        return $this->ajaxReturn(self::OR_CODE, $roles);
    }

    public function getPermissions(Request $request)
    {
        $isTree = $this->get_var('tree', 0);
        $roleId = $this->get_var('role', 0);
        $permissions = Permission::get()->toArray();
        if ($isTree) $permissions = List2Tree2($permissions, 'id', 'pid', 'child');
        if ($roleId) {
            $rolePermissions = [];
            $role = Role::find($roleId);
            if ($role) $rolePermissions = $role->permissions()->get()->toArray();
            if (count($rolePermissions) > 0) {

                foreach ($permissions as $k => &$v) {
                    $flag = 0;
                    foreach ($rolePermissions as $kk => $vv) {
                        if ($v['id'] == $vv['id']) {
                            $v['checked'] = true;
                            $flag = 1;
                            break;
                        }
                    }
                    if ($flag == 0) {
                        $v['checked'] = false;
                    }
                }
            }

        }
//        var_dump($permissions);exit;
        return $this->ajaxReturn(self::OR_CODE, $permissions);
    }

    public function getUsers(Request $request)
    {
        $users = User::get()->toArray();
        return $this->ajaxReturn(self::OR_CODE, $users);
    }

    /**
     * 获取用户所有的角色
     * @param Request $request
     * @return false|string
     */
    public function getUserRoles(Request $request)
    {
        $userId = $request->input('user_id', 0);
        $user = User::find($userId);
        if (empty($user)) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '无效的用户');
        }
        $roles = $user->roles()->get()->toArray();
        return $this->ajaxReturn(self::OR_CODE, $roles);
    }

    /**
     * 获取角色的权限
     * @param Request $request
     * @return false|string
     */
    public function getRolePermissions(Request $request)
    {
        $roleId = $request->input('role_id', 0);
        $role = Role::find($roleId);
        if (empty($role)) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '无效的角色');
        }
        $permission = $role->permissions()->get()->toArray();
        return $this->ajaxReturn(self::OR_CODE, $permission);
    }

    /**
     * 获取角色的所有用户
     * @param Request $request
     * @return false|string
     */
    public function getRoleUsers(Request $request)
    {
        $roleId = $request->input('role_id', 0);
        $role = Role::find($roleId);
        if (empty($role)) {
            return $this->ajaxReturn(self::ERROR_CODE, [], '无效的角色');
        }

        $users = $role->users()->get()->toArray();
        return $this->ajaxReturn(self::OR_CODE, $users);
    }

    public function getPermissionRoles(Request $request)
    {
    }

    /**
     * 添加用户并绑定角色
     * @param Request $request
     * @return false|string
     */
    public function addUser(Request $request)
    {
        $username = $this->get_not_empty_var('username');
        $password = $this->get_not_empty_var('password');
        $nickname = $this->get_not_empty_var('nickname');
        $email = $this->get_var('email');
        $roleIds = $this->get_var('role_ids');
        $roleIds = explode(',', $roleIds);

        $userInfo = User::where('username', '=', $username)->first();
        if (!empty($userInfo)) return $this->ajaxReturn(self::ERROR_CODE, [], '账号已存在');

        // 使用事务操作
        DB::beginTransaction();
        try{
            $user = new User();
            $user->username = $username;
            $user->password = md5_pwd($password);
            $user->nickname = $nickname;
            $user->email = $email;
            $user->save();

            // 添加角色
            if (!empty($roleIds)) {
                $user->attachRoles($roleIds);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->ajaxReturn(self::ERROR_CODE, [], '操作失败');
        }

        return $this->ajaxReturn(self::OR_CODE);
    }

    /**
     * 获取请求值
     * @param string $key 键名
     * @param Request $request
     * @param string $default 为空时的默认值
     * @return mixed
     */
    protected function get_var($key, $default = ''){
        $request = request();
        if (!$request->input($key)) {
            return $default;
        }
        return $request->input($key);
    }

    /**
     * 获取非空请求值
     * @param string $key 键名
     * @param Request $request
     * @param string $msg 为空时返回错误信息
     * @return mixed
     */
    protected function get_not_empty_var($key, $msg=''){
        $request = request();
        if(!$request->input($key)){
            if (empty($msg)) $msg = "缺少{$key}参数";
            echo $this->ajaxReturn(self::ERROR_CODE, [], $msg);exit;
        }

        return $request->input($key);
    }

    protected function ajaxReturn($code = 200, $data = [], $msg = 'OK')
    {
        return json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]);
    }
}