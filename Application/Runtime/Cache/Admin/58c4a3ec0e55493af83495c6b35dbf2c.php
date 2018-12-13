<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康未来-管理后台</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/common.css">
    
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
        
    <fieldset class="layui-elem-field w80">
        <legend>编辑养育人-宝宝信息</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">健康管理员</label>
                    <div class="layui-input-block w50">
                        <select name="trainer_id">
                            <option value="">请选择健康管理员</option>
                            <?php if(is_array($trainer_data)): foreach($trainer_data as $key=>$val): ?><option value="<?php echo ($key); ?>"
                                <?php if($info['trainer_id'] == $key): ?>selected<?php endif; ?>
                                ><?php echo ($val); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">养育人姓名</label>
                    <div class="layui-input-block w50">
                        <input type="text" name="caregiver_name" value="<?php echo ($info["caregiver_name"]); ?>" placeholder="请输入养育人姓名"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">养育人图像</label>
                    <div class="layui-input-block" style="position: relative">
                        <input type="text" name="caregiver_avatar" value="<?php echo ($info["caregiver_avatar"]); ?>" id="img-input-1"
                               class="layui-input layui-disabled"
                               placeholder="请上传图像" readonly style="width: 75%">
                        <div style="position: absolute;left:80% ;top:0;">
                            <button type="button" class="layui-btn" id="layui-upload-file-1">
                                <i class="layui-icon">&#xe67c;</i>上传养育人图像
                            </button>
                        </div>
                        <div style="position: absolute;left:80% ;top:50px;"
                        <?php if($info['caregiver_avatar'] == ''): ?>class="hide"<?php endif; ?>
                        >
                        <img src="<?php echo ($info["baby_avatar"]); ?>" width="100" id="img-1">
                    </div>
                </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">养育人电话</label>
            <div class="layui-input-block w50">
                <input type="text" name="caregiver_mobile" value="<?php echo ($info["caregiver_mobile"]); ?>"
                       placeholder="请输入养育人电话"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">养育人出生日期</label>
            <div class="layui-input-inline">
                <input type="text" name="caregiver_birthday" id="caregiver_birthday"
                       value="<?php echo ($info["caregiver_birthday"]); ?>" placeholder="请选择养育人出生日期"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">养育人宝宝关系</label>
            <div class="layui-input-block w50">
                <select name="relation">
                    <option value="">请选择养育人宝宝关系</option>
                    <?php if(is_array($relation)): $i = 0; $__LIST__ = $relation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><option value="<?php echo ($row); ?>"
                        <?php if($info["relation"] == $row): ?>selected<?php endif; ?>
                        ><?php echo ($row); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
                <input type="text" name="address" value="<?php echo ($info["address"]); ?>" placeholder="地址"
                       class="layui-input">
            </div>
        </div>
        <?php if(($info["baby_status"]) == "0"): ?><div class="layui-form-item">
                <label class="layui-form-label">宝宝状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="baby_status" value="1" lay-filter="baby_status" title="已出生"
                    <?php if(($info["baby_status"]) == "1"): ?>checked<?php endif; ?>
                    >
                    <input type="radio" name="baby_status" value="0" lay-filter="baby_status" title="孕育中"
                    <?php if(($info["baby_status"]) == "0"): ?>checked<?php endif; ?>
                    >
                </div>
            </div><?php endif; ?>
        <div id="baby_yes"
        <?php if(($info["baby_status"]) == "0"): ?>class="hide"<?php endif; ?>
        >
        <div class="layui-form-item">
            <label class="layui-form-label">宝宝姓名</label>
            <div class="layui-input-block w50">
                <input type="text" name="baby_name" value="<?php echo ($info["baby_name"]); ?>" placeholder="请输入宝宝姓名"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">宝宝性别</label>
            <div class="layui-input-block">
                <input type="radio" name="baby_sex" value="1" lay-filter="baby_sex" title="男"
                <?php if(($info["baby_sex"]) == "1"): ?>checked<?php endif; ?>
                >
                <input type="radio" name="baby_sex" value="2" lay-filter="baby_sex" title="女"
                <?php if(($info["baby_sex"]) == "2"): ?>checked<?php endif; ?>
                >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">宝宝图像</label>
            <div class="layui-input-block" style="position: relative">
                <input type="text" name="baby_avatar" value="<?php echo ($info["baby_avatar"]); ?>" id="img-input"
                       class="layui-input layui-disabled"
                       placeholder="请上传图像" readonly style="width: 75%">
                <div style="position: absolute;left:80% ;top:0;">
                    <button type="button" class="layui-btn" id="layui-upload-file">
                        <i class="layui-icon">&#xe67c;</i>上传宝宝图像
                    </button>
                </div>
                <div style="position: absolute;left:80% ;top:50px;"
                <?php if($info['baby_avatar'] == ''): ?>class="hide"<?php endif; ?>
                >
                <img src="<?php echo ($info["baby_avatar"]); ?>" width="100" id="img">
            </div>
        </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">宝宝贫血值</label>
            <div class="layui-input-block w50">
                <input type="number" step="0.1" name="baby_anemia_value" value="<?php echo ($info["baby_anemia_value"]); ?>"
                       placeholder="请输入宝宝贫血值"
                       class="layui-input">
            </div>
        </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" id="baby-birthday">宝宝出生日期</label>
            <div class="layui-input-inline">
                <input type="text" name="baby_birthday" id="baby_birthday" value="<?php echo ($info["baby_birthday"]); ?>"
                       placeholder="请选择日期"
                       class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit" type="submit">提交</button>
            </div>
        </div>
        </form>
        </div>
    </fieldset>

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


    <script>
        $(function () {
            var index;
            form.render();
            //日期选择器
            laydate.render({
                elem: '#caregiver_birthday'
            });
            //日期选择器
            laydate.render({
                elem: '#baby_birthday'
            });
            upload.render({
                elem: '#layui-upload-file'
                , url: '/Common/uploadImg'
                , before: function () {
                    index = layer.msg('上传中，请稍候', {icon: 16, time: false, shade: 0.8});
                }
                , done: function (res) {
                    layer.close(index);
                    layer.msg(res.message);
                    if (res.state == 'SUCCESS') {
                        $('#img-input').val(res.url);
                        $('#img').attr('src', res.url).parent().show();
                    }
                }
            });
            upload.render({
                elem: '#layui-upload-file-1'
                , url: '/Common/uploadImg'
                , before: function () {
                    index = layer.msg('上传中，请稍候', {icon: 16, time: false, shade: 0.8});
                }
                , done: function (res) {
                    layer.close(index);
                    layer.msg(res.message);
                    if (res.state == 'SUCCESS') {
                        $('#img-input-1').val(res.url);
                        $('#img-1').attr('src', res.url).parent().show();
                    }
                }
            });
            form.on('radio(baby_status)', function (data) {
                if (data.value == 1) {
                    $('#baby-birthday').text('宝宝出生日期');
                    $('#baby_yes').show();
                } else {
                    $('#baby-birthday').text('宝宝预产期');
                    $('#baby_yes').hide();
                }
            });
            form.on('submit(submit)', function (data) {
                var _this = this;
                _this.disabled = true;
                $.post("<?php echo U('save');?>", data.field, function (res) {
                    if (res.status == 1) {
                        layer.msg(res.info, function () {
                            location.href = "<?php echo U('index');?>"
                        });
                    } else {
                        _this.disabled = false;
                        layer.msg(res.info);
                    }
                });
                return false;
            });
        })
    </script>

</body>
</html>