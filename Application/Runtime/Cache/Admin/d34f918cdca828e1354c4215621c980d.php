<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康未来-管理后台</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/common.css">
    
    <style type="text/css">
        .layui-form-select .layui-edge {
            right: 25%;
        }

        .layui-form-select dl {
            min-width: 80%;
        }

    </style>

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">健康未来-管理后台</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    <?php echo session('admin_user_info')['username'];?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" onclick="updatePass()">修改密码</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="<?php echo U('Login/logout');?>">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" id="nav">
                <li class="layui-nav-item"><a href="<?php echo U('Index/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 控制台</a></li>
                <li class="layui-nav-item"><a href="<?php echo U('Config/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 系统设置</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 通知管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Advert/index');?>" data-type="2">通知列表</a></dd>
                        <dd><a href="<?php echo U('advert/add');?>" data-type="2">添加广告</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 健康管理员</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Trainer/index');?>" data-type="2">健康管理员列表</a></dd>
                        <dd><a href="<?php echo U('Trainer/add');?>" data-type="2">添加健康管理员</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 养育人-宝宝</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('CaregiverBaby/index');?>" data-type="2">养育人-宝宝列表</a></dd>
                        <dd><a href="<?php echo U('CaregiverBaby/add');?>" data-type="2">添加养育人</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 课程管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Course/index');?>" data-type="2">课程列表</a></dd>
                        <dd><a href="<?php echo U('Course/add');?>" data-type="2">添加课程</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 知识点管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Knowledge/index');?>" data-type="2">知识点列表</a></dd>
                        <dd><a href="<?php echo U('Knowledge/add');?>" data-type="2">添加知识点</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 试卷管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Paper/index');?>" data-type="2">试卷列表</a></dd>
                        <dd><a href="<?php echo U('Paper/add');?>" data-type="2">添加试卷</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i
                            class="layui-icon layui-icon-app"></i> 试题管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Question/index');?>" data-type="2">试题列表</a></dd>
                        <dd><a href="<?php echo U('Question/add');?>" data-type="2">添加试题</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="<?php echo U('Train/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 入户记录</a></li>
                <li class="layui-nav-item"><a href="<?php echo U('Exam/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 考试记录</a></li>
                <li class="layui-nav-item"><a href="<?php echo U('Feedback/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 意见反馈</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body" style="padding: 20px">
        <!-- 内容主体区域 -->
        
    <form class="layui-form search" action="" name="search">
        <div class="layui-row">
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md3">
                <select name="course_id">
                    <option value="">请选择所属课程</option>
                    <?php if(is_array($course_data)): foreach($course_data as $key=>$val): ?><option value="<?php echo ($key); ?>"><?php echo ($val); ?></option><?php endforeach; endif; ?>
                </select>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md3">
                <input type="text" name="test_paper_name" value="<?php echo I('get.test_paper_name');?>" placeholder="请输入试卷名称"
                       class="layui-input">
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md3">
                <button class="layui-btn search" type="button"><i class="layui-icon">
                    &#xe615;</i>查询
                </button>
                <a class="layui-btn layui-btn-danger" href="<?php echo U('add');?>"><i class="layui-icon">
                    &#xe654;</i>添加试卷
                </a>
            </div>
        </div>
    </form>
    <table class="layui-hide" id="table" lay-filter="table"></table>

    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © Copyright ©2017-2018 dps v1.0 All Rights Reserved. 本后台系统由dps提供技术支持
    </div>
</div>
<div class="hide" style="padding: 20px" id="update-pass">
    <form class="layui-form" action="" name="update-pass">
        <div class="layui-form-item">
            <label class="layui-form-label">登录密码</label>
            <div class="layui-input-block">
                <input type="text" placeholder="请输入登录密码" name="password" class="layui-input"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-block">
                <input type="text" placeholder="请输入确认密码" name="pass" class="layui-input"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="update-pass">修改</button>
            </div>
        </div>
    </form>
</div>

<script src="/Public/Admin/lib/layui/layui.all.js"></script>
<script>
    var layer = layui.layer,
        element = layui.element,
        form = layui.form,
        laydate = layui.laydate,
        upload = layui.upload,
        carousel = layui.carousel,
        flow = layui.flow,
        util = layui.util,
        table = layui.table,
        laypage = layui.laypage,
        laytpl = layui.laytpl,
        layedit = layui.layedit,
        $ = layui.jquery;

    layedit.set({
        uploadImage: {
            url: '/Common/uploadEditImg' //接口url
            , type: 'post' //默认post
        }
    });

    function updatePass() {
        $('#update-pass input').val('');
        layer.open({
            type: 1,
            title: '修改密码',
            area: ['500px', '260px'],
            content: $('#update-pass')
        })
    }

    //监听提交
    form.on('submit(update-pass)', function (data) {
        if (!data.field.password) {
            layer.msg('请输入登录密码！');
            return false;
        }
        if (!data.field.pass) {
            layer.msg('请输入确认密码！');
            return false;
        }
        if (data.field.password != data.field.pass) {
            layer.msg('两次密码不一致！');
            return false;
        }
        $.post("<?php echo U('Index/updatePass');?>", data.field, function (res) {
            if (res.status == 1) {
                layer.msg(res.info, function () {
                    parent.layer.closeAll();
                });
            } else {
                layer.msg(res.info);
            }
        });
        return false;
    });

    var location_url = window.location.href;
    $('#nav a').each(function () {
        if ($(this).attr('href') != 'javascript:;') {
            var url_arr = $(this).attr('href').split('.');
            if (location_url.indexOf(url_arr[0]) != -1) {
                if ($(this).data('type') == 2) {
                    $(this).parents('li').addClass('layui-nav-itemed');
                }
                $(this).parent().addClass('layui-this');
            }
        }
    });

</script>


    <script type="text/html" id="table-edit">
        <a class="layui-btn layui-btn-xs" href="<?php echo U('update');?>?id={{d.id}}">编辑</a>
        <a class="layui-btn layui-btn-xs layui-btn-danger" href="<?php echo U('Question/add');?>?test_paper_id={{d.id}}">添加试题</a>
    </script>
    <script>
        $(function () {
            var url = "<?php echo U('index');?>";
            form.render();
            var get_param = $('form.search').serialize();
            var get_url = url + '?' + get_param;
            getData(get_url);
            $('form.search').on('click', 'button.search', function () {
                var param = $('form.search').serialize();
                var get_url = url + '?' + param;
                getData(get_url);
            });

            /**
             * 获取数据
             * @param url
             */
            function getData(url) {
                table.render({
                    elem: '#table'
                    , url: url
                    , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                        , groups: 5 //只显示 1 个连续页码
                    }
                    , cellMinWidth: 100
                    , cols: [[
                        {field: 'id', title: '试卷ID', sort: true}
                        , {field: 'course', width: 200, title: '课程名称'}
                        , {field: 'test_paper_name', width: 200, title: '试卷名称'}
                        , {field: 'question_info', width: 260, title: '试题信息'}
                        , {field: 'add_time', width: 160, title: '添加时间'}
                        , {field: 'update_time', width: 160, title: '更新时间'}
                        , {fixed: 'right', title: '操作', toolbar: '#table-edit', width: 200}
                    ]],
                });
            }
        })
    </script>

</body>
</html>