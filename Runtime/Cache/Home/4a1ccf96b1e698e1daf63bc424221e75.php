<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>修改支付密码-雪宝集团</title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_003.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
</head>
<body class="body_bj">
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">修改支付密码</div>
            <div class="h-right">
                <aside class="top_bar">
                    <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a></div>
                </aside>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript" src="/Public/assets/js/mobile.js"></script>
<div class="goods_nav hid" id="menu">
    <div class="Triangle">
        <h2></h2>
    </div>
    <ul>
        <li><a href="/"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="/index.php/Home/Goods/showspfl"><span class="menu2"></span><i>分类</i></a></li>
        <li><a href="/index.php/Home/Basket"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="/index.php/Home/Cust"><span class="menu4"></span><i>我的</i></a></li>
    </ul>
</div>
<div id="tbh5v0">

    <div class="Personal">
        <div id="tbh5v0">
            <div class="innercontent1">
                <form method="post" action="" id="edit_profile">

                    <div class="name"><span>原密码：</span><input name="oldpwd" id="oldpwd" type="password" class="mima"></div>
                    <div class="name"><span>新密码：</span><input name="newpwd1" id="newpwd1" type="password" class="mima"></div>
                    <div class="name"><span>确认密码：</span><input name="newpwd2" id="newpwd2" type="password" class="mima"></div>
                    <div class="name"> 新密码不能空且必须为6位及以上</div>
                    <p style="height:30px;"></p>

                    <div class="field submit-btn"><input class="tijiao_butn" value="确认修改" id="btnsubmit" type="button" onclick="gosubmit()"></div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    function gosubmit() {
        var oldpwd = $("#oldpwd").val();
        var newpwd1 = $("#newpwd1").val();
        var newpwd2 = $("#newpwd2").val();
        if (newpwd1 == "" || newpwd1.length < 6) {
            alert("新密码不能空且必须为6位及以上！");
            return false;
        }
        if (newpwd1 != newpwd2) {
            alert("输入的两次新密码不一致!");
            return false;
        }
        var url = "/index.php/Home/Cust/zfpwdchange";
        $.get(url, {"oldpwd": oldpwd, "newpwd1": newpwd1, "newpwd2": newpwd2}, function (data) {
            var result = eval('(' + data + ')');
            alert(result.msg);
        });


    }
</script>