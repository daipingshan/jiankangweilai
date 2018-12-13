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
        <legend>添加课程信息</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">课程名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="course" placeholder="请输入课程名称"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程简介</label>
                    <div class="layui-input-block">
                        <textarea name="desc" placeholder="请输入课程简介"
                                  class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程封面</label>
                    <div class="layui-input-block" style="position: relative">
                        <input type="text" name="cover_url" id="img-input"
                               class="layui-input layui-disabled"
                               placeholder="请上传封面图片" readonly style="width: 75%">
                        <div style="position: absolute;left:80% ;top:0;">
                            <button type="button" class="layui-btn" id="layui-upload-file">
                                <i class="layui-icon">&#xe67c;</i>上传封面
                            </button>
                        </div>
                        <div style="position: absolute;left:80% ;top:50px;z-index: 10;display:none;">
                            <img src="" width="100" id="img">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">适合月份</label>
                    <div class="layui-input-inline">
                        <select name="suit_month">
                            <option value="">请选择适合月份</option>
                            <option value="-1">孕9个月</option>
                            <option value="-2">孕8个月</option>
                            <option value="-3">孕7个月</option>
                            <option value="-4">孕6个月</option>
                            <option value="-5">孕5个月</option>
                            <option value="-6">孕4个月</option>
                            <option value="-7">孕3个月</option>
                            <option value="-8">孕2个月</option>
                            <option value="-9">孕1个月</option>
                            <option value="0">新生儿</option>
                            <option value="1">1个月</option>
                            <option value="2">2个月</option>
                            <option value="3">3个月</option>
                            <option value="4">4个月</option>
                            <option value="5">5个月</option>
                            <option value="6">6个月</option>
                            <option value="7">7个月</option>
                            <option value="8">8个月</option>
                            <option value="9">9个月</option>
                            <option value="10">10个月</option>
                            <option value="11">11个月</option>
                            <option value="12">12个月</option>
                            <option value="13">13个月</option>
                            <option value="14">14个月</option>
                            <option value="15">15个月</option>
                            <option value="16">16个月</option>
                            <option value="17">17个月</option>
                            <option value="18">18个月</option>
                            <option value="19">19个月</option>
                            <option value="20">20个月</option>
                            <option value="21">21个月</option>
                            <option value="22">22个月</option>
                            <option value="23">23个月</option>
                            <option value="24">24个月</option>
                            <option value="25">25个月</option>
                            <option value="26">26个月</option>
                            <option value="27">27个月</option>
                            <option value="28">28个月</option>
                            <option value="29">29个月</option>
                            <option value="30">30个月</option>
                            <option value="31">31个月</option>
                            <option value="32">32个月</option>
                            <option value="33">33个月</option>
                            <option value="34">34个月</option>
                            <option value="35">35个月</option>
                            <option value="36">36个月</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="require" value="1" lay-filter="radio" title="必修" checked>
                        <input type="radio" name="require" value="2" lay-filter="radio" title="选修">
                    </div>
                </div>
                <div class="layui-form-item">
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
            //自定义工具栏
            layedit.build('layui-edit', {
                tool: ['face', 'link', 'unlink', '|', 'left', 'center', 'right']
                , height: 200
            })
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

            form.on('radio(radio)', function (data) {
                if (data.value == 2) {
                    $('#url').show();
                } else {
                    $('#url').hide();
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