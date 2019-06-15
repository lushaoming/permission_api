<?php
/**
 * 权限系统配置文件
 * User: Shannon
 * Date: 2019/6/12
 * Time: 11:38
 */
return [
    // 验证优先级，token/session
    'priority' => 'session',
    // 使用token验证用户时，token的名称
    'token_key' => 'token',
    // 使用session验证用户时，session的名称
    'session_key' => 'user_id',
    // 超管ID
    'admin_id' => -1,
    // 超管账号
    'admin_account' => 'admin',
    // 超管密码
    'admin_password' => 'admin',
    // 超管名称
    'admin_nickname' => '超级管理员',
    // 超管角色
    'admin_role' => 'admin',

];