<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="XBSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <?php if(is_array($goodsdetaillist)): $i = 0; $__LIST__ = $goodsdetaillist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><title><?php echo ($vo["fshowname"]); ?>-雪宝集团</title>
        <meta name="Keywords" content="<?php echo ($vo["fshowname"]); ?>-雪宝集团">
        <meta name="Description" content="<?php echo ($vo["fshowname"]); ?>-雪宝集团"><?php endforeach; endif; else: echo "" ;endif; ?>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/goods.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/TouchSlide.js"></script>
    <script type="text/javascript" src="/Public/assets/js/touchslider.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
</head>
<body style="cursor: auto;">
<script language="javascript">
    <!--
    /*屏蔽所有的js错误*/
    function killerrors() {
        return true;
    }

    window.onerror = killerrors;

    //-->
    function tiaozhuan() {
//var thisurl = window.location.href;
        document.getElementById("share_form").submit();
    }
</script>
<script type="text/javascript">
    /*第一种形式 第二种形式 更换显示样式*/
    function setGoodsTab(name, cursel, n) {
        $('html,body').animate({'scrollTop': 0}, 600);
        for (i = 1; i <= n; i++) {
            var menu = document.getElementById(name + i);
            var con = document.getElementById("user_" + name + "_" + i);
            menu.className = i == cursel ? "on" : "";
            con.style.display = i == cursel ? "block" : "none";
        }
    }
</script>
<div class="goods_header">
    <h2><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></h2>
    <ul>
        <li>商品详情</li>
        <li><a href="javascript:;" class="tab_head" id="goods_ka2" onclick="setGoodsTab('goods_ka',2,3), show_goods_desc()"></a></li>
        <li><a href="javascript:;" class="tab_head" id="goods_ka3" onclick="setGoodsTab('goods_ka',3,3)"></a></li>

    </ul>
    <dl>
        <dd class="top_bar">
            <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a></div>
        </dd>
        <dt><a href="/index.php/home/Basket" class="show_cart"><em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO"> <span id="basketqtycount"></span> </em></a></dt>
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

<form action="javascript:addToCart(231)" method="post" id="purchase_form" name="ECS_FORMBUY">
    <input id="chat_goods_id" value="231" type="hidden">
    <input id="chat_supp_id" value="0" type="hidden">
    <div class="main body_bj" id="user_goods_ka_1" style="display:block;">

        <div class="banner">
            <div id="slider" class="slider" style="overflow: hidden; visibility: visible; list-style: outside none none; position: relative;">
                <!--<ul id="sliderlist" class="sliderlist" style="position: relative; overflow: hidden; transition: left 0ms ease 0s; height: 400px;data-height="320";">-->
                <ul id="sliderlist" class="sliderlist" style="position: relative; overflow: hidden; transition: left 0ms ease 0s; height: 400px;"><!--modify by kevin holden-->
                    <li style="float: left; display: block;">
                    <span>
                        <a href="javacript:void%280%29">
                            <img title="" src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?> " width="100%">
                        </a>
                    </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="s_bottom"></div>
        <script type="text/javascript">$(function () {
            $("div.module_special .wrap .major ul.list li:last-child").addClass("remove_bottom_line");
        });
        var active = 0,
            as = document.getElementById('pagenavi').getElementsByTagName('a');

        for (var i = 0; i < as.length; i++) {
            (function () {
                var j = i;
                as[i].onclick = function () {
                    t2.slide(j);
                    return false;
                }
            })();
        }
        var t2 = new TouchSlider({
            id: 'sliderlist', speed: 600, timeout: 6000, before: function (index) {
                as[active].className = '';
                active = index;
                as[active].className = 'active';
            }
        });
        </script>
        <div class="product_info">

            <div class="info_dottm">
                <h3><em><?php echo ($vo["fshowname"]); ?></em></h3>

            </div>

            <dl class="goods_price">


                <dt><span id="ECS_GOODS_AMOUNT">￥<?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></span></dt>


                </dd>
            </dl>
            <ul class="price_dottm">
                <!-- <li style=" text-align:left">折扣：8.4折</li> -->
                <li></li>
            </ul>
        </div>


        <div class="goods_hd">
            <dl>
                <dt>商品信息</dt>
            </dl>
        </div>
        <div class="goods_xx">
            <dl>
                <dt><?php echo ($vo["fdetaildesc"]); ?></dt>
            </dl>
        </div>

        <div class="goods_can">
            <dl>
                <dt onclick="choose_attrone(0)">产品参数</dt>
            </dl>
        </div>


    </div>
    <div class="main" id="user_goods_ka_2" style="display:none">
        <div class="product_main" style=" margin-top:40px;">
            <div class="product_images product_desc" id="product_desc"></div>
        </div>
    </div>
    <div class="tab_attrs tab_item hide" id="user_goods_ka_3" style="display:none;">
        <script type="text/javascript" src="js/utils.js"></script>
        <div id="ECS_COMMENT">
            <link href="/Public/assets/js/photoswipe.css" rel="stylesheet" type="text/css">
            <script src="/Public/assets/js/klass.js"></script>
            <script src="/Public/assets/js/photoswipe.js"></script>


            <script language="javascript">

                function ShowMyComments(goods_id, type, page) {
                    Ajax.call('goods_comment.php?act=list_json', 'goods_id=' + goods_id + '&type=' + type + '&page=' + page, ShowMyCommentsResponse, 'GET', 'JSON');
                }

                function ShowMyCommentsResponse(result) {
                    if (result.error) {

                    }

                    try {
                        var layer = document.getElementById("ECS_MYCOMMENTS");
                        layer.innerHTML = result.content;
                        var myPhotoSwipe = $("#gallery a").photoSwipe({
                            enableMouseWheel: false,
                            enableKeyboard: false,
                            allowUserZoom: false,
                            loop: false
                        });
                    }
                    catch (ex) {
                    }
                }

            </script>
        </div>
        <script language="javascript"> ShowMyComments(231, 0, 1);</script>
    </div>


    <section class="f_mask3" style="display: none;"></section>

    <script>
        function choose_attrstr(num) {
            $("#choose_attr3").animate({height: '80%'}, [10000]);
            var total = 0, h = $(window).height(),
                top = $('.subNavBox').height() || 0,
                con = $('.subNavBox ul');
            total = 0.8 * h;
            con.height(total - top + 'px');
            $(".f_mask3").show();
        }

        function close_choose_attr3() {
            $(".f_mask3").hide();
            $('#choose_attr3').animate({height: '0'}, [10000]);
        }
    </script>
    <section class="f_mask1" style="display: none;"></section>
    <section class="f_block1" id="choose_attr1" style="height:0; overflow:hidden;">
        <section class="good_canshu">
            <h2>商品信息</h2>
            <ul>

                <li><p>商品名称：</p><span><?php echo ($vo["fshowname"]); ?></span></li>
                <li><p>商品条码：</p><span><?php echo ($vo["fbarcode"]); ?></span></li>
                <li><p>商品规格：</p><span><?php echo ($vo["fspecification"]); ?></span></li>
                <li><p>保质期：</p><span><?php echo ($vo["fexpperiod"]); ?>天</span></li>
                <?php if($vo['fnetweight'] > 0 ): ?><li><p>商品重量：</p><span><?php echo ($vo["fnetweight"]); ?>克</span></li><?php endif; ?>
                <li>
                    <p>商品库存：</p><span> <?php if($vo['kcqty'] > 0 ): ?>有货<?php else: ?>无货<?php endif; ?> </span></li>
            </ul>
        </section>
        <div class="goods_shut">
            <a href="javascript:void(0)" onclick="close_choose_attr1();" class="shut" style=" color:#FFF;font-size:18px;">关闭</a>
        </div>
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
    <section class="f_mask" style="display: none;"></section>
    <section class="f_block" id="choose_attr" style="height:0; overflow:hidden;">
        <div class="f_title_attr">
            <img id="ECS_GOODS_ATTR_THUMB" src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?> " style=" float:left;">
            <div class="f_title_arr_r">
                <?php if($vo['fprice2'] != $vo['fstdprice']): ?><span><input name="isydj" id="isydj" type="checkbox" value="" onClick="show()"/><label for="">&nbsp;&nbsp;是否预订奶</label> </label> </span><?php endif; ?>
                <div id="one" style="display:none;"><span>预订价：<i id="ECS_GOODS_AMOUNT_CHOOSE">￥<?php echo (number_format($vo["fprice2"], 2, '.', '')); ?></i>

</span></div>
                <input type="hidden" name="ydprice" id="ydprice" value="<?php echo ($vo["fprice2"]); ?>"/>
                <script type="text/javascript">

                    function show() {
                        var oCheck = document.getElementById("isydj");
                        var oOne = document.getElementById("one");
                        if (oCheck.checked) {
                            oOne.style.display = "block"
                        } else {
                            oOne.style.display = "none"
                        }
                    }
                </script>
                <span>价格：<i id="ECS_GOODS_AMOUNT_CHOOSE">￥<?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></i></span>
                <span>库存：<i id="ECS_GOODS_NUMBER"><?php if($vo['kcqty'] > 0 ): ?>有货<?php else: ?>无货<?php endif; ?></i></span>
                <?php if($vo['fminqty'] > 0 ): ?><span>最小订货量：<i id="ECS_GOODS_NUMBER"><?php echo ($vo["fminqty"]); ?></i>件   </span><?php endif; ?>
                <?php if($vo['forderqty'] > 0 ): ?><span>批量增量：<i id="ECS_GOODS_NUMBER"><?php echo ($vo["forderqty"]); ?></i>件   </span><?php endif; ?>
                <!-- <?php if($vo['fmaxqty'] > 0 ): ?><span>最大订货量：<i id="ECS_GOODS_NUMBER"><?php echo ($vo["fmaxqty"]); ?></i>件   </span><?php endif; ?> -->
                <span id="ECS_GOODS_ATTR"></span>
            </div>
            <a class="c_close_attr" href="javascript:void(0)" onclick="close_choose_attr();"></a>
            <div style="height:0px; line-height:0px; clear:both;"></div>
        </div>
        <div class="f_content_attr">
            <ul class="navContent" style="display:block;">

                <li style=" border-bottom:1px solid #eeeeee">
                    <div class="title1">购买数量</div>
                    <div class="item1">
                        <script language="javascript" type="text/javascript">  function goods_cut() {
                            var num_val = document.getElementById('number');
                            var new_num = num_val.value;
                            var Num = parseInt(new_num);
                            if (Num > 1) Num = Num - 1;
                            num_val.value = Num;
                        }

                        function goods_add() {
                            var num_val = document.getElementById('number');
                            var new_num = num_val.value;
                            var Num = parseInt(new_num);
                            Num = Num + 1;
                            num_val.value = Num;
                        } </script>
                        <span class="ui-number">
          <button type="button" class="decrease" onclick="goods_cut();changePrice();"></button>
          <input class="num" id="number" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                 onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" name="number" value="1" min="1" style=" text-align:center" type="number">
          <button type="button" class="increase" onclick="goods_add();changePrice();"></button>
          </span>
                    </div>

                </li>
            </ul>
        </div>
        <div class="f_foot">
            <input class="add_gift_attr" type="button" value="提交" border="0" onclick="addBasket()">
            <div style=" height:30px"></div>
        </div>
    </section>
    <script>
        var curnum = 0;

        function choose_attr(num) {
            document.body.style.overflow = 'hidden';
            $("#choose_attr").animate({height: '80%'}, [10000]);
            var total = 0, h = $(window).height(),
                top = $('.f_title_attr').height() || 0,
                bottom = $('#choose_attr .f_foot').height() || 0,
                con = $('.f_content_attr');
            total = 0.8 * h;
            con.height(total - top - bottom + 'px');
            $(".f_mask").show();
            curnum = num;
            if (num == 0) {
                var actionForm = document.getElementById('purchase_form');
                actionForm.action = "javascript:addToCart(231),close_choose_attr()";
            }
            if (num == 1) {
                var actionForm = document.getElementById('purchase_form');
                actionForm.action = "javascript:addToCart(231,0,1),close_choose_attr()";
            }
        }

        function close_choose_attr() {
            document.body.style.overflow = '';
            $(".f_mask").hide();
            $('#choose_attr').animate({height: '0'}, [10000]);
        }
    </script>
    <section class="f_mask6" style="display: none;"></section>
    <section class="f_block6" id="choose_attr6" style="height:0; overflow:hidden;">

        <div class="goods_shut">
            <a href="javascript:void(0)" onclick="close_choose_attr6();" class="shut" style=" color:#FFF;font-size:18px;">关闭</a>
        </div>
    </section>
    <script>
        function choose_attr6(num) {
            $("#choose_attr6").animate({height: '80%'}, [10000]);
            var total = 0, h = $(window).height(),
                top = $('.callme').height() || 0,
                con = $('.tell_me_con');
            total = 0.8 * h;
            con.height(total - top + 'px');
            $(".f_mask6").show();
        }

        function close_choose_attr6() {
            $(".f_mask6").hide();
            $('#choose_attr6').animate({height: '0'}, [10000]);
        }

        function guanzhu(sid) {
            Ajax.call('supplier.php', 'go=other&act=add_guanzhu&suppId=' + sid, selcartResponse, 'GET', 'JSON');
        }

        function selcartResponse(result) {

            alert(result.info);
        }
    </script>
</form>
<div style=" height:55px"></div>
<div class="footer_nav">
    <ul>
        <li class="bian"><a href="/"><em class="goods_nav1"></em><span>首页</span></a></li>
        <li class="bian"><a href="tel:08162841888"><em class="goods_nav2"></em><span>客服</span></a></li>
        <li><a href="javascript:void(addFavorite())" id="favorite_add"><em class="goods_nav3" id="favem"></em><span>收藏</span></a></li>
    </ul>
    <dl>
        <dd style="display: block;" class="flow" id="ECS_ADD_TO_CART"><a class="button active_button" onclick="choose_attr(0)">加入购物车</a></dd>
        <dd style="display: block;" class="goumai" id="ECS_ONE_STEP_BUY"><a style="display:block;" onclick="choose_attr(1)">立即购买</a></dd>
    </dl>
</div>

</body>
</html>
<script>
    $(function () {
        getbasketqtycount();
        //判断是否收藏过了
        var isfav = "<?php echo ($isfav); ?>";
        if (isfav != "0") {
            $('#favem').removeClass();
            $('#favem').addClass("goods_nav4");
        }

    });

    function addBasket() {
        var publishid = '<?php echo ($publishid); ?>';
        var qty = $("#number").val();
        var isyd = 0;
        var ydprice = 0;
        if ($('#isydj').attr('checked')) {
            isyd = 1;
            ydprice = $("#ydprice").val();
        } else {
            isyd = 0;
        }
        var url = "/index.php/Home/Goodsdetail/addBasket";
        $.get(url, {"publishid": publishid, "qty": qty, "isyd": isyd, "ydprice": ydprice},
            function (req) {
                var result = eval('(' + req + ')');
                getbasketqtycount();
                close_choose_attr();
                if (curnum == 1) {
                    location.href = "/index.php/Home/Basket?publishid=" + publishid;
                }
            });

    }

    function getbasketqtycount() {
        var url = "/index.php/Home/Index/getbasketcount";
        $.get(url, {}, function (req) {
            $("#basketqtycount").html(req);
        });
    }

    function addFavorite() {
        var publishid = "<?php echo ($publishid); ?>";
        var url = "/index.php/Home/Goodsdetail/addFavorite";
        $.get(url, {"publishid": publishid},
            function (req) {
                var result = eval('(' + req + ')');
                alert(result.msg);
                close_choose_attr();
            });

    }
</script>