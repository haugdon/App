<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>选单详细-雪宝集团</title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">

    <script type="text/javascript" src="/Public/assets/js/num-alignment.js"></script>

    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
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
            <div class="h-mid">计算结果</div>
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
        <li><a href="/index.php/Home/Shy/showxuandan"><span class="menu2"></span><i>周转箱</i></a></li>
        <li style=" border:0;"><a href="/index.php/Home/Shy"><span class="menu4"></span><i>我的</i></a></li>
    </ul>
</div>
<div id="tbh5v0">
    <div class="order">
        <div class="ord_list1">
            <div class="good_list">
                <!-- CSS goes in the document HEAD or added to your external stylesheet -->
                <form name="resultform" action="/index.php/Home/Shy/saveorder" method="post" onsubmit="return sumbit_sure()">
                    <!-- Table goes in the document BODY -->
                    <table class="gridtable">
                        <tr>
                            <th width="30%">品名</th>
                            <th width="15%">单价</th>
                            <th width="10%">数量</th>
                            <th width="20%">金额</th>
                            <th>属性</th>
                        </tr>
                    </table>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><table class="gridtable">
                            <tr>
                                <input type="hidden" name="boxid[]" value="<?php echo ($vo["fboxid"]); ?>"/>
                                <input type="hidden" name="boxmaterialid[]" value="<?php echo ($vo["fboxmaterialid"]); ?>"/>

                                <td width="30%"><?php echo ($vo["fname"]); ?>(<?php echo ($vo["fspecification"]); ?>)</td>
                                <input type="hidden" name="price[]" value="<?php echo ($vo["price"]); ?>"/>
                                <td width="15%"><?php echo (number_format($vo["price"], 2, '.', '')); ?></td>
                                <?php if($vo["de"] == '定额内'): ?><!--<td width="5%"><input name="useqty[]" type="text" value="<?php echo ($vo["useqty"]); ?>" size="6"/></td>-->
                                    <td width="10%"><input style="width:120px;" name="useqty[]" id="<?php echo ($vo["fboxid"]); ?>1" data-step="1" data-min="0" data-max="50000000" data-digit="0" value="<?php echo ($vo["useqty"]); ?>" size="6"/></td><!--readonly="readonly"-->
                                    <?php else: ?>
                                    <td width="10%"><input style="width:120px;" name="useqty[]" id="<?php echo ($vo["fboxid"]); ?>2" data-step="1" data-min="0" data-max="50000000" data-digit="0" value="<?php echo ($vo["useqty"]); ?>" size="6"/></td><?php endif; ?>
                                <td width="20%"><?php echo (number_format($vo["amount"], 2, '.', '')); ?></td>
                                <td><?php echo ($vo["de"]); ?></td>
                            </tr>
                        </table><?php endforeach; endif; else: echo "" ;endif; ?>
                    <div style="margin:0 auto; text-align:center;">
                        <input type="hidden" value="<?php echo ($checkedentry); ?>" name="checkedentry">
                        <input class="shy_button" type="submit" value="提交生成瓶箱订单">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script language="javascript">
        function sumbit_sure() {
            var gnl = confirm("确定要提交?");
            if (gnl == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script>
        function goTop() {
            $('html,body').animate({'scrollTop': 0}, 600);
        }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>

</div>
<script>
    // 自定义类型：参数为数组，可多条数据
    alignmentFns.createType([{"test": {"step": 10, "min": 10, "max": 999, "digit": 0}}]);
    // 初始化
    alignmentFns.initialize();
    // 销毁
    alignmentFns.destroy();
    // js动态改变数据
    $("#4").attr("data-max", "12")
    // 初始化
    alignmentFns.initialize();
</script>
</body>
</html>