<!DOCTYPE html>
<html>
<head>
    <title>Error!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 引入 Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shiv 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
    <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        .middle-div {width: 300px;height: 300px;margin: auto;top: 0;left: 0;right: 0;bottom: 0}
    </style>
</head>
<body>
<div style="text-align: center;width: 100%;margin-top: 2%;">
    <div class="middle-div">
        <div>
            <img src="http://www.static.me/icon/warnning.png">
        </div>
        <div style="margin-top: 2%;">
            <span>{{isset($msg) ? $msg : 'Error occur.'}}</span>
        </div>
        <div>
            <a href="javascript:;" onclick="history.back();">返回上一页</a>
        </div>
    </div>

</div>
</body>
</html>