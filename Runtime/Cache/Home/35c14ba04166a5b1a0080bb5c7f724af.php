<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta name="Generator" content="ECSHOP v2.7.3"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>订单列表-雪宝集团</title>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css"/>
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery-latest.js"></script>
    <script src="/Public/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
</head>
<body class="body_bj">
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">我的订单</div>
            <div class="h-right">
                <aside class="top_bar">
                    <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a></div>
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

    <ul class="order_listtop">
        <?php if(is_array($orderlistcount)): $i = 0; $__LIST__ = $orderlistcount;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$listcount): $mod = ($i % 2 );++$i;?><!--li><a href="/index.php/Home/Cust/showorderlist?status=0"  class="on" id="a_full">全部(<?php echo ($listcount["fullqty"]); ?>)</a></li-->
            <li><a href="/index.php/Home/Cust/showorderlist?status=dfk" id="a_dfk" class="on">待付款(<span id="dfkordercount"><?php echo ($listcount["dfk"]); ?></span>)</a></li>
            <li><a href="/index.php/Home/Cust/showorderlist?status=dfh" id="a_dfh"> 待发货(<?php echo ($listcount["dfh"]); ?>)</a></li>
            <li><a href="/index.php/Home/Cust/showorderlist?status=dsh" id="a_dsh"> 待收货(<?php echo ($listcount["dsh"]); ?>)</a></li>
            <li><a href="/index.php/Home/Cust/showorderlist?status=ywc" id="a_ywc"> 已完成(<?php echo ($listcount["ywc"]); ?>)</a></li><?php endforeach; endif; else: echo "" ;endif; ?>


    </ul>
    <script language="javascript">
        $(function () {
            //  $("#cancel_a").hide();
            //$(".order_listtop li a").removeClass('on');

            if (getUrlParam('status') == "0") {
                $("#a_full").addClass('on');
            }
            if (getUrlParam('status') == "dfk" || getUrlParam('status') == "") {
                $("#a_dfk").addClass('on');

            }
            if (getUrlParam('status') == "dfh") {
                $("#a_dfk").removeClass('on');
                $("#a_dfh").addClass('on');
            }
            if (getUrlParam('status') == "dsh") {
                $("#a_dfk").removeClass('on');
                $("#a_dsh").addClass('on');
            }
            if (getUrlParam('status') == "ywc") {
                $("#a_dfk").removeClass('on');
                $("#a_ywc").addClass('on');
            }
        });


    </script>

    <div class="order_tishi" id="order_tishi">只显示最近一个月的记录,如需更多,请联系客服。</div>

    <div id="J_ItemList" class="order">
        <?php if(is_array($orderlist)): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <ul id="more_element_1" class="single_item info">
                    <div class="order_list">

                        <h2>
                            <span style="font-size:14px;">订单号：<a href="/index.php/Home/Cust/showorderdetail?billid=<?php echo ($vo["fid"]); ?>"><?php echo ($vo["fbillno"]); ?>(<?php echo ($vo["fdate"]); ?>)</a> </span>
                            <strong style="padding-right:10px;"><?php echo ($vo["statusname"]); ?></strong></h2>
                        <?php if(is_array($vo['childList'])): $i = 0; $__LIST__ = $vo['childList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$childvo): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($childvo["fmaterialid"]); ?>&publishid=<?php echo ($childvo["publishid"]); ?> ">
                                <div class="order_list_goods">
                                    <dl>
                                        <dt><img src=http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($childvo["imgpath"]); ?>></dt>
                                        <dd class="name"><strong><?php echo ($childvo["fshowname"]); ?></strong><span>
                      
          </span></dd>
                                        <dd class="pice">￥<?php echo (number_format($childvo["ftaxprice"], 2, '.', '')); ?><em>x<?php echo ($childvo["fqty"]); ?></em></dd>
                                    </dl>
                                </div>
                            </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        <div class="pic">共<?php echo ($vo["fqtysum"]); ?>件商品&nbsp;&nbsp;金额合计：<strong><span id="amountsum"><?php echo ($vo["fbilltaxamount"]); ?></span></span></strong></div>
                        <div class="anniu" style="width:95%;">
                            <a href="javascript:;" onclick="copybillbuy('<?php echo ($vo["fid"]); ?>')"> 复制订单 </a>
                            <?php if($vo["statusname"] == '待付款'): ?><a href="javascript:;" onclick="cancelorder('<?php echo ($vo["fid"]); ?>')">取消订单</a><?php endif; ?>
                            <?php if($vo["statusname"] == '待收货'): ?><a href="#" onclick="javascript:void(confirm_shouhuo('<?php echo ($vo["fid"]); ?>'))">确认收货</a><?php endif; ?>
                        </div>
                    </div>
                </ul>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        <div style="display: block;" class="more_loader_spinner"></div>
    </div>
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
    $(function () {
        //var dfkordercount=$("#dfkordercount").text();
        //$("#order_tishi").hide();
    });

    function cancelorder(fid) {
        if (confirm("您确认要取消该订单吗？取消后此订单将视为无效订单")) {
            var url = "/index.php/Home/Cust/cancelorder";
            $.get(url, {"fid": fid},
                function (req) {
                    var result = eval('(' + req + ')');
                    alert(result.msg);
                    location.reload();
                });
        }
    }

    function confirm_shouhuo(fid) {
        location.href = "/index.php/Home/Cust/shouhuo?fid=" + fid;
    }

    function copybillbuy(fid) {
        var url = "/index.php/Home/Cust/copybillbuy?fid=" + fid;
        $.get(url, {"fid": fid},
            function (req) {
                var result = eval('(' + req + ')');
                if (result.msg) {
                    setTimeout(function () {
                        location.href = "/index.php/Home/Checkout?zj=1&sel_goods=" + result.msg;  // 定位到结算页面
                    }, 1000);


                }
            });
    }

</script>

<script>
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]);
        return null; //返回参数值
    }

</script>