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
                    <a href="/permission/index">首页</a>
                </li>

                <li class="active">资源管理</li>
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
                    资源管理
                    <small>
                        <i class="icon-double-angle-right"></i>
                        资源树
                    </small>
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" href="#modal-table">添加节点</button>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                    <div>
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <div id="LAY-auth-tree-index"></div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    {{--<button class="layui-btn" type="submit" lay-submit lay-filter="LAY-auth-tree-submit">提交</button>--}}
                                    {{--<button class="layui-btn layui-btn-primary" type="reset">重置</button>--}}
                                </div>
                            </div>
                        </form>
                    </div>


                    <div id="modal-table" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header no-padding">
                                    <div class="table-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                            <span class="white">&times;</span>
                                        </button>
                                        新增节点
                                    </div>
                                </div>

                                <div class="modal-body no-padding">
                                    <div style="width:80%;margin: 0 auto;">
                                        <form>
                                            <div class="form-group">
                                                <label>类型</label>
                                                <select id="node_type" class="form-control" onchange="changeNodeType()">
                                                    <option value="1">菜单</option>
                                                    <option value="2">操作</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>节点名称</label>
                                                <input type="text" class="form-control" id="node_name" placeholder="节点名称">
                                            </div>
                                            <div class="form-group">
                                                <label>节点标志</label>
                                                <input type="text" class="form-control" id="node_flag" placeholder="节点标志，需唯一">
                                            </div>
                                            <div class="form-group">
                                                <label>节点描述</label>
                                                <input type="text" class="form-control" id="node_desc" placeholder="节点名称">
                                            </div>
                                            <div class="form-group node-route" style="display: none;">
                                                <label>路由地址</label>
                                                <input type="text" class="form-control" id="route_uri" placeholder="路由地址，需唯一">
                                            </div>
                                            <div class="form-group">
                                                <label>父节点（无表示此节点为根节点）</label>
                                                <select id="node_parent_id" class="selectpicker show-tick form-control" data-live-search="true">
                                                    <option value="0">无</option>
                                                    @foreach($permissions as $permission)
                                                    <option value="{{$permission->id}}">{{$permission->display_name}}({{$permission->name}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-info save-resource-btn">保存</button>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>


                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    <script>

        function changeNodeType() {
            var type = $('#node_type').val();
            if (type == 1) {
                $('.node-route').hide();
            } else {
                $('.node-route').show();
            }
        }
        $('.save-resource-btn').click(function () {
            var node_type = $('#node_type').val();
            var node_name = $('#node_name').val();
            var node_flag = $('#node_flag').val();
            var route_uri = $('#route_uri').val();
            var node_desc = $('#node_desc').val();
            var node_parent_id = $('#node_parent_id').val();
            var postData = {
                node_type: node_type,
                node_name: node_name,
                node_flag: node_flag,
                route_uri: route_uri,
                node_desc: node_desc,
                node_parent_id: node_parent_id,
            }
            var res = getAjaxReponse('POST', '/permission/save-resource-node', postData, false);
            if (res.status == 0) showSuccessMsgAndReload('添加成功');
        })
    </script>
@endsection