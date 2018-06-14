<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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
    <link href='/Public/assets/css/tabulous.css' rel='stylesheet' type='text/css'>
    <script src="/Public/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/tabulous.js"></script>
    <script type="text/javascript">

        function showCheckoutOther(obj) {
            var otherParent = obj.parentNode;
            otherParent.className = (otherParent.className == 'checkout_other') ? 'checkout_other2' : 'checkout_other';
            var spanzi = obj.getElementsByTagName('span')[0];
            spanzi.className = spanzi.className == 'right_arrow_flow' ? 'right_arrow_flow2' : 'right_arrow_flow';

        }


    </script>
</head>
<body>


<div id="tbh5v0">
    <div class="user_com">
        <div class="com_top">
            <i>送货员</i>
            <dl>
                <dt></dt>
                <dd><span><?php echo (session('users')); ?></span></dd>
            </dl>
        </div>
        <div id="wrapper">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1" title="">可抢订单</a></li>
                    <li><a href="#tabs-2" title="">待送订单</a></li>
                    <li><a href="#tabs-3" title="">已完成订单</a></li>
                </ul>
                <div id="tabs_container">
                    <div id="tabs-1">
                        <dd><span
                                style=" float:left;display:inline-block; margin-top:5px; padding-left:2px; padding-right:2px;height:22px; font-size:12px; line-height:22px; color:#666; text-align:center;border-radius:2px; border:1px solid #ccc;"><a
                                onclick="fullqiandan()">一键抢单</a></span>
                            <br>
                        </dd>
                        <?php if(is_array($qdorderlist)): $i = 0; $__LIST__ = $qdorderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdvo): $mod = ($i % 2 );++$i;?><p style="font-size:14px;">客户：<?php echo ($qdvo["custname"]); ?> 日期：<?php echo ($qdvo["fdate"]); ?> </p>
                            <?php if(is_array($qdvo['childList'])): $i = 0; $__LIST__ = $qdvo['childList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdchildvo): $mod = ($i % 2 );++$i;?><p>
                                <dl>
                                    <dd style="font-size:12px;"><span style="float:right;"><?php echo ($qdchildvo["fqty"]); ?></span><strong><?php echo ($qdchildvo["fshowname"]); ?></strong></dd>
                                </dl>
                                </p><?php endforeach; endif; else: echo "" ;endif; ?>
                            <dd style="font-size:12px; height:32px;"><span
                                    style=" float:right;display:inline-block; margin-top:5px; padding-left:2px; padding-right:2px;height:22px; font-size:12px; line-height:22px; color:#666; text-align:center;border-radius:2px; border:1px solid #ccc;"><a
                                    href="" onclick="javascript:void(qiangdan('<?php echo ($qdvo["fid"]); ?>'));">立即抢单</a></span>
                                <?php if($qdchildvo['fcustupfile'] != ''): ?><img src="/Public/assets/images/fujian.png" width="120" height="25" align="left" style="padding-top:10px;"><?php endif; ?>
                            </dd>
                            <p style="border-bottom:2px solid #F00; width:100% !important;"></p><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>

                    <div id="tabs-2">
                        <?php if(is_array($songhuoorderlist)): $i = 0; $__LIST__ = $songhuoorderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdvo): $mod = ($i % 2 );++$i;?><p style="font-size:14px;">客户：<?php echo ($qdvo["custname"]); ?> 日期：<?php echo ($qdvo["fdate"]); ?> </p>
                            <?php if(is_array($qdvo['childList'])): $i = 0; $__LIST__ = $qdvo['childList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdchildvo): $mod = ($i % 2 );++$i;?><p>
                                <dl>
                                    <dd style="font-size:12px;"><span style="float:right;"><?php echo ($qdchildvo["fqty"]); ?></span><strong><?php echo ($qdchildvo["fshowname"]); ?></strong></dd>
                                </dl>
                                </p><?php endforeach; endif; else: echo "" ;endif; ?>
                            <dd style="font-size:12px;">
                                <?php if($qdchildvo['fcustupfile'] != ''): ?><img src="/Public/assets/images/fujian.png" width="120" height="25" align="left" style="padding-top:10px;"><?php endif; ?>
                            </dd>
                            <p style="border-bottom:2px solid #F00; width:100% !important;"></p><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>

                    <div id="tabs-3">
                        <?php if(is_array($overorderlist)): $i = 0; $__LIST__ = $overorderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdvo): $mod = ($i % 2 );++$i;?><p style="font-size:14px;">客户：<?php echo ($qdvo["custname"]); ?> 日期：<?php echo ($qdvo["fdate"]); ?> </p>
                            <?php if(is_array($qdvo['childList'])): $i = 0; $__LIST__ = $qdvo['childList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qdchildvo): $mod = ($i % 2 );++$i;?><p>
                                <dl>
                                    <dd style="font-size:12px;"><span style="float:right;"><?php echo ($qdchildvo["fqty"]); ?></span><strong><?php echo ($qdchildvo["fshowname"]); ?></strong></dd>
                                </dl>
                                </p><?php endforeach; endif; else: echo "" ;endif; ?>
                            <dd style="font-size:12px;">
                                <?php if($qdchildvo['fcustupfile'] != ''): ?><img src="/Public/assets/images/fujian.png" width="120" height="25" align="left" style="padding-top:10px;"><?php endif; ?>
                            </dd>
                            <p style="border-bottom:2px solid #F00; width:100% !important;"></p><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div><!--End tabs container-->
            </div><!--End tabs--><!--End tabs--><!--End tabs--><!--End tabs-->
        </div>

        <script type="text/javascript">
            $(document).ready(function ($) {
                $('#tabs').tabulous({effect: 'scale'});
                $('#tabs2').tabulous({effect: 'slideLeft'});
                $('#tabs3').tabulous({effect: 'scaleUp'});
                $('#tabs4').tabulous({effect: 'flip'});
            });
        </script>
        <div class="Wallet main_top">
            <a href="/index.php/Home/Shy/showxuandan"><em class="Icon1"></em>
                <dl class="border_bottm">
                    <dt>选单生成瓶箱</dt>
                    <dd>进入选单</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust"><em class="Icon5"></em>
                <dl class="border_bottm">
                    <dt>送货员下单</dt>
                    <dd>进入下单</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Shy/showdayhz"><em class="Icon2"></em>
                <dl class="border_bottm">
                    <dt>每日汇总</dt>
                    <dd>查看汇总信息</dd>
                </dl>
            </a>
            <a href="/index.php/Home/Cust/showprofile"><em class="Icon4"></em>
                <dl class="border_bottm">
                    <dt>我的信息</dt>
                    <dd>查看个人信息</dd>
                </dl>
            </a>
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

</body>
</html>

<script>
    function auditorder(fid) {
        var url = "/index.php/Home/Shy/auditorder";
        $.get(url, {"fid": fid}, function (data) {
            var result = eval('(' + data + ')');
            //alert(result.msg);
            location.reload();
        });
    }

    function qiangdan(fid) {
        var url = "/index.php/Home/Shy/qiangdan";
        $.get(url, {"fid": fid}, function (data) {
            var result = eval('(' + data + ')');
            alert(result.msg);
            location.reload();
        });
    }

    $(function () {
        var sfaudit = "<?php echo ($sfaudit); ?>";
        if (sfaudit == "否") {
            $("#dshorderlist").hide();
        }
    });

    function fullqiandan() {
        var url = "/index.php/Home/Shy/getfullqiandan";
        location.href = url;
        return false;
    }

</script>