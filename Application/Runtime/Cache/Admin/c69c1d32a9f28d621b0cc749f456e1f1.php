<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康未来-管理后台</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/common.css">
    
    <style type="text/css">
        .row {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
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
                            class="layui-icon layui-icon-app"></i> 广告管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('Advert/index');?>" data-type="2">广告列表</a></dd>
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
                <li class="layui-nav-item"><a href="<?php echo U('Feedback/index');?>" data-type="1"><i
                        class="layui-icon layui-icon-app"></i> 意见反馈</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body" style="padding: 20px">
        <!-- 内容主体区域 -->
        
    <fieldset class="layui-elem-field w80">
        <legend>添加试题信息</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">所属试卷</label>
                    <div class="layui-input-block">
                        <select name="test_paper_id" lay-filter="paper">
                            <option value="">请选择试卷</option>
                            <?php if(is_array($paper_data)): foreach($paper_data as $key=>$val): ?><option value="<?php echo ($key); ?>"
                                <?php if($info["test_paper_id"] == $key): ?>selected<?php endif; ?>
                                ><?php echo ($val); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">所属知识点</label>
                    <div class="layui-input-block">
                        <select name="knowledge_id" id="knowledge_id">
                            <option value="">请选择所属知识点</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">试题分值</label>
                    <div class="layui-input-inline">
                        <input type="number" name="score" value="<?php echo ($info["score"]); ?>" placeholder="请输入试题分值"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">试题类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="select_type" value="single" title="单选"
                        <?php if($info["select_type"] == 'single'): ?>checked<?php endif; ?>
                        >
                        <input type="radio" name="select_type" value="multiple" title="多选"
                        <?php if($info["select_type"] == 'multiple'): ?>checked<?php endif; ?>
                        >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">试题问题</label>
                    <div class="layui-input-block">
                         <textarea name="question" placeholder="请输入试题问题"
                                   class="layui-textarea"><?php echo ($info["question"]); ?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <fieldset class="layui-elem-field w80">
                        <legend>试题答案可选项</legend>
                        <div class="layui-field-box" id="answer-box">
                            <?php if(is_array($info["answer_option_data"])): foreach($info["answer_option_data"] as $key=>$val): ?><div class="row">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">类型</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="answer_option[type][<?php echo ($key); ?>]" value="text"
                                                   lay-filter="radio" title="文字"
                                            <?php if($val['type'] == 'text'): ?>checked<?php endif; ?>
                                            >
                                            <input type="radio" name="answer_option[type][<?php echo ($key); ?>]" value="pic"
                                                   lay-filter="radio"
                                                   title="图片"
                                            <?php if($val['type'] == 'pic'): ?>checked<?php endif; ?>
                                            >
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">选项值</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="answer_option[value][<?php echo ($key); ?>]"
                                                   value="<?php echo ($val['value']); ?>"
                                                   placeholder="请输入选项值：【例如：A】"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                    <div
                                    <?php if($val['type'] == 'text'): ?>class="layui-form-item content-text"
                                        <?php else: ?>
                                        class="layui-form-item content-text hide"<?php endif; ?>
                                    >
                                    <label class="layui-form-label">内容</label>
                                    <div class="layui-input-block">
                                        <textarea name="answer_option[content_text][<?php echo ($key); ?>]" placeholder="请输入选项内容"
                                                  class="layui-textarea"><?php if($val['type'] == 'text'): echo ($val['content']); endif; ?></textarea>
                                    </div>
                                </div>
                                <div
                                <?php if($val['type'] == 'pic'): ?>class="layui-form-item content-pic"
                                    <?php else: ?>
                                    class="layui-form-item content-pic hide"<?php endif; ?>
                                >
                                <label class="layui-form-label">内容</label>
                                <div class="layui-input-block">
                                    <input type="text" name="answer_option[content_pic][<?php echo ($key); ?>]"
                                    <?php if($val['type'] == 'pic'): ?>value="<?php echo ($val['content']); ?>"<?php endif; ?>
                                    id="img-input-<?php echo ($key); ?>"
                                    class="layui-input layui-disabled"
                                    placeholder="请上传选项图片" readonly style="width: 75%">
                                    <div style="position: absolute;left:80% ;top:0;">
                                        <button type="button" class="layui-btn" id="layui-upload-file-<?php echo ($key); ?>">
                                            <i class="layui-icon">&#xe67c;</i>上传图片
                                        </button>
                                    </div>
                                    <div style="position: absolute;left:80% ;top:50px;"
                                    <?php if($val['type'] == 'text'): ?>class="hide"<?php endif; ?>
                                    >
                                    <img
                                    <?php if($val['type'] == 'pic'): ?>src="<?php echo ($val['content']); ?>"<?php endif; ?>
                                    " width="100" id="img-<?php echo ($key); ?>">
                                </div>
                        </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">正确答案</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="answer_option[answer][<?php echo ($key); ?>]" title="是" value="1"
                        <?php if($val['answer'] == 1): ?>checked<?php endif; ?>
                        >
                    </div>
                </div>
        </div><?php endforeach; endif; ?>
        </div>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">解释说明</label>
        <div class="layui-input-block">
                                            <textarea name="explain" placeholder="请输入解释说明"
                                                      class="layui-textarea"><?php echo ($info["explain"]); ?></textarea>
        </div>
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
            var paper_id = "<?php echo ($info['test_paper_id']); ?>";
            var knowledge_id = "<?php echo ($info['knowledge_id']); ?>";
            if (paper_id > 0) {
                getKnowledge(paper_id, knowledge_id);
            }
            form.on('select(paper)', function (data) {
                if (data.value > 0) {
                    getKnowledge(data.value, 0);
                }
            })

            $('body').on('click', '.del-box', function () {
                $(this).parent().remove();
            })

            $('#answer-box .row').each(function (e) {
                upload.render({
                    elem: '#layui-upload-file-' + e
                    , url: '/Common/uploadImg'
                    , before: function () {
                        index = layer.msg('上传中，请稍候', {icon: 16, time: false, shade: 0.8});
                    }
                    , done: function (res) {
                        layer.close(index);
                        layer.msg(res.message);
                        if (res.state == 'SUCCESS') {
                            $('#img-input-' + e).val(res.url);
                            $('#img-' + e).attr('src', res.url).parent().show();
                        }
                    }
                });
            })

            form.on('radio(radio)', function (data) {
                if (data.value == 'pic') {
                    data.othis.parents('.row').find('.content-text').hide();
                    data.othis.parents('.row').find('.content-pic').show();
                } else {
                    data.othis.parents('.row').find('.content-text').show();
                    data.othis.parents('.row').find('.content-pic').hide();
                }
            });

            function getKnowledge(paper_id, knowledge_id) {
                $.get("<?php echo U('getKnowledgeData');?>", {test_paper_id: paper_id}, function (res) {
                    var data = res.info;
                    if (data.length > 0) {
                        var html = "<option value=''>请选择所属知识点</option>";
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].id == knowledge_id) {
                                html += "<option value='" + data[i].id + "' selected>" + data[i].name + "</option>"
                            } else {
                                html += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
                            }
                        }
                        $('#knowledge_id').html(html);
                        form.render('select');
                    }
                })
            }

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