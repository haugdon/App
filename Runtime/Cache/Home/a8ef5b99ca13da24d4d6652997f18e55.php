<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="XBSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>购物车-雪宝集团</title>
    <meta name="Keywords" content="雪宝集团">
    <meta name="Description" content="雪宝集团">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/Public/assets/css/public.css">
    <link rel="stylesheet" href="/Public/assets/css/flow.css">
    <link rel="stylesheet" href="/Public/assets/css/style_jm.css">
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/ecsmart.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>


    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
    <script type="text/javascript" src="/Public/assets/js/shopping_flow.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/pingfen/jquery.raty.js"></script>
</head>
<body style="background:#e5e5e5;">

<div id="popup_window" style="background:#EFEFF4;box-shadow: 0 0 10px #ccc;border: 1px solid #ccc;border-radius: 6px;width:85%;height:auto;margin-left:-43%;margin-top:-20%;left:50%;top:50%;position:fixed;display:none;z-index:9999;">
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
        <div class="h-mid"> 确认收货</div>
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

<form id="formCart" name="formCart" method="post" action="flow.php">
    <div class="folw_shopmain">

        <div class="item-list">

            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <div class="inner">
                        <input type="checkbox" autocomplete="off" name="sel_cartgoods[]" value="<?php echo ($vo["fentryid"]); ?>"
                               id="sel_cartgoods_<?php echo ($vo["fentryid"]); ?>" checked=checked
                               class="f_checkbox check-wrapper check-wrapper-1" style="display:none">
                        <input type="hidden" name="billfid" id="billfid" value="<?php echo ($vo["fid"]); ?>"/>
                        <div class="item_img"><a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fid"]); ?>"> <img src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>"></a></div>

                        <div class="goods_desc_ edit_info_1">
                            <dl>
                                <dt><?php echo ($vo["fshowname"]); ?></dt>
                            </dl>
                            <div class="price"><span>￥<?php echo ($vo["ftaxprice"]); ?></span></div>
                        </div>
                        <div class="goods_number_">
                            <div class="qiehuan">
                                <div class="xm-input-number">
                                    <a href="javascript:;" onclick="minus_num(<?php echo ($vo["fid"]); ?>, 225, 0,0);" id="jiannum<?php echo ($vo["fid"]); ?>" class="input-sub "></a>
                                    <input type="text" onKeyDown='if(event.keyCode == 13) event.returnValue = false' name="goods_number[]" id="goods_number_<?php echo ($vo["fentryid"]); ?>" value="<?php echo ($vo["fqty"]); ?>" class="input-num"/>
                                    <input type="hidden" id="hidden_<?php echo ($vo["fid"]); ?>" value="1">
                                    <a href="javascript:;" onclick='javascript:add_num(<?php echo ($vo["fid"]); ?>, 225, 0,0)' class="input-add"></a></div>
                                <select name="sh_memo[]" id="sh_memo_<?php echo ($vo["fentryid"]); ?>" class="xm-input-bz">
                                    <option value="">备注选择</option>
                                    <option value="数量不一致">数量不一致</option>
                                    <option value="破损">破损</option>
                                    <option value="其它">其它</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div style="background:#FFF; height:2px;">


                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <div class="flow_activity">


        </div>
    </div>

    <div class="flow_bottom">
        <input name="step" value="update_cart" type="hidden">
        <div class="quanxuan">
            <div class="check-wrapper" style="display:none"><span class="cart-checkbox1 checked" onclick="return chkAll_onclick()"></span> <span class="cart-checktext">全选</span></div>
        </div>
        <div style="width:40%; text-align:center;"><span class="hot" id="cart_amount_desc" style="display: none;"><em>总计：</em><span id="amountsum"></span></span>
            <span style="float:left; padding-left:15px;">评分:</span>
            <div id="star" data-number="5"></div>
        </div>
        <div style="width:60%; text-align:right;">
            <input href="javascript:void();" onclick="return selcart_submit();" class="xm-button " value="确认收货" type="button">
        </div>
    </div>


    <script type="text/javascript" charset="utf-8">
        $(".inner .cart-checkbox").click(function () {
            if ($(this).hasClass('checked')) {
                $(this).removeClass('checked');
                $(this).find('input').attr('checked', false);
            }
            else {
                $(this).addClass('checked');
                $(this).find('input').attr('checked', true);
            }


            if ($(".inner .cart-checkbox") == true) {
                $('.quanxuan .cart-checkbox').addClass('checked');
            }
            else {
                $('.quanxuan .cart-checkbox').removeClass('checked');
            }

            var is_checked = true;
            $('.inner .cart-checkbox').each(function () {
                if (!$(this).hasClass('checked')) {
                    is_checked = false;
                    return false;
                }
            });
            if (is_checked) {
                $('.quanxuan .cart-checkbox').addClass('checked');
            } else {
                $('.quanxuan .cart-checkbox').removeClass('checked');
            }
            select_cart_goods();

        });


        function chkAll_onclick() {
            var is_checked = false;
            if ($('.quanxuan .cart-checkbox').hasClass('checked')) {
                $('.quanxuan .cart-checkbox').removeClass('checked');
                $('.inner .cart-checkbox').removeClass('checked');
                is_checked = false;
            }
            else {
                $('.quanxuan .cart-checkbox').addClass('checked');
                $('.inner .cart-checkbox').addClass('checked');
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
            });
            // Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changeNumResponse, 'GET', 'JSON');
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
            });
            // Ajax.call('flow.php', 'step=update_group_cart&sel_goods='+ sel_goods +'&rec_id=' + rec_id +'&number=' + number+'&goods_id=' + goods_id + '&suppid=' + supp_id + '&is_package=' + is_package, changeNumResponse, 'GET', 'JSON');
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
        var curstar = 0;
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
            showamountsum();
            //Ajax.call('flow.php', 'act=selcart&sel_goods=' + sel_goods, selcartResponse, 'GET', 'JSON');
        }

        function selcartResponse(res) {
            if (res.result == '请选择要确认收货的商品！') {
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
            var sel_goods = new Array();
            var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
            var j = 0;
            for (i = 0; i < obj_cartgoods.length; i++) {
                if (obj_cartgoods[i].checked == true) {
                    sel_goods[j] = obj_cartgoods[i].value;
                    j++;
                }
            }
            if (j > 0) {
                curstar = $("#star").raty('score');
                document.formCart.action = "/index.php/Home/Cust/saveshouhuo?sel_goods=" + sel_goods + "&curstar=" + curstar;
                document.formCart.elements['step'].value = 'checkout';
                document.formCart.submit();
                return true;
            }
            else {
                alert('请选择要确认收货的商品！');
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


    <script type="text/javascript">

        function showCheckoutOther(obj) {
            var otherParent = obj.parentNode;
            otherParent.className = (otherParent.className == 'checkout_other') ? 'checkout_other2' : 'checkout_other';
            var spanzi = obj.getElementsByTagName('span')[0];
            spanzi.className = spanzi.className == 'right_arrow_flow' ? 'right_arrow_flow2' : 'right_arrow_flow';

        }

    </script>


    <script type="text/javascript" src="/Public/assets/js/order_pickpoint.js"></script>

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

            $('#star').raty({
                score: 5,
                number: function () {
                    return $(this).attr('data-number');
                }
            });


            showamountsum();
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
        });
    </script>

    </em></em></form>
</body>
</html>

<script>
    function delBasket(publishid) {

        var url = "/index.php/Home/Basket/delbasket";
        $.get(url, {"publishid": publishid},
            function (req) {
                var result = eval('(' + req + ')');
                location.reload();
            });
    }

    /**
     * 金额合计 显示
     */
    function showamountsum() {
        var sel_goods = new Array();
        var obj_cartgoods = document.getElementsByName("sel_cartgoods[]");
        var j = 0;
        for (i = 0; i < obj_cartgoods.length; i++) {
            if (obj_cartgoods[i].checked == true) {
                sel_goods[j] = obj_cartgoods[i].value;
                j++;
            }
        }
        var url = "/index.php/Home/Basket/getbasketamountsum";
        $.get(url, {"sel_goods": sel_goods}, function (req) {
            var result = eval('(' + req + ')');
            $("#amountsum").html(result.amountsum);
        });
    }
</script>