<!DOCTYPE html>
<html>
<head>
    <title>配置数据库</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://static.lushaoming.site/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://static.lushaoming.site/plugin/layer/layer.js"></script>
    <script type="text/javascript" src="/assets/js/global.js"></script>

    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        .middle-div {
            width: 600px;
            height: 600px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<div style="text-align: center;width: 100%;height: 100%; margin-top: 2%;">
    <div class="middle-div">
        <form role="form" class="form-horizontal">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">选择用户表</label>
                <div class="col-sm-10">
                    <select class="form-control" id="table_name">
                        <option value="">请选择用户表</option>
                        @foreach($tables as $v)
                            <option value="{{$v->table_name}}">{{$v->table_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">主键</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="key_name" value="id">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">长度</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="key_length" value="11">
                </div>
            </div>
            <button type="button" class="btn btn-info btn-submit">提交</button>
            <div>
                注意：主键必须是整型UNSIGNED，否则将配置失败
            </div>
        </form>
    </div>

</div>
</body>
<script>
    $('.btn-submit').click(function () {
        var postData = {
            table_name: $('#table_name').val(),
            key_name: $('#key_name').val(),
            key_length: $('#key_length').val()
        };
        var res = getAjaxReponse('POST', '/permission/config', postData, false);
        console.log(res)
        if (res.status == 0) {
            showSuccessMsg('数据库配置成功')
        }
    })
</script>
</html>