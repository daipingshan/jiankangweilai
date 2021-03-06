<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>健康未来-管理登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/Public/Admin/css/font.css">
    <link rel="stylesheet" href="/Public/Admin/css/login.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/lib/layui/layui.js"></script>
</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">健康未来-管理登录</div>
    <div id="darkbannerwrap"></div>
    <form method="post" class="layui-form">
        <input name="username" placeholder="用户名" type="text" class="layui-input">
        <hr class="hr15">
        <input name="password" placeholder="密码" type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>

<script>
    $(function () {
        layui.use(['form', 'layer'], function () {
            var form = layui.form;
            var layer = layui.layer;
            //监听提交
            form.on('submit(login)', function (data) {
                if (!data.field.username) {
                    layer.msg('请输入用户名！');
                    return false;
                }
                if (!data.field.password) {
                    layer.msg('请输入密码！');
                    return false;
                }
                $.post("<?php echo U('doLogin');?>", data.field, function (res) {
                    if (res.status == 1) {
                        layer.msg(res.info, function () {
                            location.href = "<?php echo U('Index/index');?>"
                        });
                    } else {
                        layer.msg(res.info);
                    }
                });
                return false;
            });
        });
    })
</script>

</body>
</html>