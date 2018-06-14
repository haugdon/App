<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>微信支付</title>
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
     <link rel="stylesheet" href="/Public/assets/css/public.css">
</head>

<script type="text/javascript">

    //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
       '<?php echo ($jsApiParameters); ?>',
        function(res){
            WeixinJSBridge.log(res.err_msg);
            alert(res.err_code+res.err_desc+res.err_msg);
        }
    );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
</script>
<body>
<div class="header_" style=" position:relative">
  <div class="h-left_"> <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a> </div>
  <div class="h-mid_"> 微信支付(当前为测试,请不要点) </div>
</div>
<div class="flowpay">
    <dl><dd style="text-align:center;">
            <img src="/Public/assets/images/weixinlogo.jpg" width="260" height="107"> </dd>
        <dd style="color:#F00; font-weight:bold;">
            请在付款账号里选择账号，再确认支付，如付款账号有异常，请咨询雪宝集团。
        </dd>
        <dd>
           OpenId:<?php echo ($openid); ?>
        </dd>
        <dd>
            <?php echo ($jsApiParameters); ?>
        </dd>
        <dd>
            预付ID：<?php echo ($prepay_id); ?>
        </dd>
        <dd>
            支付金额：<?php echo ($total_fee); ?> 元
         </dd>

    </dl>
</div>
<div class="zfbtn">
            <input type="button" value="确认支付" onclick="callpay()" class="zf_btn"/>
        </div>

</body>
</html>