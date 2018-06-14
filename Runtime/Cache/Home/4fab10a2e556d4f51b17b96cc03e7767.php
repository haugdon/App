<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>方案列表-雪宝集团</title>
    <meta name="Keywords" content="雪宝集团">
    <meta name="Description" content="雪宝集团">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" href="/Public/assets/css/flow.css">
    <link rel="stylesheet" href="/Public/assets/css/style_jm.css">
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/ecsmart.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
</head>
<body style="background: rgb(229, 229, 229) none repeat scroll 0% 0%; cursor: auto;">


<div class="tab_nav">
    <div class="header" style=" position:relative">
        <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
        <div class="h-mid"> 方案列表</div>
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
        <li><a href="/"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="/index.php/Home/Goods/showspfl"><span class="menu2"></span><i>分类</i></a></li>
        <li><a href="/index.php/Home/Basket"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="/index.php/Home/Cust"><span class="menu4"></span><i>我的</i></a></li>
    </ul>
</div>


<section class="f_mask" style="display: none;"></section>
<section class="f_block" id="choose" style="height:0px;"></section>
<section class="f_block" id="choose_attr" style="height:0; overflow:hidden;"></section>


<div class="order-buy">


    <section class="main">
        <div class="checkout_other">
            <div class="content ptop0">
                <div class="panel panel-default info-box">
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="checkout_other">
                            <h4 class="fp other" onclick="javascript:void(showdetail('<?php echo ($vo["fid"]); ?>','<?php echo ($vo["fname"]); ?>'));"><?php echo ($vo["fname"]); ?><span class="right_arrow_flow"></span></h4>
                            <div class="subbox_other" id="jifen68" style=" background:#FFF;">
                            </div>

                        </div><?php endforeach; endif; else: echo "" ;endif; ?>


                </div>
            </div>
    </section>
    <script>
        function goTop() {
            $('html,body').animate({'scrollTop': 0}, 600);
        }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>
</div>
</body>
</html>
<script>
    function showdetail(faid, famc) {
        location.href = "/index.php/Home/Cust/showfadetail?faid=" + faid + "&famc=" + famc;
    }
</script>