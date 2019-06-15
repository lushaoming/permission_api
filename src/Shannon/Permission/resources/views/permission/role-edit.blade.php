@extends('layout/main-permission-20190615')
@section('title', '权限管理-编辑角色')
@section('content')
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="icon-home home-icon"></i>
                    <a href="#">Home</a>
                </li>

                <li>
                    <a href="#">Other Pages</a>
                </li>
                <li class="active">Blank Page</li>
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
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">角色名 </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" value="{{$role_info->display_name}}" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 角色标志 </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-2" value="{{$role_info->name}}" class="col-xs-10 col-sm-5" />
                                <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle">唯一标志</span>
											</span>
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">描述 </label>

                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" value="{{$role_info->description}}" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-input-readonly"> 创建时间 </label>

                            <div class="col-sm-9">
                                <input readonly="" type="text" class="col-xs-10 col-sm-5" id="form-input-readonly" value="{{$role_info->created_at}}" />
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-input-readonly"> 更新时间 </label>

                            <div class="col-sm-9">
                                <input readonly="" type="text" class="col-xs-10 col-sm-5" id="form-input-readonly" value="{{$role_info->updated_at}}" />
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button">
                                    <i class="icon-ok bigger-110"></i>
                                    保存
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <button class="btn btn-success" type="button" onclick="location.href='/permission/role/permission-edit/{{$role_info->id}}'">
                                    <i class="icon-lock bigger-110"></i>
                                    编辑权限
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="button" onclick="history.back()">
                                    <i class="icon-backward bigger-110"></i>
                                    返回
                                </button>
                            </div>
                        </div>

                        <div class="hr hr-24"></div>
                    </form>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
@endsection