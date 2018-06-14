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
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_003.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/pingfen/jquery.raty.js"></script>
</head>
<body class="body_bj">


<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">订单详情</div>
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
        <li><a href="/"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="/index.php/Home/Goods/showspfl"><span class="menu2"></span><i>分类</i></a></li>
        <li><a href="/index.php/Home/Basket"><span class="menu3"></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="/index.php/Home/Cust"><span class="menu4"></span><i>我的</i></a></li>
    </ul>
</div>
<div id="tbh5v0">


    <div class="order">

        <div class="order_up">
            <div class="lan">
                <dl>
                    <dd>
                        <span style=" line-height:50px;" id="orderywc">
                            <?php echo ($api_msg); ?> <?php echo ($statusname); ?></span>

                    </dd>
                </dl>
            </div>

            <div class="order_zhifu">
                <dl>
                    <dd>
                        <span style=" margin-top:15px">订单状态：<?php echo ($statusname); ?></span>
                        <span id="ywctip">订单已完成，不能继续支付</span>
                    </dd>
                </dl>
            </div>
            <script>
            </script>

            <div class="information">
                <dl>
                    <dd>
                        <?php if(is_array($shaddrlist)): $i = 0; $__LIST__ = $shaddrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$addrvo): $mod = ($i % 2 );++$i;?><span>收货人姓名&nbsp;:&nbsp;<?php echo ($addrvo["fcontact"]); ?></span>
                            <p>
                                详细地址&nbsp;:&nbsp;<?php echo ($addrvo["faddress"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
                    </dd>
                </dl>
            </div>
            <?php if(is_array($fhlist)): $i = 0; $__LIST__ = $fhlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fhvo): $mod = ($i % 2 );++$i;?><div class="information">
                    <dl>
                        <dd>

                            <span>发货物流公司&nbsp;:&nbsp;<?php echo ($fhvo["wlgsname"]); ?></span>
                            <p>
                                车牌号&nbsp;:&nbsp;<?php echo ($fhvo["carnumber"]); ?></p>

                        </dd>

                    </dl>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="information" id="pingfendiv">
                <dl>
                    <dd>
                        <div id="star" style="width:150px !important;"></div>
                    </dd>
                </dl>
            </div>
        </div>
        <?php if(is_array($orderdetail)): $i = 0; $__LIST__ = $orderdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="ord_list1">

                <?php if(is_array($vo['childList'])): $i = 0; $__LIST__ = $vo['childList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$childvo): $mod = ($i % 2 );++$i;?><div class="good_list">

                        <a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($childvo["fmaterialid"]); ?>&publishid=<?php echo ($childvo["publishid"]); ?>">
                            <dl>
                                <dt><img src=http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($childvo["imgpath"]); ?>></dt>
                                <dd class="good_name"><strong><?php echo ($childvo["fshowname"]); ?></strong>
                                </dd>
                                <dd class="good_pice"><strong><?php echo (number_format($childvo["ftaxprice"], 2, '.', '')); ?></strong><em>x<?php echo ($childvo["fqty"]); ?></em></dd>
                            </dl>
                        </a>
                        <div class="pic"><span>小计：</span><strong><?php echo (number_format($childvo["fallamount"], 2, '.', '')); ?></strong></div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>

                <div class="jiage">
                    <ul>
                        <li>金额合计&nbsp;:&nbsp;<span style=" color:#EE0A3B; font-weight:bold"><?php echo ($vo["fbilltaxamount"]); ?></span></li>
                    </ul>
                </div>

            </div>

            <div class="navContent">
                <ul>
                    <li>订单号&nbsp;:&nbsp;<?php echo ($vo["fbillno"]); ?></li>
                    <li>订单日期&nbsp;:&nbsp;<?php echo ($vo["fdate"]); ?></li>
                    <?php if(is_array($jslist)): $i = 0; $__LIST__ = $jslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jsvo): $mod = ($i % 2 );++$i;?><li>余额抵扣：&nbsp;&nbsp;<?php echo ($jsvo["yedkfs"]); ?>
                            <?php if($jsvo['fyedkje'] > 0 ): echo ($jsvo["fyedkje"]); endif; ?>
                        </li>
                        <li>支付方式：&nbsp;&nbsp;<?php echo ($jsvo["zffs"]); ?>
                            <?php if($jsvo['fzfje'] > 0 ): echo ($jsvo["fzfje"]); endif; ?>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <span id="billno" style="display: none"><?php echo ($vo["fbillno"]); ?></span>
            <span id="billfid" style="display: none"><?php echo ($vo["fid"]); ?></span>
            <span id="zffs" style="display: none"><?php echo ($jsvo["fzffs"]); ?></span>
            <span id="zfje" style="display: none"><?php echo ($jsvo["fzfje"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
        <div style=" height:60px;"></div>
        <div class="detail_dowm" id="ywclabel">
            <ul>
                <li>
                    <a>已完成</a></li>
            </ul>
        </div>
    </div>

    <script>
        function goTop() {
            $('html,body').animate({'scrollTop': 0}, 600);
        }
    </script>
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>

    <section class="f_mask" style="display: none;"></section>
    <section class="f_block" id="choose_attr" style="height:145px; overflow:hidden;display: none;">
        <div class="zhifu_up">
            <h3><span>选择支付方式</span><a class="c_close_attr" href="javascript:void(0)" onclick="close_choose_attr();" style="display:none">关闭</a></h3>

            <form name="payment" id="payment" method="post" action="" onsubmit="return payment_validate()">
                <ul>
                    <li id="radio_nhdk">
                        <input name="pay_code" onchange="choose_payment(this.value)" class="f_checkbox_t" value="1" type="radio">农行代扣
                    </li>
                    <li id="radio_wxzf">
                        <input name="pay_code" onchange="choose_payment(this.value)" class="f_checkbox_t" value="2" type="radio">微信支付
                    </li>
                    <input name="act" value="act_edit_payment" type="hidden">
                    <input name="order_id" value="183" type="hidden">
                    <input name="is_pay" value="1" type="hidden">
                </ul>

                <em><input value="确定" class="input" type="button" onclick="javascript:void(gojsapi());"></em>
            </form>
        </div>
    </section>
    <script>
        $(function () {
            var nhdkshow = "<?php echo ($nhdkshow); ?>";
            var wxzfshow = "<?php echo ($wxzfshow); ?>";
            if (nhdkshow != "True") {
                $("#radio_nhdk").hide();
            }
            if (wxzfshow != "True") {
                $("#radio_wxzf").hide();
            }
        });

        function gojsapi() {
            // alert("农行代扣、微信支付暂未开通，请线下联系支付！");
            // return false;

            var zffs = jQuery('input[type="radio"][name="pay_code"]:checked').val();

            var zfje = $("#zfje").html();
            var billno = $("#billno").html();
            var billfid = $("#billfid").html();

            if (zffs == 1) {
                var url = "/index.php/Home/Abcpay/index/" + "?order_billno=" + billno + "&order_id=" + billfid + "&total_fee=" + zfje;
            }
            if (zffs == 2) {
                var url = "/index.php/Home/Weixinpay/" + "?order_billno=" + billno + "&order_id=" + billfid + "&total_fee=" + zfje;
            }
            location.href = url;
        }

        $(function () {
            $('#star').raty({readOnly: true, score: "<?php echo ($star); ?>"});
            var zffs = $("#zffs").html();
            if (zffs == 2) {
                $("input[name='pay_code'][value='2']").attr("checked", true);
            } else {
                $("input[name='pay_code'][value='1").attr("checked", true);
            }
            var statusname = '<?php echo ($statusname); ?>';
            $("#pingfendiv").hide();
            if (statusname == "待付款") {
                $("#choose_attr").show();
                $("#orderywc").hide();
                $("#ywclabel").hide();
                $("#ywctip").hide();

            } else {
                $("#orderywc").show();
                $("#ywclabel").show();
                $("#ywctip").show();
            }
            if (statusname == "已完成" || statusname == "") {
                $("#pingfendiv").show();
            }
            $("#ywclabel").hide();
        });

        function choose_attr() {
            $("#choose_attr").animate({height: '80%'}, [10000]);
            var total = 0, h = $(window).height(),
                top = $('.f_title_attr').height() || 0,
                con = $('.f_content_attr');
            total = 0.8 * h;
            con.height(total - top + 'px');
            $(".f_mask").show();
        }

        function close_choose_attr() {
            $(".f_mask").hide();
            $('#choose_attr').animate({height: '0'}, [10000]);
        }

        function choose_payment(pay_id) {
            if (pay_id == 'alipay_bank') {
                document.getElementById('payment_subbox').style.display = 'block';
            }
            else {
                document.getElementById('payment_subbox').style.display = 'none';
            }
        }

        function payment_validate() {
            var arr = document.getElementsByName("pay_code");
            var do_pay = false;
            for (var i = 0; i < arr.length; i++) {
                if (arr[i].checked) {
                    do_pay = true;
                }
            }
            if (do_pay) {
                return true;
            } else {
                alert("请选择一个支付方式");
                return false;
            }
        }
    </script>


    <section class="f_mask1" style="display: none;"></section>
    <section class="f_block1" id="choose_attr1" style="height:0; overflow:hidden;">
        <section class="good_canshu">
            <div style=" height:50px"></div>

        </section>
    </section>
    <script>
        function choose_attrone(num) {
            $("#choose_attr1").animate({height: '80%'}, [10000]);
            var total = 0, h = $(window).height(),
                top = $('.good_canshu').height() || 0,
                con = $('.xiangq');
            total = 0.8 * h;
            con.height(total - top + 'px');
            $(".f_mask1").show();
        }

        function close_choose_attr1() {
            $(".f_mask1").hide();
            $('#choose_attr1').animate({height: '0'}, [10000]);
        }

    </script>
</div>

<script language="javascript">
    $(function () {
        $('input[type=text],input[type=password]').bind({
            focus: function () {
                $(".global-nav").css("display", 'none');
            },
            blur: function () {
                $(".global-nav").css("display", 'flex');
            }
        });
    })
</script>

</body>
</html>