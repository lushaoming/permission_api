@extends('layout/main-permission-20190615')
@section('title', '权限管理-用户管理')
@section('content')

    <link rel="stylesheet" type="text/css" href="/assets/layui-authtree/layui/css/layui.css">
    <script src="/assets/layui-authtree/layui/layui.js"></script>
    <script src="/assets/layui-authtree/index.js"></script>
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="/permisison/index">首页</a>
                </li>

                <li>
                    <a href="/permisison/role">角色</a>
                </li>
                <li class="active">编辑权限</li>
            </ul><!-- .breadcrumb -->

            <div class="nav-search" id="nav-search">
                <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
                </form>
            </div><!-- #nav-search -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    编辑权限
                    <small>
                        <i class="icon-double-angle-right"></i>
                        {{$role_info->display_name}}
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div>
                        {{create_hidden_input_field('role_id', $role_info->id)}}
                        <div>
                            <button type="button" class="btn btn-sm btn-success" onclick="checkAll('#LAY-auth-tree-index')">全选</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="uncheckAll('#LAY-auth-tree-index')">全不选</button>
                        </div>
                        <form class="layui-form">
                            {{create_hidden_input_field('tree_form_type', 'role-permission-edit')}}

                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div id="LAY-auth-tree-index"></div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" type="submit" lay-submit lay-filter="LAY-auth-tree-submit">提交</button>
                                    <button class="layui-btn layui-btn-primary" type="button" onclick="history.back()">返回</button>
                                    <button class="layui-btn layui-btn-primary" type="reset">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
@endsection