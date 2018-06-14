<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<!-- saved from url=(0047)http://127.0.0.1:8080/mobile/flow.php?step=done -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">

    <meta name="viewport" content="width=device-width">
    <title>用户中心-雪宝集团 </title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">
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

        <div class="com_top">

            <i>普通经销商</i>
            <dl>
                <dt></dt>
                <dd><span><?php echo ($cust_name); ?></span></dd>
            </dl>

            <!--
            <ul>
            <li class="bain"><a href="user.php?act=order_list" ><span>5</span>我的订单</a></li>
            <li class="bain"><a href="user.php?act=collection_list"><span>0</span>我的收藏</a></li>
            <li style=" border:0"><a href="user.php?act=my_comment"><span>0</span>我的评价</a></li>
            </ul>
            -->
        </div>

        <div class="Order">
            <dl><a href="/index.php/Home/Cust/showorderlist">
                <dt><strong>全部订单</strong><span>查看全部订单</span></dt>
            </a></dl>
            <ul>
                <?php if(is_array($ordercountlist)): $i = 0; $__LIST__ = $ordercountlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orderlist): $mod = ($i % 2 );++$i;?><li><a href="/index.php/Home/Cust/showorderlist?status=dfk"><em class="ordem2"><i><?php echo ($orderlist["dfk"]); ?></i></em><span>待付款</span></a></li>
                    <li><a href="/index.php/Home/Cust/showorderlist?status=dfh"><em class="ordem3"><i><?php echo ($orderlist["dfh"]); ?></i></em><span>待发货</span></a></li>
                    <li><a href="/index.php/Home/Cust/showorderlist?status=dsh"><em class="ordem1"><i><?php echo ($orderlist["dsh"]); ?></i></em><span>待收货</span></a></li>
                    <li><a href="/index.php/Home/Cust/showorderlist?status=ywc"><em class="ordem4"><i><?php echo ($orderlist["ywc"]); ?></i></em><span>已完成</span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>

        <div class="Assets">
            <dl>
                <dt><strong>我的资金</strong></dt>
            </dl>
            <ul>
                <?php if(is_array($balancelist)): $i = 0; $__LIST__ = $balancelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$balance): $mod = ($i % 2 );++$i;?><li><a><i class="Assets3"></i><span>促销余额</span><span><?php if($balance['fbalanceamount'] != 0 ): ?>￥<?php echo ($balance["fbalanceamount"]); else: ?>￥0.00<?php endif; ?></span></a></li>
                    <li><a><i class="Assets2"></i><span>信用额度</span><span><?php if($balance['fcreditamount'] != 0 ): ?>￥<?php echo ($balance["fcreditamount"]); else: ?>￥0.00<?php endif; ?></span></a></li>
                    <li><a><i class="Assets4"></i><span>预存款</span><span><?php if($balance['yck'] != 0 ): ?>￥<?php echo ($balance["yck"]); else: ?>￥0.00<?php endif; ?></span></a></li>
                    <!--<li><a><i class="Assets1"></i><span>今日退款</span><span><?php if($balance['jrtk'] != 0 ): ?>￥<?php echo ($balance["yck"]); else: ?>￥0.00<?php endif; ?></span></a></li>--><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>

        <div class="Wallet main_top">
            <a href="/index.php/Home/Cust/showtkmx?status=tkmx"><em class="Icon1"></em>
                <dl class="border_bottm">
                    <dt>退款明细</dt>
                    <dd>退款明细列表</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showjymx?status=jymx"><em class="Icon5"></em>
                <dl class="border_bottm">
                    <dt>交易明细</dt>
                    <dd>交易明细列表</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showfalb" style="display: none"><em class="Icon1"></em>
                <dl class="border_bottm">
                    <dt>方案订货</dt>
                    <dd>查看方案订货列表</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showfavorite"><em class="Icon2"></em>
                <dl>
                    <dt>我的收藏</dt>
                    <dd>我的收藏列表</dd>
                </dl>
            </a>
        </div>


        <div class="Wallet main_top">
            <a href="/index.php/Home/Cust/showcustaddress"><em class="Icon3"></em>
                <dl class="border_bottm">
                    <dt>收货地址</dt>
                    <dd>收货地址列表</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showprofile"><em class="Icon4"></em>
                <dl class="border_bottm">
                    <dt>我的信息</dt>
                    <dd>&nbsp;</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showpassword"><em class="Icon9"></em>
                <dl class="border_bottm">
                    <dt>修改密码</dt>
                    <dd>&nbsp;</dd>
                </dl>
            </a>
        </div>

    </div>
    <div style="height:50px; line-height:50px; clear:both;"></div>
    <!DOCTYPE html>
<script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
<link rel="stylesheet" type="text/css" href="/Public/assets/css/goods.css">
<div class="v_nav">
    <div class="vf_nav">
        <ul>
            <li><a href="/">
                <i class="vf_1"></i>
                <span>首页</span></a></li>
            <li><a href="tel:08162841888" id="mobile">
                <i class="vf_2"></i>
                <span>客服</span></a></li>
            <li><a href="/index.php/Home/Goods/showspfl">
                <i class="vf_3"></i>
                <span>分类</span></a></li>
            <li>
                <a href="/index.php/Home/Basket">
                    <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style="right:9px;"><span id="basketqtycount"></span> </em>
                    <i class="vf_4"></i>
                    <span>购物车</span>
                </a></li>
            <li><a href="/index.php/Home/Cust">
                <i class="vf_5"></i>
                <span>我的</span></a></li>
        </ul>
    </div>
</div>
<script>
    $(function () {
        getbasketqtycount();
        getservicetel();
    });

    function getbasketqtycount() {
        var url = "/index.php/Home/Index/getbasketcount";
        $.get(url, {}, function (req) {
            $("#basketqtycount").html(req);
        });
    }

    function getservicetel() {
        var url = "/index.php/Home/Index/getcustneiqin";
        $.get(url, {}, function (req) {
            var result = eval('(' + req + ')');
            $("#mobile").attr("href", "tel:" + result.mobile);
            $("#mobile").attr("title", "客户:" + result.name);
        });
    }

</script>
    <script>
        function goTop() {
            $('html,body').animate({'scrollTop': 0}, 600);
        }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>
</div>

</body>
</html>