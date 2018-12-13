<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>健康未来-管理后台</title>
    <link rel="stylesheet" href="/Public/Admin/lib/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/common.css">
    
</head>
<body class="layui-layout-body" style="left: 0;padding: 20px">

    <table class="layui-table" lay-skin="line">
        <colgroup>
            <col style="width: 10%">
            <col style="width: 10%">
            <col style="width: 30%">
            <col style="width: 20%">
            <col style="width: 10%">
            <col style="width: 20%">
        </colgroup>
        <thead>
        <tr>
            <th>身高</th>
            <th>体重</th>
            <th>打过的疫苗</th>
            <th>吃过的营养包数</th>
            <th>贫血值</th>
            <th>记录时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($row["height"]); ?>cm</td>
                <td><?php echo ($row["weight"]); ?>公斤</td>
                <td><?php echo ($row["vaccine"]); ?></td>
                <td><?php echo ($row["nutrition_num"]); ?></td>
                <td><?php echo ($row["baby_anemia_value"]); ?></td>
                <td><?php echo ($row["add_time"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

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
</script>


</body>
</html>