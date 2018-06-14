<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>购物车 - 雪宝集团</title><!--首页的购物车不是这个页面-->
    <meta name="Keywords" content="雪宝集团">
    <meta name="Description" content="雪宝集团">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" href="/Public/assets/css/flow.css">
    <link rel="stylesheet" href="/Public/assets/css/style_jm.css">
    <link rel="stylesheet" href="/Public/assets/css/datedropper.css">
    <link rel="stylesheet" href="/Public/assets/css/timedropper.min.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.form.js"></script>

    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
    <script type="text/javascript" src="/Public/assets/js/datedropper.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/timedropper.min.js"></script>
</head>
<body style="background: rgb(229, 229, 229) none repeat scroll 0% 0%; cursor: auto;">
<style type="text/css">
    .input {
        padding: 6px;
        border: 1px solid #d3d3d3
    }
</style>
<div id="popup_window" style="background:#EFEFF4;box-shadow: 0 0 10px #ccc;border: 1px solid #ccc;border-radius: 6px;width:85%;height:auto;margin-left:-43%;margin-top:-20%;left:50%;top:50%;position:fixed;display:none;z-index:9999;">
    <label class="yezf_tit" style="float:left;margin:15px;width: 91%;text-align: center;"><span>请输入余额支付密码</span> </label>
    <input id="surplus_password_input" style="float:left;margin:10px 3%;width:91%;background-color:white;height:30px;border: 1px solid #ccc;padding-left: 6px;" type="password">
    <span class="flow_tank">
  <input class="yezf_QRB tankuang" onclick="end_input_surplus()" value="确定" type="button">
</span>
    <span class="flow_tank">
  <input class="yezf_QXB tankuang" onclick="cancel_input_surplus()" value="取消" type="button">
  </span>
</div>
<div class="tab_nav">
    <div class="header" style=" position:relative">
        <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
        <div class="h-mid"> 确认订单</div>
    </div>
    <dl>
        <dd class="top_bar" style=" position:absolute; top:0; right:2%; z-index:999999">
            <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a></div>
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
<script type="text/javascript">
    function closeCustomer() {
        $("#choose").hide();
    }

    function choose_gift(suppid) {
        var sel_goods = new Array();
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            //if(obj_cartgoods[i].checked == true)
            {
                sel_goods[j] = obj_cartgoods[i].value;
                j++;
            }
        }
        Ajax.call('flow.php', 'is_ajax=1&suppid=' + suppid + '&sel_goods=' + sel_goods, selgiftResponse, 'GET', 'JSON');
    }

    function selgiftResponse(res) {
        $('#choose').html(res.result);
        $("#choose").animate({height: '80%'}, [10000]);
        var total = 0, h = $(window).height(),
            top = $('.f_title').height() || 0,
            con = $('.f_content');
        total = 0.8 * h;
        con.height(total - top + 'px');
        $(".f_mask").show();
    }

    function close_choose() {
        $(".f_mask").hide();
        $('#choose').animate({height: '0'}, [10000]);
    }

    function choose_attr(rec_id) {
        Ajax.call('flow.php?is_ajax=1&step=show_choose_attr', 'rec_id=' + rec_id, show_choose_attr, 'GET', 'JSON');
    }

    function show_choose_attr(result) {
        $("#choose_attr").animate({height: '80%'}, [10000]);
        $("#choose_attr").html(result);
        var total = 0, h = $(window).height(),
            top = $('.f_title_attr').height() || 0,
            con = $('.f_content_attr');
        total = 0.8 * h;
        con.height(total - top + 'px');
        $(".f_mask").show();
        changePrice();
    }

    function close_choose_attr() {
        $(".f_mask").hide();
        $('#choose_attr').animate({height: '0'}, [10000]);
    }

    function changeAtt(t) {
        t.lastChild.checked = 'checked';
        for (var i = 0; i < t.parentNode.childNodes.length; i++) {
            if (t.parentNode.childNodes[i].className == 'hover') {
                t.parentNode.childNodes[i].className = '';
                t.childNodes[0].checked = "checked";
            }
        }
        t.className = "hover";
        changePrice();
    }

    /**
     * 点选可选属性或改变数量时修改商品价格的函数
     */
    function changePrice() {
        var goodsId = document.getElementById('goods_id').value;
        var attr = getSelectedAttributes(document.forms['formCart']);
        var qty = document.getElementById('cart_goods_number').value;
        Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
    }

    /**
     * 接收返回的信息
     */
    function changePriceResponse(res) {
        if (res.err_msg.length > 0) {
            alert(res.err_msg);
        }
        else {
            if (document.getElementById('ECS_GOODS_AMOUNT')) {
                document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
            }
            if (document.getElementById('ECS_GOODS_NUMBER')) {
                document.getElementById('ECS_GOODS_NUMBER').innerHTML = res.goods_attr_number;
            }
            if (document.getElementById('ECS_GOODS_AMOUNT_JF')) {
                document.getElementById('ECS_GOODS_AMOUNT_JF').innerHTML = res.result_jf;
            }
            if (document.getElementById('ECS_GOODS_AMOUNT_CHOOSE')) {
                document.getElementById('ECS_GOODS_AMOUNT_CHOOSE').innerHTML = res.result;
            }
            if (document.getElementById('ECS_GOODS_ATTR_THUMB')) {
                document.getElementById('ECS_GOODS_ATTR_THUMB').src = res.goods_attr_thumb;
            }
            if (document.getElementById('ECS_GOODS_ATTR')) {
                document.getElementById('ECS_GOODS_ATTR').innerHTML = res.goods_attr;
            }
        }
    }
</script>
<script type="text/javascript" charset="utf-8">
    function editCartGoods(rec_id) {
        var goodsId = document.getElementById('goods_id').value;
        var attr = getSelectedAttributes(document.forms['formCart']);
        var qty = document.getElementById('cart_goods_number').value;
        Ajax.call('flow.php?is_ajax=1&step=edit_cart_goods', 'rec_id=' + rec_id + '&goods_id=' + goodsId + '&attr=' + attr + '&number=' + qty, editCartGoodsResponse, 'GET', 'JSON');
    }

    function editCartGoodsResponse(result) {
        if (result.err != 0) {
            alert(result.err);
        } else {
            window.location.href = "flow.php?step=cart";
        }
    }
</script>
<script type="text/javascript" charset="utf-8">
    $(".inner .f_checkbox").click(function () {
        pub = $(this).attr("title");
        if ($(this).attr("checked") == "checked") {
            var is_checked_2 = true;
            $('.check-wrapper-' + pub).each(function () {
                if ($(this).attr("checked") != "checked") {
                    is_checked_2 = false;
                    return false;
                }
            });
            if (is_checked_2) {
                $('.f_pub_checkbox_' + pub).attr("checked", 'checked');
            } else {
                $('.f_pub_checkbox_' + pub).removeAttr("checked", 'checked');
            }
        }
        else {
            $('.f_pub_checkbox_' + pub).removeAttr("checked");
        }
        var is_checked = true;
        $('.f_checkbox').each(function () {
            if ($(this).attr("checked") != "checked") {
                is_checked = false;
                return false;
            }
        });
        if (is_checked) {
            $('.quanxuan .cart-checkbox1').addClass('checked');
        } else {
            $('.quanxuan .cart-checkbox1').removeClass('checked');
        }
        select_cart_goods();
    });
    $(".f_pub_checkbox").click(function () {
        pub = $(this).attr("title");
        var is_checked = false;
        if ($(this).attr("checked") == 'checked') {
            $(this).attr("checked", "checked");
            $(this).parent().parent().parent().find('.check-wrapper-' + pub).attr('checked', 'checked');
            is_checked = true;
        }
        else {
            $(this).parent().parent().parent().find('.check-wrapper-' + pub).removeAttr("checked");
            is_checked = false;
        }
        $('.f_checkbox').each(function () {
            if ($(this).attr("checked") != "checked") {
                is_checked = false;
                return false;
            }
        });
        if (is_checked) {
            $('.quanxuan .cart-checkbox1').addClass('checked');
        } else {
            $('.quanxuan .cart-checkbox1').removeClass('checked');
        }
        select_cart_goods();
    })

    function chkAll_onclick() {
        var is_checked = false;
        if ($('.quanxuan .cart-checkbox1').hasClass('checked')) {
            $('.quanxuan .cart-checkbox1').removeClass('checked');
            $('.inner .f_checkbox').removeAttr("checked");
            is_checked = false;
        }
        else {
            $('.quanxuan .cart-checkbox1').addClass('checked');
            $('.inner .f_checkbox').attr("checked", "checked");
            is_checked = true;
        }
        for (var i = 0; i < document.formCart.elements.length; i++) {
            var e = document.formCart.elements[i];
            e.checked = is_checked;
        }
        select_cart_goods();
    }

    function select_cart_goods() {
        var sel_goods = new Array();
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            if (obj_cartgoods[i].checked == true) {
                sel_goods[j] = obj_cartgoods[i].value;
                j++;
            }
        }
        Ajax.call('flow.php', 'act=selcart&sel_goods=' + sel_goods, selcartResponse, 'GET', 'JSON');
    }

    function selcartResponse(res) {
        if (res.result == '请选择要结算的商品！') {
            $('.xm-button').addClass('to_cart');
            $('.xm-button').attr('disable');
        }
        else {
            $('.xm-button').removeClass('to_cart');
            $('.xm-button').removeAttr('disable');
        }
        if (res.err_msg.length > 0) {
            alert(res.err_msg);
        }
        else {

            document.getElementById('cart_amount_desc').innerHTML = res.result;
        }
    }

    function selcart_submit() {
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            if (obj_cartgoods[i].checked == true) {
                j++;
            }
        }
        if (j > 0) {
            document.formCart.action = 'flow.php?step=checkout';
            document.formCart.elements['step'].value = 'checkout';
            document.formCart.submit();
            return true;
        }
        else {
            alert('请选择要结算的商品！');
            return false;
        }
    }
</script>
<script>
    $('.edit_btn').bind('click', function () {
        if ($(this).html() == "编辑") {
            num = $(this).attr("name");
            $(".edit_box_" + num).show();
            $(".edit_info_" + num).hide();
            $(this).html("完成");
        }
        else {
            num = $(this).attr("name");
            $(".edit_box_" + num).hide();
            $(".edit_info_" + num).show();
            $(this).html("编辑");
        }
    });
</script>
<form name="theForm" id="theForm" enctype="multipart/form-data" method="post">
    <div class="order-buy">
        <div class="order_goblack"><a href="/index.php/home/Basket"><span>返回购物车</span><em>修改购物车信息</em></a></div>
        <section class="order_info">
            <div class="item-list">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <div class="inner">
                            <input type="hidden" name="sel_cartgoods[]" value="<?php echo ($vo["fid"]); ?>"
                                   id="sel_cartgoods_<?php echo ($vo["fid"]); ?>">
                            <div class="item_img_"><a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fid"]); ?>"> <img src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>"></a></div>
                            <div class="goods_desc edit_info_1">
                                <dl>
                                    <dt><?php echo ($vo["fshowname"]); ?></dt>
                                </dl>
                                <div class="price"><span>￥<?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></span>
                                    <em>统一零售价:￥<?php echo (number_format($vo["tylsj"], 2, '.', '')); ?></em>
                                </div>
                            </div>
                            <div class="goods_number">
                                <div class="qiehuan">
                                    <div class="xm-input-number">
                                        <?php if($vo["fstdprice"] == '0'): ?><a href="javascript:;" id="jiannum<?php echo ($vo["fid"]); ?>" class="input-sub "></a>
                                            <input name="goods_number[<?php echo ($vo["fid"]); ?>]" type="text" class="input-num" id="goods_number_<?php echo ($vo["fid"]); ?>" onblur="change_price(<?php echo ($vo["fid"]); ?>, 225, 0)"
                                                   onKeyDown='if(event.keyCode == 13) event.returnValue = false' value="<?php echo ($vo["fqty"]); ?>" readonly/><input type="hidden" id="hidden_<?php echo ($vo["fid"]); ?>" value="1">
                                            <a href="javascript:;" class="input-add"></a>
                                            <?php else: ?>
                                            <a href="javascript:;" onclick="minus_num(<?php echo ($vo["fid"]); ?>, 225,0,0);" id="jiannum<?php echo ($vo["fid"]); ?>" class="input-sub "></a>
                                            <input name="goods_number[<?php echo ($vo["fid"]); ?>]" type="text" class="input-num" id="goods_number_<?php echo ($vo["fid"]); ?>" onblur="change_price(<?php echo ($vo["fid"]); ?>, 225, 0)"
                                                   onKeyDown='if(event.keyCode == 13) event.returnValue = false'
                                                   value="<?php echo ($vo["fqty"]); ?>" readonly/>
                                            <input type="hidden" id="hidden_<?php echo ($vo["fid"]); ?>" value="1">
                                            <a href="javascript:;" onclick='javascript:add_num(<?php echo ($vo["fid"]); ?>, 225, 0,0)' class="input-add"></a>
                                            </td><?php endif; ?>
                                    </div>
                                    <div class="delete">
                                        <a href="javascript:if (confirm('您确实要把该商品移出购物车吗？')) delBasket(<?php echo ($vo["fid"]); ?>);">
                                            删除
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="background:#FFF; height:2px;"></div>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div id="orderinfo_fj"></div>
        </section>
        <script type="text/javascript">
            $(function () {
                getoderinfo_fj();
            });

            function getoderinfo_fj() {
                $("#orderinfo_fj").empty();
                var sel_goods = getUrlParam('sel_goods');
                $.ajax({
                    url: "/index.php/Home/Checkout/loadorderfj",
                    cache: false,
                    data: {"sel_goods": sel_goods},
                    success: function (html) {
                        $("#orderinfo_fj").empty();
                        $("#orderinfo_fj").append(html);
                    }
                });
            }

            /* var fapiao_con = document.getElementById('ECS_INVCONTENT');
             if (fapiao_con.value=='0')
             {
               document.getElementById('ECS_INVPAYEE').disabled=true;
             }
             else
             {
               document.getElementById('ECS_INVPAYEE').disabled=false;
             }*/
        </script>
        <script>
            function add_num(rec_id, goods_id, supp_id, is_package) {
                var sel_goods = new Array();
                var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
                var j = 0;
                for (i = 0; i < obj_cartgoods.length; i++) {
                    if (obj_cartgoods[i].checked == true) {
                        sel_goods[j] = obj_cartgoods[i].value;
                        j++;
                    }
                }
                document.getElementById("goods_number_" + rec_id + "").value++;
                if (document.getElementById("goods_number_" + rec_id + "").value > 1) {
                    document.getElementById("jiannum" + rec_id).className = 'input-sub active';
                } else {
                    document.getElementById("jiannum" + rec_id).className = 'input-sub';
                }
                var number = document.getElementById("goods_number_" + rec_id + "").value;
                $.get('/index.php/Home/Basket/setbaseketqty', {"publishid": rec_id, "qty": number}, function (req) {
                    showamountsum();
                    getoderinfo_fj();
                    $("input[name='yedk']").get(3).checked = true;
                    selectPaymentye();
                });
                //   Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changeNumResponse, 'GET', 'JSON');
            }

            function minus_num(rec_id, goods_id, supp_id, is_package) {
                var sel_goods = new Array();
                var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
                var j = 0;
                for (i = 0; i < obj_cartgoods.length; i++) {
                    if (obj_cartgoods[i].checked == true) {
                        sel_goods[j] = obj_cartgoods[i].value;
                        j++;
                    }
                }
                if (document.getElementById("goods_number_" + rec_id + "").value > 1) {
                    document.getElementById("goods_number_" + rec_id + "").value--;
                    if (document.getElementById("goods_number_" + rec_id + "").value > 1) {
                        document.getElementById("jiannum" + rec_id).className = 'input-sub active';
                    } else {
                        document.getElementById("jiannum" + rec_id).className = 'input-sub';
                    }
                }
                var number = document.getElementById("goods_number_" + rec_id + "").value;
                $.get('/index.php/Home/Basket/setbaseketqty', {"publishid": rec_id, "qty": number}, function (req) {
                    showamountsum();
                    getoderinfo_fj();
                    $("input[name='yedk']").get(3).checked = true;
                    //$("input[name='yedk'][value='0']").attr("checked",true);
                    selectPaymentye();
                });
                //  Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changeNumResponse, 'GET', 'JSON');
            }

            function change_price(rec_id, goods_id) {
                var r = /^[1-9]+[0-9]*]*$/;
                var number = document.getElementById("goods_number_" + rec_id + "").value;
                if (!r.test(number)) {
                    alert("您输入的格式不正确！");
                    document.getElementById("goods_number_" + rec_id + "").value = document.getElementById("hidden_" + rec_id + "").value;
                }
                else {
                    Ajax.call('flow.php', 'step=update_group_cart&rec_id=' + rec_id + '&number=' + number + '&goods_id=' + goods_id, changeNumResponse, 'GET', 'JSON');
                }
            }

            function changeNumResponse(result) {
                if (result.error == 1) {
                    alert(result.content);
                    document.getElementById("goods_number_" + result.rec_id + "").value = result.number;
                    document.getElementById("hidden_" + result.rec_id + "").value = result.number;
                }
                else if (result.error == 888) {
                    alert(result.message);
                    document.getElementById("goods_number_" + result.rec_id + "").value = result.number;
                    document.getElementById("hidden_" + result.rec_id + "").value = result.number;
                }
                else {
                    document.getElementById("hidden_" + result.rec_id + "").value = result.number;
                    document.getElementById('cart_amount_desc').innerHTML = result.cart_amount_desc;//购物车商品总价说明
                    show_div_text = "恭喜您！ 商品数量修改成功！ ";
                    document.getElementById("goods_numx_" + result.rec_id + "").innerHTML = 'x' + result.number;
                }
            }
        </script>
        <section class="main">
            <div class="checkout_other">
                <div class="content ptop0">
                    <div class="panel panel-default info-box">
                        <div class="checkout_other">
                            <h4 class="psbag" onclick="showCheckoutOther(this);" style="font-weight:bold;">收货信息<span class="right_arrow_flow"></span></h4>
                            <div class="subbox_other" id="jifen68">
                                <div class="flow_bottom_list bian">
                                    <div style=" margin-top:8px">
                                        <li style="height:40px;">
                                            <?php if(is_array($addrlist)): $i = 0; $__LIST__ = $addrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['isdef'] == 1): ?><!--<if condition="$i eq count($lists)">-->
                                                    <!--<if condition="count($vo) eq 1">--><!--modify by kevin 20170915 如果只有一个地址设为默认,但是后面直接在数据库里设置默认收货地址了,就不用改了-->
                                                    <input id="addrchk" name="addrlist" value="<?php echo ($vo["fentryid"]); ?>" checked="checked" iscod="1" class="f_checkbox_t" type="radio">
                                                    <p style="height:40px; line-height:15px;"> <?php echo ($vo["fcontact"]); ?>(<?php echo ($vo["fname"]); echo ($vo["faddress"]); ?>)</p>
                                                    <?php else: ?>
                                                    <input id="addrchk" name="addrlist" value="<?php echo ($vo["fentryid"]); ?>" iscod="1" class="f_checkbox_t" type="radio">
                                                    <p style="height:40px; line-height:15px;"> <?php echo ($vo["fcontact"]); ?>(<?php echo ($vo["fname"]); echo ($vo["faddress"]); ?>)</p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout_other">
                <div class="content ptop0">
                    <div class="panel panel-default info-box">
                        <div class="checkout_other">
                            <h4 class="fp other" onclick="showCheckoutOther(this);">基本信息<span class="right_arrow_flow"></span></h4>
                            <div class="subbox_other" id="jifen68" style=" background:#FFF;">
                                <div class="flow_bottom_list bian">
                                    <div style=" margin-top:8px">
                                        <ul>
                                            <li><p>订单编号：系统自动生成</p></li>
                                            <li><p>流程状态：未下单</p></li>
                                            <li><p>订单日期：系统自动生成</p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout_other2 padding10" id="fapiao" style="display:none;">
                            <div class="subbox_other" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="main">
            <div class="content">
                <div class="checkout_other2">
                    <h4 class="sh" onclick="showCheckoutOther(this);">送货时间<span class="right_arrow_flow"></span></h4>
                    <div class="subbox_other">
                        <div class="flow_bottom_list">
                            <div class="songh_time" id="time_id_1">
                                <p>请选择日期：<input type="text" class="input" id="pickdate" name="pickdate" value="<?php echo ($def_shtime); ?>"/></p><br/>
                                <p>请选择时间：<input type="text" class="input" id="picktime" name="picktime"/></p>
                            </div>
                            <div class="flowBox">送货时间仅作参考，我们会尽量满足您的要求</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="order-info">
            <div class="order_checked mid">
                <div class="checkout_other">
                    <h4 class="qh" onclick="showCheckoutOther(this);">优惠活动<span class="right_arrow_flow"></span></h4>

                    <div class="subbox_other" id="jifen68" style=" background:#FFF;">
                        <div class="flow_bottom_list bian">
                            <?php if(is_array($yhlist)): $i = 0; $__LIST__ = $yhlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div style=" margin-top:8px">
                                        <input name="how_oos" class="f_checkbox_t" style="float:inherit" value="0" checked="checked" id="how_oos_0" onclick="changeOOS(this)" type="radio">
                                        <label for="how_oos_0"><?php echo ($vo["fname"]); ?></label>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="order_info">
            <div class="order_list">
                <div class="checkout_other">
                    <div class="fy " href="javascript:void(0);" onclick="showCheckoutOther(this);">
                        <span class="right_arrow_flow" style=" float:right; margin-right:30px;"></span>订单备注
                    </div>
                    <div class=" subbox_other">
                        <div class="flow_bottom_list">
                            <input id="upfile" runat="server" name="upfile" type="file" accept="image/*" capture="camera" style="width:100%"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="main" style=" margin-top:8px;">
        <div class="con_ct">
            <ul class=" order_total_ul" id="ECS_ORDERTOTAL">
                <li>
                    <div class="subtotal">
                        <span class="total-text">总金额：</span>
                        <em><span id="amountsum"></span></em><br>
                        <span class="total-text">总数量：</span>
                        <em><span id="qtysum"></span></em><br>
                        <span class="total-text" style=""></span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="main" style=" margin-top:8px;">
        <div class="order_list" id="pay_div_ye">
            <div class="checkout_other" style="padding-left:10px;">
                <div class="zf1" id="zhifutitle0" href="javascript:void(0);" onclick="showCheckoutOther(this);">
                    <span class="right_arrow_flow" style="float:right;padding-right:50px;"></span>余额抵扣&nbsp;:&nbsp;
                    <em class="qxz" id="emzhifu0" style="color:#999;">请选择抵扣方式</em></div>
                <div class=" subbox_other">
                    <div class="flow_bottom_list">
                        <?php if(is_array($balancelist)): $i = 0; $__LIST__ = $balancelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$balance): $mod = ($i % 2 );++$i;?><ul class="nav nav-list-sidenav" id="zhifu68" style="display:block; border-bottom:none;">
                                <li class="clearfix" name="dikou_name" id="flyedkshow">
                                    <input id="yedk_balance" name="yedk" value="1" iscod="0" onclick="selectPaymentye(this)" class="f_checkbox_t" type="radio">
                                    <label for="payment_method_1">
                                        <div class="fl shipping_title">促销余额<span style="color:#F00" id="balanceamount"><?php echo (number_format($balance["fbalanceamount"], 2, '.', '')); ?> </span>
                                            <span style="color:#FF0000" id="cxyemess"></span>
                                        </div>
                                    </label>
                                </li>
                                <li class="clearfix" name="dikou_name" id="xyyedkshow">
                                    <input id="yedk_credit" name="yedk" value="2" iscod="0" onclick="selectPaymentye(this)" class="f_checkbox_t" display:none="" type="radio">
                                    <label for="payment_method_4">
                                        <div class="fl shipping_title"> 信用余额<span style="color:#F00" id="creditamount"><?php echo (number_format($balance["fcreditamount"], 2, '.', '')); ?> </span>
                                            <span style="color:#FF0000" id="creditmess"></span>
                                        </div>
                                    </label>
                                </li>
                                <?php if($custid == '1305055' ): endif; ?>
                                <li class="clearfix" name="dikou_name" id="yckdkshow">
                                    <input name="yedk" type="radio" class="f_checkbox_t" id="yedk_yck" onclick="selectPaymentye(this)" value="3" iscod="0" display:none="">
                                    <label for="payment_method_4">
                                        <div class="fl shipping_title"> 预存款<span style="color:#F00" id="yck"><?php echo (number_format($balance["yck"], 2, '.', '')); ?> </span>
                                            <span style="color:#FF0000" id="yckmess"></span>
                                        </div>
                                    </label>
                                </li>
                                <li class="clearfix" name="dikou_name">
                                    <input id="yedk" name="yedk" value="0" iscod="1" onclick="selectPaymentye(this)" checked class="f_checkbox_t" type="radio">
                                    <label for="payment_method_6">
                                        <div class="fl shipping_title"> 不使用抵扣</div>
                                    </label>
                                </li>
                            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main" style=" margin-top:8px;">
        <div class="order_list" id="pay_div">
            <div class="checkout_other2" style="padding-left:10px;">
                <div class="zf" id="zhifutitle" href="javascript:void(0);" onclick="showCheckoutOther(this);">
                    <span class="right_arrow_flow" style="float:right;padding-right:50px;"></span>支付方式&nbsp;:&nbsp;
                    <em class="qxz" id="emzhifu" style="color:#999;">请选择支付方式</em></div>
                <div class=" subbox_other">
                    <div class="flow_bottom_list">
                        <ul class="nav nav-list-sidenav" id="zhifu68" style="display:block; border-bottom:none;">
                            <li class="clearfix" name="payment_name" id="nhdkshow">
                                <input name="payment" type="radio" class="f_checkbox_t" id="payment_method_1" onclick="selectPayment(this)" value="1" checked iscod="0">
                                <label for="payment_method_1">
                                    <div class="fl shipping_title"> 农行代扣</div>
                                </label>
                            </li>
                            <li class="clearfix" name="payment_name" id="wxzfdkshow">
                                <input id="payment_method_2" name="payment" value="2" iscod="0" onclick="selectPayment(this)" class="f_checkbox_t" type="radio">
                                <label for="payment_method_1">
                                    <div class="fl shipping_title"> 微信支付</div>
                                </label>
                            </li>
                        </ul>
                        <li style="padding-left:15px;">应付款：<input type="text" name="yinfukuan" readonly id="yinfukuan" style="color:red;width:80px;"/>
                            <span id="zfmess" style="color:red; font-size:14px;"></span>
                            <input type="hidden" name="yedkje" id="yedkje" value="0.00"/>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main" style=" margin-top:8px;">
        <div class="panel-body2">
            <div class="title"><span class="text">支付密码&nbsp;:&nbsp;</span>
                <em class="qxz">请输入支付密码</em></div>

            <li style="padding-left:15px;"><input name="zfpassword" id="zfpassword" type="password" style=" border:1px solid #CCC; margin:10px 0; line-height:20px; padding:5px; width:92%;">
            </li>
        </div>
    </section>
    <input type="hidden" name="randid" id="randid"/>
    <div class="pay-btn">
        <input class="tijiao_butn" value="提交订单" id="btnsubmit" type="button">
        <input name="step" value="done" type="hidden">
    </div>
    <section class="f_mask" style="display: none;"></section>
    <section class="f_mask" style="display: none;"></section>
    <section class="f_block" id="pop" style="height:0; position:fixed; bottom:-5px; left:0px; width:100%; overflow:auto; z-index:999999; background:#FFF;">
        <div id="pickcontent"></div>
    </section>
    </div>
</form>
<!--<!DOCTYPE html>
<script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
<link rel="stylesheet" type="text/css" href="/Public/assets/css/goods.css">
<div class="v_nav">
    <div class="vf_nav">
        <ul>
            <li><a href="/">
                <i class="vf_1"></i>
                <span>首页</span></a></li>
            <li><a href="tel:08162841888" id="mobile">
                <i class="vf_2"></i>
                <span>客服</span></a></li>
            <li><a href="/index.php/Home/Goods/showspfl">
                <i class="vf_3"></i>
                <span>分类</span></a></li>
            <li>
                <a href="/index.php/Home/Basket">
                    <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style="right:9px;"><span id="basketqtycount"></span> </em>
                    <i class="vf_4"></i>
                    <span>购物车</span>
                </a></li>
            <li><a href="/index.php/Home/Cust">
                <i class="vf_5"></i>
                <span>我的</span></a></li>
        </ul>
    </div>
</div>
<script>
    $(function () {
        getbasketqtycount();
        getservicetel();
    });

    function getbasketqtycount() {
        var url = "/index.php/Home/Index/getbasketcount";
        $.get(url, {}, function (req) {
            $("#basketqtycount").html(req);
        });
    }

    function getservicetel() {
        var url = "/index.php/Home/Index/getcustneiqin";
        $.get(url, {}, function (req) {
            var result = eval('(' + req + ')');
            $("#mobile").attr("href", "tel:" + result.mobile);
            $("#mobile").attr("title", "客户:" + result.name);
        });
    }

</script>-->
<script type="text/javascript">

    function showCheckoutOther(obj) {
        var otherParent = obj.parentNode;
        otherParent.className = (otherParent.className == 'checkout_other') ? 'checkout_other2' : 'checkout_other';
        var spanzi = obj.getElementsByTagName('span')[0];
        spanzi.className = spanzi.className == 'right_arrow_flow' ? 'right_arrow_flow2' : 'right_arrow_flow';

    }

    function selectPaymentye() {
        $("#yinfukuan").val(""); //清空
        var yedkfs = jQuery('input[type="radio"][name="yedk"]:checked').val();
        var amountsum = parseFloat($("#amountsum").html().replace(/,/g, ""));
        $("#creditmess").html("");
        $("#zfmess").html("");
        $("#yckmess").html("");
        $("#cxyemess").html("");
        if (yedkfs == 0) {
            $("#yinfukuan").val(amountsum);
            $("#yedkje").val("0.00");
        }
        if (yedkfs == 2) {
            //信用支付
            var xyye = parseFloat($("#creditamount").html().replace(/,/g, ""));
            if (xyye < amountsum) {
                $("#yinfukuan").val(amountsum);
                $("#creditmess").html("信用额度不足！不能使用");
                $("input[name='yedk'][value='2']").attr("checked", false);
                $("input[name='yedk']").get(3).checked = true;
            } else {
                $("#yinfukuan").val("0.00");
                $("#zfmess").html("采用信用支付：" + amountsum);
                $("#yedkje").val(amountsum);
            }
        }
        if (yedkfs == 1) {
            //返利余额
            var orderamont = parseFloat("<?php echo ($orderamount); ?>");
            var rate = parseFloat("<?php echo ($rate); ?>");
            var flye = parseFloat($("#balanceamount").html().replace(/,/g, ""));
            var cxye = parseFloat($("#balanceamount").html().replace(/,/g, ""));
            if (rate != 0 && flye > 0) {
                if (amountsum >= orderamont) //满足条件时
                {

                    flye = amountsum * rate / 100.00; //计算出可以使用的返利余额
                } else {
                    flye = 0;
                }
                if (flye < amountsum) //当返利余额小于订单金额
                {
                    var yinf = amountsum - flye;
                    if (flye > cxye) //如果通过比例计算出的返利余额大于了当前剩余返利余额则只支付fl_ye
                    {
                        flye = cxye;
                        yinf = amountsum - cxye;
                    }
                    $("#yinfukuan").val(yinf.toFixed(2));
                    $("#zfmess").html("采用促销余额支付：" + flye);
                    $("#yedkje").val(flye);
                } else {
                    $("#zfmess").html("采用促销余额支付：" + amountsum);
                    $("#yedkje").val(amountsum);
                    $("#yinfukuan").val("0.00");
                }
            } else {
                $("#cxyemess").html("促销余额不足！");
                $("input[name='yedk'][value='1']").attr("checked", false);
                $("input[name='yedk']").get(3).checked = true;
                $("#yinfukuan").val(amountsum);
            }


        }
        if (yedkfs == 3) {
            //预存款
            //var yck=parseFloat($("#yck").html().replace(/,/g,""));
            //if(yck<amountsum)
            //{
            //var yinf=amountsum-yck;
            //$("#yinfukuan").val(yinf);
            //$("#yckmess").html("预存款余额不足！能使用："+yck);
            //$("#yedkje").val(yck);
            //if(yck<=0){
            //$("input[name='yedk']").get(3).checked=true;
            //yinf=amountsum;
            //$("#yinfukuan").val(yinf);
            //$("#yckmess").html("预存款余额不足！不能使用.");
            //$("#yedkje").val("0");
            //}

            //}else{
            //$("#zfmess").html("采用预存款支付："+amountsum);
            //$("#yedkje").val(amountsum);
            // $("#yinfukuan").val("0.00");
            //}
            var yck = parseFloat($("#yck").html().replace(/,/g, ""));
            if (yck < amountsum) {
                var yinf = amountsum - yck;
                $("#yinfukuan").val(yinf);
                $("#yckmess").html("预存款余额不足！能使用：" + yck);
                if (yck <= 0) {
                    //$("input[name='yedk'][value='3']").attr("checked", false); //预存款为负也可以勾选
                }
                $("#yedkje").val(yck);
            } else {
                $("#zfmess").html("采用预存款支付：" + amountsum);
                $("#yedkje").val(amountsum);
                $("#yinfukuan").val("0.00");
            }

        }

    }

</script>


<script type="text/javascript">
    function choose_gift(suppid) {
        var sel_goods = new Array();
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            //if(obj_cartgoods[i].checked == true)
            {
                sel_goods[j] = obj_cartgoods[i].value;
                j++;
            }
        }
        Ajax.call('flow.php', 'is_ajax=1&suppid=' + suppid + '&sel_goods=' + sel_goods, selgiftResponse, 'GET', 'JSON');
    }

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]);
        return null; //返回参数值
    }

    function selgiftResponse(res) {
        $('#choose').html(res.result);
        $("#choose").animate({height: '80%'}, [10000]);
        var total = 0, h = $(window).height(),
            top = $('.f_title').height() || 0,
            con = $('.f_content');
        total = 0.8 * h;
        con.height(total - top + 'px');
        $(".f_mask").show();
    }

    function close_choose() {
        $(".f_mask").hide();
        $('#choose').animate({height: '0'}, [10000]);
    }
</script>

<script>
    //点击input标签时间
    $(function () {
        $(".order_checked input").click(
            function () {
                $(this).parents(".checkout_other2").addClass("checkout_other");
                $(this).parents(".checkout_other2").removeClass("checkout_other2");
                $(this).parents(".order_checked").find(".right_arrow_flow2").addClass("right_arrow_flow");
                $(this).parents(".order_checked").find(".right_arrow_flow2").removeClass("right_arrow_flow2");
                $(this).parents(".order_checked").find("em").html($(this).next().html());
                if ($(this).attr("id") == 'definetime_input') {
                    $("#choose_time").animate({height: '80%'}, [10000]);
                    var total = 0, h = $(window).height(),
                        top = $('.f_title_time').height() || 0,
                        con = $('.f_content_time');
                    total = 0.8 * h;
                    con.height(total - top + 'px');
                    $(".f_mask").show();
                }
            })
        $("#randid").val(getUrlParam("randid"));
    });
</script>
<script>
    $("#pickdate").dateDropper({
        animate: false,
        format: 'Y-m-d',
        maxYear: '2020'
    });
    $("#picktime").timeDropper({
        meridians: false,
        format: 'HH:mm',
    });

    /**
     * 金额合计 显示
     */
    function showamountsum() {
        var sel_goods = new Array();
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            sel_goods[j] = obj_cartgoods[i].value;
            j++;
        }
        var url = "/index.php/Home/Basket/getbasketamountsum";
        $.get(url, {"sel_goods": sel_goods}, function (req) {
            var result = eval('(' + req + ')');
            $("#amountsum").html(result.amountsum);
            $("#yinfukuan").val(result.amountsum);
            $("#qtysum").html(result.qtysum);
        });
    }

    function delBasket(publishid) {

        var url = "/index.php/Home/Basket/delbasket";
        $.get(url, {"publishid": publishid},
            function (req) {
                var result = eval('(' + req + ')');
                location.reload();
            });
    }

    //将form转为AJAX提交
    function ajaxSubmit(frm, fn) {
        var dataPara = getFormJson(frm);
        $.ajax({
            url: frm.action,
            type: frm.method,
            data: dataPara,
            success: fn
        });
    }

    //将form中的值转换为键值对。
    function getFormJson(frm) {
        var o = {};
        var a = $(frm).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });

        return o;
    }


</script>

<script>
    $(function () {
        var flyeshow = "<?php echo ($flyeshow); ?>";
        var xyyeshow = "<?php echo ($xyyeshow); ?>";
        var yckshow = "<?php echo ($yckshow); ?>";
        var nhdkshow = "<?php echo ($nhdkshow); ?>";
        var wxzfshow = "<?php echo ($wxzfshow); ?>";
        var qtyhdkshow = "<?php echo ($qtyhdkshow); ?>";
        if (flyeshow != "True") {
            $("#flyedkshow").hide();
        }
        if (xyyeshow != "True") {
            $("#xyyedkshow").hide();
        }
        if (yckshow != "True") {
            $("#yckdkshow").hide();
        }
        if (nhdkshow != "True") {
            $("#nhdkshow").hide();
        }
        if (wxzfshow != "True") {
            $("#wxzfdkshow").hide();
        }
        showamountsum();
        // 为表单绑定异步上传的事件
        $("#theForm").ajaxForm({
            url: "/index.php/Home/Checkout/saveOrder",
            type: "post", // 请求方式
            dataType: "json",
            async: false, // 异步
            success: function (data) {
                //alert(data.msg);
                if (data.error) {
                    alert(decodeURI(data.error));
                    return false;
                }
                //发送消息
                $.get("/index.php/Home/Index/sendweixinmess", {"fid": data.FID, "content": "订单来了！"}, function (req) {

                });
                //订单提交成功，跳转！
                location.href = "/index.php/Home/Checkout/showpayment?FID=" + data.FID + "&FHTIME=" + data.fhrq + "&api_msg=" + data.api_msg;
            },
            error: function (err) {
                alert("提交时出错" + err);
            }
        });
        $("#btnsubmit").click(function () {
            var fhrq = $("#pickdate").val();
            if (fhrq == "") {
                alert("请选择送货日期!");
                return false;
            }

            var daydate = new Date();
            var cha = (Date.parse(fhrq) - Date.parse(daydate));
            if ($("#yinfukuan").val() == "") {
                alert("系统正在加载支付消息，请稍等重试！");
                return false;
            }
            // if (cha < 0) {
            //    alert("日期不能小于今天！");
            //   return false;
            //}
            var yck = parseFloat($("#yck").html().replace(/,/g, ""));
            if (yck < -10) {
                alert("您的预存款为负，请补交欠款。如存在负数,将无法下单!如有疑问,请联系18381699703");
            }
            var fhtime = $("#picktime").val().substring(0, 2);
            if (parseFloat(fhtime < 9)) {
                alert("温馨提示：本订单中低温产品在【本日】内出库!");
            } else {
                alert("温馨提示：本订单中低温产品在【明日】内出库!");
            }


            /**
             * 金额合计 显示
             */
            var fhrq = $("#pickdate").val();
            console.log(fhrq);
            var url = "/index.php/Home/Basket/getbeforeamountsum";
            $.get(url, {"amountsum": parseFloat($("#amountsum").html().replace(/,/g, "")), "fhrq": fhrq}, function (req) {
                var result = eval('(' + req + ')');
                console.log(result);//打印结果:Object {flag: "0", flag1: "0"}
                //console.log("result="+result);//result是一个对象,如果这样写的话是打印不出来的(因为字符串是不能与对象连接的)  //打印结果:result=[object Object]
                if (result.flag >= 1) {
                    var r = confirm("您之前已经下过一张金额相同的订单,是否继续?");
                    if (r == true) {
                        $("#theForm").submit();
                        return false;
                    } else {
                        location.reload();//刷新网页
                    }
                } else {
                    $("#theForm").submit();
                    return false;
                }
            });
        });
        window.addEventListener("beforeunload", function (e) {
            //   var confirmationMessage = '确定离开此页吗？本页不需要刷新或后退';
            //   (e || window.event).returnValue = confirmationMessage;     // Gecko and Trident
            //    return closeclear();                                // Gecko and WebKit
            //清除当前页面的未提交品种

        });
    });

    function closeclear() {
        var sel_goods = getUrlParam('sel_goods');
        var iszjbuy = getUrlParam('zj');
        var url = "/index.php/Home/Checkout/unloadclear";
        if (iszjbuy == 1) {
            $.get(url, {"sel_goods": sel_goods}, function (req) {
            });
        }
    }
</script>
</body>
</html>