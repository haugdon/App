<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>选单列表-雪宝集团</title>
    <meta name="Keywords" content="雪宝集团">
    <meta name="Description" content="雪宝集团">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" href="/Public/assets/css/flow.css">
    <link rel="stylesheet" href="/Public/assets/css/user.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/ecsmart.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
</head>
<body style="background:#e5e5e5;">


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

<form id="formCart" name="formCart" method="post" action="/index.php/Home/Shy/calcboxbill">
    <div class="folw_shopmain">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <ul id="more_element_1">
                    <div class="order_list">

                        <h2>
                            <input type="checkbox" name="checkbox[]" id="checkbox[]" value="<?php echo ($vo["t2_fentryid"]); ?>" autocomplete="off" checked=checked onclick="return false;" class="f_checkbox f_pub_checkbox f_pub_checkbox_1" title="1"
                                   style=" margin-top:10px;">
                            <span style="font-size:12px;">订单号：<?php echo ($vo["fbillno"]); ?> 客户：<?php echo ($vo["custname"]); ?><!-- 订单日期：<?php echo ($vo["fdate"]); ?> --></span>
                            <strong><?php echo ($vo["statusname"]); ?></strong></h2>
                        <volist name="vo['childList']" id="childvo">

                            <div class="order_list_goods">
                                <dl>
                                    <dd><strong><?php echo ($vo["fname"]); ?></strong><span style="float:right;">数量：<?php echo ($vo["fqty"]); ?>
                      
          </span></dd>
                                </dl>
                            </div>

                    </div>

                </ul>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>

        <div class="flow_activity">


        </div>
    </div>
    <div style=" height:50px"></div>
    <div class="flow_bottom">
        <div class="shopmain_title">
            <dl>
                <input type="checkbox" autocomplete="off" checked=checked onclick="return false;" class="f_checkbox f_pub_checkbox" title="1" onclick="return chkAll_onclick() style=" margin-top:10px; margin-left:10px;">
                <input type="submit" class="shopmain_zzxblack" value="生成周转箱" style=" color:#fff;">  </input>
            </dl>
        </div>
        <script>
            function goTop() {
                $('html,body').animate({'scrollTop': 0}, 600);
            }
        </script>
        <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>

    </div>
</form>
</body>
</html>
<script>
    function buildboxbill() {

    }
</script>