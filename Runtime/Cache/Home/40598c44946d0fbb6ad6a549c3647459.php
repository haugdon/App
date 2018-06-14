<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0047)http://127.0.0.1:8080/mobile/flow.php?step=done -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">

    <meta name="viewport" content="width=device-width">
    <title>送货员中心-雪宝集团 </title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/datedropper.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/timedropper.min.css">
    <script src="/Public/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
</head>
<body>


<div id="tbh5v0">

    <div class="user_com">
        <div class="tab_nav">
            <div class="header" style=" position:relative">
                <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
                <div class="h-mid"> 生成周转箱</div>
            </div>
            <dl>
                <dd class="top_bar" style=" position:absolute; top:0; right:2%; z-index:999999">
                    <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a></div>
                </dd>
            </dl>
        </div>
        <script type="text/javascript" src="/Public/assets/js/mobile.js"></script>
        <div class="goods_nav hid" id="menu">
            <div class="Triangle">
                <h2></h2>
            </div>
            <ul>
                <li><a href="/index.php/Home/Shy/showxuandan"><span class="menu2"></span><i>周转箱</i></a></li>
                <li style=" border:0;"><a href="/index.php/Home/Shy"><span class="menu4"></span><i>我的</i></a></li>
            </ul>
        </div>

        <div class="zzx_search">

            <dl>
                <dt><strong>选单生成周转箱</strong></dt>
            </dl>
            <form action="/index.php/Home/Shy/searchorder" method="post">
                <p>选择开始时间：<input type="text" class="input" id="pickdate" name="rq1" value="<?php echo ($defrq); ?>" style="width:160px;text-align:left;"/></p>
                <p>选择结束时间：<input type="text" class="input" id="pickdate1" name="rq2" value="<?php echo ($defrq); ?>" style="width:160px;text-align:left;"/></p>
                <p style="padding-left:64px;">选择经销商：<select name="khid" class="input" style="width:170px;">
                    <option value="0" selected>全部</option>
                    <?php if(is_array($khlist)): $i = 0; $__LIST__ = $khlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value=<?php echo ($vo["fcustid"]); ?>><?php echo ($vo["fname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select></p>
                <div style="clear: both;"></div>
                <div style="margin:0 auto; text-align:center;">
                    <input class="shy_button" type="submit"></input></div>
            </form>
        </div>

    </div>
    <div style="height:50px; line-height:50px; clear:both;"></div>
    <script>
        function goTop() {
            $('html,body').animate({'scrollTop': 0}, 600);
        }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>
</div>
<script src="/Public/assets/js/datedropper.min.js"></script>
<script src="/Public/assets/js/timedropper.min.js"></script>
<script>
    $("#pickdate").dateDropper({
        animate: false,
        format: 'Y-m-d',
        maxYear: '2020'
    });
    $("#picktime").timeDropper({
        meridians: false,
        format: 'HH:mm',
    });
</script>
<script>
    $("#pickdate1").dateDropper({
        animate: false,
        format: 'Y-m-d',
        maxYear: '2020'
    });
    $("#picktime1").timeDropper({
        meridians: false,
        format: 'HH:mm',
    });
</script>
</body>
</html>