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

    <title>农行代扣结算</title>
    <script src="/Public/jqueryeasyui/jquery.js" type="text/javascript"></script>

    <link rel="stylesheet" href="/Public/assets/css/public.css">
</head>
<body>
<div class="header_" style=" position:relative">
    <div class="h-left_"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
    <div class="h-mid_"> 农行代扣</div>
</div>

<div class="flowpay">
    <dl>
        <dd style="text-align:center;">
            <img src="/Public/assets/images/abclogo.jpg" width="260" height="107"></dd>
        <dd style="color:#F00; font-weight:bold;">
            请在付款账号里选择账号，再确认支付，如付款账号里没有可选账号，请咨询雪宝集团。
        </dd>
        <dd>
            支付金额：<?php echo ($total_fee); ?>
        </dd>
        <dd>
            付款账号：<select id="fkzh" style="font-size:16px;">
            <?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["fbankcode"]); ?>"><?php echo ($vo["fbankcode"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </dd>
        <dd>
            <?php echo ($to); ?>
        </dd>
        <br>

    </dl>
</div>
<div class="zfbtn">
    <input type="button" value="确认支付" onclick="goabcpay()" class="zf_btn" id="button1"/>
</div>
</body>
</html>
<script>
    function goabcpay() {
        document.getElementById("button1").disabled = true;
        $("#button1").css("background-color", "#666666");
        $("#button1").val("正在发送支付请求，请等侯！不要重复点击");
        var fkaccount = $("#fkzh").val();
        var order_id = "<?php echo ($order_id); ?>";
        var order_billno = "<?php echo ($order_billno); ?>";
        var total_fee = "<?php echo ($total_fee); ?>";
        var fkaccname = "";

        //首先进行账户名称检测
        $.get("/index.php/Home/Abcpay/abcpay", {"fkaccount": fkaccount, "order_id": order_id, "order_billno": order_billno, "total_fee": total_fee}, function (data) {
            var r = eval('(' + data + ')');
            if (r.jyjg != "") {
                alert(r.jyjg + ":" + r.msg);
            } else {
                fkaccname = r.fkaccname;
                gopay(fkaccount, order_id, order_billno, total_fee, fkaccname);
            }
        });
    }

    function gopay(fkaccount, order_id, order_billno, total_fee, fkaccname) {
        var url = "http://weixin.xuebaoruye.com:1001/Home/Abc/aa";
        $.get("/index.php/Home/Abc/abcpay_", {"fkaccount": fkaccount, "order_id": order_id, "order_billno": order_billno, "total_fee": total_fee, "fkaccname": fkaccname}, function (data) {
            var result = eval('(' + data + ')');
            if (result.jyjg == "支付成功") {
                alert(result.jyjg);
                location.href = "/index.php/Home/Cust/showorderdetail?billid=<?php echo ($order_id); ?>"; //跳转到支付成功页面 ————打开订单详细
            } else {
                $("#button1").css("background-color", "#666666");
                $("#button1").val(result.msg + ",请返回或刷新页面重试，或联系管理员！");
                alert(result.jyjg + ';' + result.msg);
                // document.getElementById("button1").disabled = false;
            }
        });
    }
</script>