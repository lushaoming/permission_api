<?php
/**
 * Created by PhpStorm.
 * User: Shannon
 * Date: 2019/6/12
 * Time: 12:03
 */
/**
 * 根据token获取用户ID，需根据自身系统进行更改
 * @param $token
 * @return int
 */
function get_user_id_by_token($token)
{
    if (empty($token)) return 0;
    return -1;
}

function md5_pwd($pwd)
{
    return md5($pwd . 'Lushaoming5201314');
}

function get_user_nickname()
{
    return '超级管理员';
}

function get_user_status_text($status)
{
    switch ($status) {
        case 1: return '正常';
        case 2: return '删除';
    }
}

function get_user_status_label($status)
{
    switch ($status) {
        case 1: return 'label-success';
        case 2: return 'label-warning';
        case 3: return 'label-inverse arrowed-in';
    }
}

function get_route()
{
    return request()->route()->uri;
}

function get_permission_management_routes()
{
    return ['permission/user', 'permission/role', 'permission/role/edit/{id}', 'permission/role/permission-edit/{id}', 'permission/resource', 'permission/route'];
}

function get_permission_role_routes()
{
    return ['permission/role', 'permission/role/edit/{id}', 'permission/role/permission-edit/{id}'];
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function List2Tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    if (!is_array($list)) {
        return [];
    }

    // 创建基于主键的数组引用
    $aRefer = [];
    foreach ($list as $key => $data) {
        $aRefer[$data[$pk]] = & $list[$key];
    }

    foreach ($list as $key => $data) {
        // 判断是否存在parent
        $parentId = $data[$pid];
        if ($root === $parentId) {
            $tree[] = & $list[$key];
        } else {
            if (isset($aRefer[$parentId])) {
                $parent = & $aRefer[$parentId];
                $parent[$child][] = & $list[$key];
            }
        }
    }

    return $tree;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $rows 要转换的数据集
 * @param string $id 主键id
 * @param string $pid parent标记字段
 * @param string $child 子节点存放的位置
 * @return array
 */
function List2Tree2($rows, $id='id', $pid='pid', $child = 'child') {
    $items = array();

    foreach ($rows as $row) {
        $items[$row[$id]] = $row;
    }

    foreach ($items as $item) {
        $items[$item[$pid]][$child][$item[$id]] = &$items[$item[$id]];
    }

    return isset($items[0][$child]) ? $items[0][$child] : [];
}

function create_hidden_input_field($id, $value, $name = '')
{
    if (empty($name)) $name = $id;
    echo '<input type="hidden" id="'.$id.'" name="'.$name.'" value="'.$value.'">';
}