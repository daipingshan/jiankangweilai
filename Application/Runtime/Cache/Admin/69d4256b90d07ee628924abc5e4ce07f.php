<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康未来-管理后台</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/common.css">
    
    <style type="text/css">
        .img-box {
            width: 20%;
            margin: 2%;
            border: 1px solid #ccc;
            position: relative;
            float: left;
        }

        .img-box img {
            width: 100%;
        }

        .img-box button {
            position: absolute;
            top: 0;
            right: 0;
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
        
    <fieldset class="layui-elem-field w80">
        <legend>编辑知识点问题信息</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">问题概述</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="<?php echo ($info["title"]); ?>" placeholder="请输入问题概述"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">问题内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="question" value="<?php echo ($info["question"]); ?>" placeholder="请输入问题内容"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">问题类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="question_type" value="select"
                               lay-filter="question_type" title="选择题"
                        <?php if($info['question_type'] == 'select'): ?>checked<?php endif; ?>
                        >
                        <input type="radio" name="question_type" value="completion" lay-filter="question_type"
                               title="填空题"
                        <?php if($info['question_type'] == 'completion'): ?>checked<?php endif; ?>
                        >
                    </div>
                </div>
                <fieldset id="select"
                <?php if($info['question_type'] == 'completion'): ?>class="layui-elem-field hide"
                    <?php else: ?>
                    class="layui-elem-field"<?php endif; ?>
                >
                <legend>选择答案类型-答案内容</legend>
                <div class="layui-field-box">
                    <div class="layui-form-item">
                        <label class="layui-form-label">答案类型</label>
                        <div class="layui-input-block">
                            <input type="radio" name="select_type" value="single"
                                   lay-filter="select_type" title="单选"
                            <?php if($info['select_type'] == 'single'): ?>checked<?php endif; ?>
                            >
                            <input type="radio" name="select_type" value="multiple" lay-filter="select_type"
                                   title="多选"
                            <?php if($info['select_type'] == 'completion'): ?>checked<?php endif; ?>
                            >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">问题答案</label>
                        <div class="layui-input-block">
                            <?php if(empty($info["answer_option"])): ?><input type="text" name="answer_option[]"
                                       style="display: inline-block;margin-bottom: 10px" placeholder="请输入问题答案"
                                       class="layui-input">
                                <input type="text" name="answer_option[]"
                                       style="display: inline-block;margin-bottom: 10px" placeholder="请输入问题答案"
                                       class="layui-input">
                                <?php else: ?>
                                <?php if(is_array($info["answer_option"])): $i = 0; $__LIST__ = $info["answer_option"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><input type="text" name="answer_option[]" value="<?php echo ($row); ?>"
                                           style="display: inline-block;margin-bottom: 10px" placeholder="请输入问题答案"
                                           class="layui-input"><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            <div id="before" class="hide"></div>
                        </div>
                    </div>
                    <button type="button"
                            class="layui-btn layui-btn-danger add-answer">添加答案输入框
                    </button>
                </div>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">问题简介</label>
        <div class="layui-input-block">
                        <textarea name="desc" class="layui-textarea" id="desc"
                                  placeholder="请输入知识点简介"><?php echo ($info["desc"]); ?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">问题视频</label>
        <div class="layui-input-block" style="position: relative">
            <input type="text" name="video" value="<?php echo ($info["video"]); ?>" id="video-input"
                   class="layui-input layui-disabled"
                   placeholder="请上传视频" readonly style="width: 75%">
            <div style="position: absolute;left:80% ;top:0;">
                <button type="button" class="layui-btn" id="layui-upload-video">
                    <i class="layui-icon">&#xe67c;</i>上传视频
                </button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
            <input type="hidden" name="knowledge_id" value="<?php echo ($info["knowledge_id"]); ?>">
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


    <script type="text/javascript" src='/Public/Editor/ueditor.config.js'></script>
    <script type="text/javascript" src='/Public/Editor/ueditor.all.min.js'></script>
    <script>
        $(function () {
            var index;
            form.render();
            //var edit_index = layedit.build('desc');
            window.UEDITOR_CONFIG.initialFrameHeight = 400; //设置高度
            window.UEDITOR_CONFIG.initialFrameWidth = 900;//设置宽度录
            UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
            UE.Editor.prototype.getActionUrl = function (action) {
                if (action == 'uploadimage' || action == 'uploadscrawl' || action == 'uploadimage') {
                    return "<?php echo U('Common/uploadImg');?>";
                } else {
                    return this._bkGetActionUrl.call(this, action);
                }
            }
            var desc = UE.getEditor('desc');
            upload.render({
                elem: '#layui-upload-video'
                , accept: 'video'
                , url: '/Common/uploadImg'
                , before: function () {
                    index = layer.msg('上传中，请稍候', {icon: 16, time: false, shade: 0.8});
                }
                , done: function (res) {
                    layer.close(index);
                    layer.msg(res.message);
                    if (res.state == 'SUCCESS') {
                        $('#video-input').val(res.url);
                    }
                }
            });
            form.on('radio(question_type)', function (data) {
                if (data.value == 'select') {
                    $('#select').removeClass('hide');
                } else {
                    $('#select').addClass('hide');
                }
            });
            $('body').on('click', '.add-answer', function () {
                var html = ' <input type="text" name="answer_option[]" style="display: inline-block;margin-bottom: 10px" placeholder="请输入问题答案" class="layui-input">';
                $('#before').before(html);
            });

            form.on('submit(submit)', function (data) {
                var _this = this;
                _this.disabled = true;
                $.post("<?php echo U('saveQuestion');?>", data.field, function (res) {
                    if (res.status == 1) {
                        layer.msg(res.info, function () {
                            location.href = "<?php echo U('question',array('knowledge_id'=>$info['knowledge_id']));?>"
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