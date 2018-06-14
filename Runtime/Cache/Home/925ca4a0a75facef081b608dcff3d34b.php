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
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/category.css">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="application/javascript" src="/Public/assets/js/jquery_003.js"></script>
    <style>
        .pagelist {
            text-align: center;
            background: #f1f1f1;
            padding: 7px 0;
        }

        .pagelist a {
            margin: 0 5px;
            border: #6185a2 solid 1px;
            display: inline-block;
            padding: 2px 6px 1px;
            line-height: 16px;
            background: #fff;
            color: #6185a2;
        }

        .pagelist span {
            margin: 0 5px;
            border: #6185a2 solid 1px;
            display: inline-block;
            padding: 2px 6px 1px;
            line-height: 16px;
            color: #6185a2;
            color: #fff;
            background: #6185a2;
        }
    </style>
</head>
<body class="body_bj">
<section style="display: block;" class="_pre">
    <header id="head_search_box" style="position: fixed; top: 0px; width: 100%; z-index:9999;">
        <div class="cate_header">
            <div class="cate_left"><a href="javascript:history.back(-1)" class="sb-back" title="返回">商品列表</a></div>
            <div class="cate_mid">
                <form id="searchForm" name="searchForm" method="post">
                    <div class="text_box" name="list_search_text_box" onClick="return 1;">
                        <input id="keyword" name="keywords" placeholder="请输入商品名称 货号" class="text" type="text">
                        <input value="" class="submit" id="list_search_submit" type="button" onclick="javascript:void(search())">
                    </div>
                </form>
            </div>

        </div>
    </header>
    <div style="height:46px;" class="empty_div">&nbsp;</div>
    <section class="filtrate_term" id="product_sort" style="width: 100%; z-index:9999; border-bottom:1px solid #CCC">

    </section>
    <div style=" height:5px"></div>

    <div class="touchweb-com_searchListBox openList" id="goods_list">
        <form action="javascript:void(0)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">

            <div id="J_ItemList" style="opacity: 1;">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div id="more_element_1" class="product single_item info">
                        <li>
                            <div class="item">

                                <div style="position:absolute;width:50px;height:50px;z-indent:2;left:0;top:5px; z-index:2;">
                                    <?php if($vo['cxcount'] > 0): ?><a href="#"><img src="/Public/assets/images/cx.png" alt="促销" width="50" height="50" onclick="showcxcontent('<?php echo ($vo["fmaterialid_id"]); ?>')"></a><?php endif; ?>

                                </div>
                                <div class="goods_images">


                                    <a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($vo["fmaterialid_id"]); ?>&publishid=<?php echo ($vo["publishid"]); ?>"><img src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>"></a>
                                </div>
                                <dl>
                                    <dt><a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($vo["fmaterialid_id"]); ?>&publishid=<?php echo ($vo["publishid"]); ?>"><?php echo ($vo["fshowname"]); ?></a></dt>
                                    <dd><i><?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></i>
                                    </dd>
                                </dl>
                            </div>

                            <div class="goods_number">
                                <div class="ui-number">
                                    <a class="decrease" onClick="goods_cut(<?php echo ($vo["publishid"]); ?>);">-</a>
                                    <input class="num" id="number<?php echo ($vo["publishid"]); ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                                           onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" value="1" onFocus="if(value=='1') {value=''}" size="4"
                                           maxlength="5" type="text">
                                    <a class="increase" onClick="goods_add(<?php echo ($vo["publishid"]); ?>);">+</a>
                                </div>
                            </div>
                            <span class="bug_car" onClick="addBasket('<?php echo ($vo["publishid"]); ?>');javascript:alert('添加成功！')">
<img src="/Public/assets/images/index_flow.png">
</span>

                        </li>

                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </form>

    </div>

</section>

<section class="list-pagination">
    <div style="" class="pagenav-wrapper" id="J_PageNavWrap">
        <div class="pagenav-content">
            <div class="pagelist" id="J_PageNav">
                <?php echo ($page); ?>

            </div>
        </div>
    </div>
</section>
<div style="height:50px; line-height:50px; clear:both;"></div>
<!DOCTYPE html>
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

</script>
<script>
    function goTop() {
        $('html,body').animate({'scrollTop': 0}, 600);
    }
</script>
<a href="javascript:goTop();" class="gotop" style=" z-index:9999"><img src="/Public/assets/images/topup.png"></a>

</body>
</html>

<script>
    function addBasket(publishid) {

        var qty = $("#number" + publishid).val();
        var url = "/index.php/Home/Goodsdetail/addBasket";
        $.get(url, {"publishid": publishid, "qty": qty},
            function (req) {
                var result = eval('(' + req + ')');
                getbasketqtycount();
                close_choose_attr();
            });
    }

    function goods_add(publishid) {
        var qty = parseInt($("#number" + publishid).val());
        qty = qty + 1;
        $("#number" + publishid).val(qty);
    }

    function goods_cut(publishid) {
        var qty = parseInt($("#number" + publishid).val());
        qty = qty - 1;
        if (qty == 0) {
            qty = 1;
        }
        $("#number" + publishid).val(qty);
    }

    function search() {
        var keyword = $("#keyword").val();
        var categid = "<?php echo ($categid); ?>";
        var url = "/index.php/Home/Goods/showcategory?categid=" + categid + "&keyword=" + keyword;
        location.href = url;

    }
</script>

<script>
    $(function () {
        getbasketqtycount();
    });

    function getbasketqtycount() {
        var url = "/index.php/Home/Index/getbasketcount";
        $.get(url, {}, function (req) {
            $("#basketqtycount").html(req);
        });
    }
</script>