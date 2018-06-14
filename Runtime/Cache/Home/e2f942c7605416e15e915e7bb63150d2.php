<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>订单详细-雪宝集团</title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
</head>
<body>
<div style="margin:0 auto; width:98%;">

    <div class="flowpay">

        <dl>
            <dd style="text-align:center;"><img src="/Public/assets/images/success.jpg" width="260" height="107">


            </dd>
            <br>
            <dd>
                订单号:<?php echo ($order_billno); ?>
                <?php echo ($api_msg); ?>
            </dd>
            <dd>
                交易时间:<?php echo ($zftime); ?>
            </dd>
            <dd>
                支付金额:<?php echo ($total_fee); ?> 元
            </dd>
            <br>

        </dl>
    </div>

    <div class="zfbtn"><input type="button" value="查看订单" onclick="location='/index.php/Home/Cust/showorderdetail?billid=<?php echo ($billid); ?>'" class="zf_btn"/></div>

</div>
</body>
</html>