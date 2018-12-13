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
                <select name="trainer_id">
                    <option value="">请选择健康管理员</option>
                    <?php if(is_array($trainer_data)): foreach($trainer_data as $k=>$row): ?><option value="<?php echo ($k); ?>"
                        <?php if(I('get.trainer_id') == $k): ?>selected<?php endif; ?>
                        ><?php echo ($row); ?></option><?php endforeach; endif; ?>
                </select>
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md2">
                <input type="text" name="caregiver_name" value="<?php echo I('get.caregiver_name');?>" placeholder="请输入养育人姓名"
                       class="layui-input">
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md2">
                <input type="text" name="caregiver_mobile" value="<?php echo I('get.caregiver_mobile');?>" placeholder="请输入养育人电话"
                       class="layui-input">
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md2">
                <input type="text" name="baby_name" value="<?php echo I('get.baby_name');?>" placeholder="请输入宝宝姓名"
                       class="layui-input">
            </div>
            <div class="layui-col-xs6 layui-col-sm6 layui-col-md3">
                <button class="layui-btn search" type="button"><i class="layui-icon">
                    &#xe615;</i>查询
                </button>
                <a class="layui-btn layui-btn-danger" href="<?php echo U('add');?>"><i class="layui-icon">
                    &#xe654;</i>添加养育人-宝宝
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
        <a class="layui-btn layui-btn-xs layui-btn-danger baby-grow" data-title="{{d.baby_name}}成长记录"
           data-url="<?php echo U('babyGrow');?>?id={{d.id}}">成长记录</a>
        <a class="layui-btn layui-btn-xs layui-btn-warm"
           href="<?php echo U('Train/index');?>?trainer_id={{d.trainer_id}}&caregiver_baby_id={{d.id}}">入户记录</a>
        <a class="layui-btn layui-btn-xs layui-btn-primary"
           href="<?php echo U('Exam/index');?>?trainer_id={{d.trainer_id}}&caregiver_baby_id={{d.id}}">考试记录</a>
    </script>
    <script type="text/html" id="trainer">
        {{d.real_name}}-{{d.mobile}}
    </script>
    <script type="text/html" id="baby_status">
        <input type="checkbox" lay-skin="switch" lay-text="已出生|孕育中" disabled
               {{ d.baby_status== 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="img">
        {{#  if(d. baby_avatar){ }}
        <div class="open-img-layer cursor"><img layer-src={{d.baby_avatar}} src="{{d.baby_avatar}}"
                                                alt="{{d.baby_name}}" width="120"></div>
        {{# } else { }}
        未上传宝宝图像
        {{# } }}
    </script>

    <script type="text/html" id="img-1">
        {{#  if(d. caregiver_avatar){ }}
        <div class="open-img-layer cursor"><img layer-src={{d.caregiver_avatar}} src="{{d.caregiver_avatar}}"
                                                alt="{{d.caregiver_name}}" width="120"></div>
        {{# } else { }}
        未上传养育人图像
        {{# } }}
    </script>

    <script type="text/html" id="baby_sex">
        {{#  if(d. baby_sex == 0){ }}
        孕育中
        {{# } else if(d.baby_sex == 1) { }}
        男
        {{# } else { }}
        女
        {{# } }}
    </script>
    <script>
        $(function () {
            form.render();
            var url = "<?php echo U('index');?>";
            getData(url);
            $('form.search').on('click', 'button.search', function () {
                var param = $('form.search').serialize();
                var get_url = url + '?' + param;
                getData(get_url);
            });

            $('body').on('mouseover', '.open-img-layer', function () {
                var _this = $(this);
                layer.photos({
                    photos: _this
                });
            })

            $('body').on('click', '.baby-grow', function () {
                var location_url = $(this).data('url');
                var title = $(this).data('title');
                layer.open({
                    type: 2,
                    title: title,
                    area: ['80%', '80%'],
                    content: location_url
                })
            })

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
                    , cellMinWidth: 120
                    , cols: [[
                        {field: 'id', width: 80, title: 'ID', sort: true}
                        , {field: 'real_name', width: 200, title: '健康管理员', templet: '#trainer'}
                        , {field: 'caregiver_name', title: '养育人姓名'}
                        , {field: 'caregiver_avatar', width: 150, title: '养育人图像', templet: '#img-1'}
                        , {field: 'caregiver_mobile', title: '养育人电话'}
                        , {field: 'caregiver_age', title: '养育人年龄'}
                        , {field: 'relation', title: '养育人宝宝关系'}
                        , {field: 'address', width: 200, title: '地址'}
                        , {field: 'baby_status', title: '宝宝状态', templet: '#baby_status'}
                        , {field: 'baby_name', title: '宝宝姓名'}
                        , {field: 'baby_sex', title: '宝宝性别', templet: '#baby_sex'}
                        , {field: 'baby_anemia_value', title: '宝宝贫血值'}
                        , {field: 'baby_avatar', width: 150, title: '宝宝图像', templet: '#img'}
                        , {fixed: 'right', title: '操作', toolbar: '#table-edit', width: 280,}
                    ]],
                });
            }
        })
    </script>

</body>
</html>