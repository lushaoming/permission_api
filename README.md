# permission_api
使用教程
--------
1、安装扩展<br>
composer require zizaco/entrust<br>
2、使用步骤<br>
<1>、在config/app.php的providers数组添加一项：Zizaco\Entrust\EntrustServiceProvider::class，alias也添加一项;'Entrust' => Zizaco\Entrust\EntrustFacade::class,<br>
<2>、在config/auth.php的providers的users添加一项：'table' => 'bas_user'<br>
<3>、在app\Http\Kernel.php的$routeMiddleware添加3项：<br>
'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,<br>
'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,<br>
'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,<br>
<4>、将app下的3个php文件复制到项目的app文件夹下，如果此文件夹下已有User.php，则添加两个属性即可：use EntrustUserTrait;protected $table = 'bas_user';table是用户数据表。<br>
<6>app\Http\Controllers/PermissionController复制到项目的Controllers下，
如果没有改动过Controller.php，则可以直接覆盖掉；
若改动过Controller.php，则添加checkPermission()和getUserId()方法并在构造函数添加$this->checkPermission();
并且添加protected $userId = null;protected $user;两个属性<br>
<7>、routes/permission.php复制到项目路由文件夹routes，并在web.php添加require_once 'permission.php';
<8>、app\Http\Services/PermissionService.php复制到项目app\Http\Services文件夹下（没有则创建）<br>
<9>、将views下面的所有文件复制到项目的resource/views下
