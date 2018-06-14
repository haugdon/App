<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta name="Generator" content="ECSHOP v2.7.3"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>交易明细列表-雪宝集团</title>
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
<style>
    body {
        font-size: 11px
    }

    table {
        /*border-collapse: collapse;*/
        margin: 0 0px 0 15px;
        width: 99%;
        cellspacing: 0;
        cellpadding: 0;
    }

    tr {
        /*border: 1px solid #ccc;*/
        padding: 0px;
        margin: 0px;
    }

    /*设置单元格中文本框的样式*/
    /*td input[type='text'] {
        border: 1px solid green;
        border-radius: 3px;
        height: 4px;
    }*/

    td > span {
        font-size: 11px;
    }
</style>
<body class="body_bj">
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">我的交易明细</div>
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
    <div class="order_tishi" id="order_tishi">只显示最近一个月的记录,如需更多,请联系客服。</div>
    <?php if(is_array($jymxlist)): $i = 0; $__LIST__ = $jymxlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="order_list">
            <table>
                <tr>
                    <td><span>日期：<?php echo ($vo["日期"]); ?></span></td>
                    <td><span>订单号：<?php echo ($vo["订单编号"]); ?></span></td>
                </tr>
                <tr>
                    <td><span>订单金额：<?php echo ($vo["订单金额"]); ?></span></td>
                    <td><span>折扣金额：<?php echo ($vo["折扣额"]); ?></span></td>
                </tr>
                <tr>
                    <td><span>收款金额：<?php echo ($vo["收款金额"]); ?></span></td>
                    <td><span>收款方式：<?php echo ($vo["收款方式"]); ?></span></td>

                </tr>
                <tr>
                    <td><span>应付金额：<?php echo ($vo["应付金额"]); ?></span></td>
                    <td><span>退款金额：<?php echo ($vo["退款金额"]); ?></span></td>
                </tr>
                <tr>
                    <td><span>退货数量：<?php echo ($vo["退货数量"]); ?></span></td>
                </tr>
            </table>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
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
                                        <dd class="name"><strong><?php echo ($childvo["fshowname"]); ?></strong><span></span></dd>
                                        <dd class="pice">￥<?php echo (number_format($childvo["ftaxprice"], 2, '.', '')); ?><em>x<?php echo ($childvo["fqty"]); ?></em></dd>
                                    </dl>
                                </div>
                            </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php if($vo["statusname"] == '付款'): ?><div class="pic">共<?php echo ($vo["fqtysum"]); ?>件商品&nbsp;&nbsp;付款：<strong><span id="amountsum"><?php echo ($vo["fbilltaxamount"]); ?></span></span></strong></div><?php endif; ?>
                        <?php if($vo["statusname"] == '退款'): ?><div class="pic">共<?php echo ($vo["fqtysum"]); ?>件商品&nbsp;&nbsp;退款：<strong><span id="amountsum"><?php echo ($vo["fbilltaxamount"]); ?></span></span></strong></div><?php endif; ?>
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
</script>