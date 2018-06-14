<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="Generator" content="ECSHOP v2.7.3">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>订单详细-雪宝集团</title>
<meta name="Keywords" content="">
<meta name="Description" content="">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
  <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
  <script>
    function onBridgeReady(){
      var zfje="<?php echo ($total_fee); ?>";
	  var billid="<?php echo ($billid); ?>";
	  var billno="<?php echo ($order_billno); ?>";
      WeixinJSBridge.invoke(
              'getBrandWCPayRequest',
      <?php echo $jsApiParameters; ?>,
      function(res){
        if(res.err_msg == "get_brand_wcpay_request:ok" ) {
          //alert("支付成功!");
		 location.href="/index.php/Home/Weixinpay/payok?billid="+billid+"&billno="+billno+"&zfje="+zfje;
         
        }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
      }
    );
    }
    function callpay()
    {
      if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
          document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }else if (document.attachEvent){
          document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
          document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
      }else{
        onBridgeReady();
      }
    }
  </script>
</head>
<body>
<div style="margin:0 auto; width:98%;">

<div class="flowpay">

    <dl><dd style="text-align:center;">
      <img src="/Public/assets/images/weixinlogo.jpg" width="260" height="107"> </dd>
        <br>
        <dd>
            订单号:<?php echo ($order_billno); ?>
        </dd>
        <dd>
         支付金额:<?php echo ($total_fee); ?> 元
        </dd>
        <br>

    </dl>
</div>
<div class="zfbtn">
  <input type="button" value="确认支付" onclick="callpay()" class="zf_btn"/>
</div>
</div>
</body>
</html>