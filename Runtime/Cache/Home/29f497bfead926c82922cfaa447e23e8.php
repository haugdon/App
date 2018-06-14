<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>用户信息-雪宝集团</title>
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
            <div class="h-mid">用户信息</div>
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
                <form method="post" action="user.php" id="edit_profile">
                    <div class="name"><span>用户名：</span>
                        <?php echo ($custname); ?>
                    </div>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="name"><span>地址：</span><?php echo ($vo["faddress"]); ?></div>
                        <div class="name"><span>联系人：</span><?php echo ($vo["fcontact"]); ?></div>
                        <div class="name"><span>电话：</span><?php echo ($vo["fmobilephone"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>

                    <div class="field submit-btn"></div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>