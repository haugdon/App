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
                    <li>每日汇总</li>
                    <span style="float:right; padding-right:20px;"<span id=localtime></span></span>
                    <script type="text/javascript">
                        function showLocale(objD) {
                            var str, colorhead, colorfoot;
                            var yy = objD.getYear();
                            if (yy < 1900) yy = yy + 1900;
                            var MM = objD.getMonth() + 1;
                            if (MM < 10) MM = '0' + MM;
                            var dd = objD.getDate();
                            if (dd < 10) dd = '0' + dd;
                            var hh = objD.getHours();
                            if (hh < 10) hh = '0' + hh;
                            var mm = objD.getMinutes();
                            if (mm < 10) mm = '0' + mm;
                            var ss = objD.getSeconds();
                            if (ss < 10) ss = '0' + ss;
                            var ww = objD.getDay();
                            if (ww == 0) colorhead = "<font color=\"#FF0000\">";
                            if (ww > 0 && ww < 6) colorhead = "<font color=\"#373737\">";
                            if (ww == 6) colorhead = "<font color=\"#008000\">";
                            if (ww == 0) ww = "星期日";
                            if (ww == 1) ww = "星期一";
                            if (ww == 2) ww = "星期二";
                            if (ww == 3) ww = "星期三";
                            if (ww == 4) ww = "星期四";
                            if (ww == 5) ww = "星期五";
                            if (ww == 6) ww = "星期六";
                            colorfoot = "</font>"
                            str = colorhead + yy + "-" + MM + "-" + dd + "  " + colorfoot;
                            return (str);
                        }

                        function tick() {
                            var today;
                            today = new Date();
                            document.getElementById("localtime").innerHTML = showLocale(today);
                            window.setTimeout("tick()", 1000);
                        }

                        tick();
                    </script>
                </ul>

                <div id="tabs_container" style="width:100%;">

                    <?php if(is_array($hzlist)): $i = 0; $__LIST__ = $hzlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
                            <dd style="font-size:12px;padding:0 10px;"><?php echo ($vo["fname"]); ?><span style="float:right;"><strong><?php echo ($vo["qty"]); ?></strong><strong><?php echo ($vo["unitname"]); ?></strong></span></dd>
                        </dl>
                        </p>

                        <p style="border-bottom:2px solid #F00; width:100% !important;"></p><?php endforeach; endif; else: echo "" ;endif; ?>
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