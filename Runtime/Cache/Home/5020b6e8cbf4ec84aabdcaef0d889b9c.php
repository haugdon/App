<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0047)http://127.0.0.1:8080/mobile/flow.php?step=done -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">

    <meta name="viewport" content="width=device-width">
    <title>结算-雪宝集团 </title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" href="/Public/assets/css/flow.css">
    <link rel="stylesheet" href="/Public/assets/css/style_jm.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/ecsmart.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
</head>
<body style="background:#e5e5e5;">

<div id="popup_window" style="background:#EFEFF4;box-shadow: 0 0 10px #ccc;border: 1px solid #ccc;border-radius: 6px;width:85%;height:auto;margin-left:-43%;margin-top:-20%;left:50%;top:50%;position:fixed;display:none;z-index:9999;">

    <input id="surplus_password_input" type="password" style="float:left;margin:10px 3%;width:91%;background-color:white;height:30px;border: 1px solid #ccc;padding-left: 6px;">
    <span class="flow_tank">
  <input class="yezf_QRB tankuang" type="button" onclick="end_input_surplus()" value="确定">
</span>
    <span class="flow_tank">
  <input class="yezf_QXB tankuang" type="button" onclick="cancel_input_surplus()" value="取消">
  </span>
</div>


<div class="tab_nav">
    <div class="header" style=" position:relative">
        <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
        <div class="h-mid"> 提交订单</div>
    </div>
    <dl>
        <dd class="top_bar" style=" position:absolute; top:0; right:2%; z-index:999999">
            <div onclick="show_menu();$(&#39;#close_btn&#39;).addClass(&#39;hid&#39;);" id="show_more"><a href="javascript:;"></a></div>
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


<div class="screen-wrap fullscreen login" style=" background:#FFF">
    <div class="sys_message">
        <!--<p class="title">确认并付款！</p>-->
        <?php if(is_array($jslist)): $i = 0; $__LIST__ = $jslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsvo): $mod = ($i % 2 );++$i; if($jsvo['fzfje'] > 0 ): ?><p class="title">确认并付款！</p>
                <p class="title">请点击下方【立即支付】进行付款。</p>
                <?php else: ?>
                <p class="title">订单已成功提交！<?php echo ($api_msg); ?></p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <ul class="content_success">
        <li></li>
        <li style=" border-top:1px solid #eeeeee">
            <span>订单号：<em><?php echo ($billno); ?></em></span>
            <span>订单合计：<em><?php echo ($amount); ?></em></span>
            <?php if(is_array($jslist)): $i = 0; $__LIST__ = $jslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsvo): $mod = ($i % 2 );++$i;?><span>抵扣方式：<?php echo ($jsvo["yedkfs"]); ?> <?php if($jsvo['fyedkje'] > 0 ): echo ($jsvo["fyedkje"]); endif; ?></span>
                <?php if($jsvo['yedkfs'] == '预存款' ): ?><span>预存款余额：<em style="color:red;font-weight: bold;"><?php echo ($yckye); ?></em></span><?php endif; ?>

                <p style="float:left;">支付方式：
                    <?php if($jsvo['fzfje'] > 0 ): ?><p id="zffs" style="float:left;"><?php echo ($jsvo["zffs"]); ?></p>
                <p id="zfje" style="float:left;"><?php echo ($jsvo["fzfje"]); ?></p><?php endif; ?> </p>

                <span>配送时间：<em style=" color:#E71F19"><?php echo ($fhrq); ?></em></span>
        </li>
    </ul>
    <?php if($jsvo['fzfje'] > 0 ): ?><div class="pay-btn"><a href="#" class="sub_btn" style="color:#FFF;" onclick="gojsapi()">立即支付</a></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    <div class="welcome_dom">
        <!--<span><a href="../">返回首页</a></span><span><a href="/index.php/Home/Cust/showorderdetail?billid=<?php echo ($FID); ?>">查看订单</a></span>-->
        <?php if(is_array($jslist)): $i = 0; $__LIST__ = $jslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsvo): $mod = ($i % 2 );++$i; if($jsvo['fzfje'] > 0 ): ?><span></span>
                <?php else: ?>
                <span><a href="../">返回首页</a></span><span><a href="/index.php/Home/Cust/showorderdetail?billid=<?php echo ($FID); ?>">查看订单</a></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
</body>
</html>
<script>
    function gojsapi() {
        // alert("农行代扣、微信支付暂未开通，请线下联系支付！");
        // return false;

        var zffs = $("#zffs").html();
        var zfje = $("#zfje").html();
        var billno = "<?php echo ($billno); ?>";
        var billfid = "<?php echo ($billfid); ?>";

        if (zffs == "农行代扣") {
            var url = "/index.php/Home/Abcpay/index/" + "?order_billno=" + billno + "&order_id=" + billfid + "&total_fee=" + zfje;
        }
        if (zffs == "微信支付") {
            var url = "/index.php/Home/Weixinpay/" + "?order_billno=" + billno + "&order_id=" + billfid + "&total_fee=" + zfje;
        }
        location.href = url;

        /* $.get(url,{},function(data){
            var result=eval('('+data+')');
              if(result.error_msg)
              {
                  alert(result.error_msg);
              }else{

              }

          });
          location.href="/index.php/Home/Weixinpay/showweixinzf";*/
    }

    function gopay() {
        var zffs = $("#zffs").html();
        var zfje = $("#zfje").html();

        var billno = "<?php echo ($billno); ?>";
        var billfid = "<?php echo ($billfid); ?>";
        if (zffs == "0") {
            alert("无需支付");
            return false;
        }
        var url = "";
        if (zffs == "农行代扣") {
            url = "nonghang";
        }
        if (zffs == "微信支付") {
            var url = "/index.php/Home/Weixinpay/test/" + "?order_billno=" + billno + "&order_id=" + billfid + "&total_fee=" + zfje;
        }
        //  alert(url);
        //  location.href=url+"?order_billno="+billno+"&order_id="+billfid+"&total_fee="+zfje;
        $.ajax({
            //要用post方式
            type: "post",
            //方法所在页面和方法名
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //返回的数据用data.d获取内容
                alert(data.error_msg);
            },
            error: function (err) {
                alert(err);
            }
        });
        //  $.get(url,{"order_billno":billno,"order_id":billfid,"total_fee":zfje},function(data){
        //   var result=eval('('+data+')');
        //   alert(result.error_msg);
        // });

    }
</script>