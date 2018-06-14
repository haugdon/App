<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="XBSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <head>
        <title>雪宝集团—经销商订货平台</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
        <link rel="stylesheet" type="text/css" href="/Public/assets/css/index.css">
        <link rel="stylesheet" type="text/css" href="/Public/assets/css/css.css">
        <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="/Public/assets/js/TouchSlide.js"></script>
        <script src="/Public/assets/js/common_jquery_75554d22a0.js" charset="utf-8"></script>
        <script src="/Public/assets/js/base_2cdff17c2b.js" charset="utf-8"></script>
        <script src="/Public/assets/js/u_b.js" charset="utf-8"></script>
        <script src="/Public/assets/js/tags.js" charset="utf-8"></script>
    </head>
<body>
<div class="body_bj">
    <section class="index_floor">

        <div id="page" class="showpage">
            <div>
                <div id="scrollimg" class="scrollimg">
                    <div class="bd">
                        <div class="tempWrap" style="overflow:hidden; position:relative;">
                            <ul style="width: 6745px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 200ms; transform: translateX(-4047px);">
                                <li style="display: table-cell; vertical-align: top; width: 1349px;"><a href="#"><img src="/Public/assets/images/1.jpg" width="100%"></a></li>
                                <li style="display: table-cell; vertical-align: top; width: 1349px;"><a href="#"><img src="/Public/assets/images/2.jpg" width="100%"></a></li>
                                <li style="display: table-cell; vertical-align: top; width: 1349px;"><a href="#"><img src="/Public/assets/images/3.jpg" width="100%"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="hd">
                        <ul></ul>
                    </div>
                </div>
                <script type="text/javascript">
                    TouchSlide({
                        slideCell: "#scrollimg",
                        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                        mainCell: ".bd ul",
                        effect: "leftLoop",
                        autoPage: true,//自动分页
                        autoPlay: true //自动播放
                    });
                </script>
                <script>
                    var Tday = new Array();
                    var daysms = 24 * 60 * 60 * 1000
                    var hoursms = 60 * 60 * 1000
                    var Secondms = 60 * 1000
                    var microsecond = 1000
                    var DifferHour = -1
                    var DifferMinute = -1
                    var DifferSecond = -1

                    function clock(key) {
                        var time = new Date()
                        var hour = time.getHours()
                        var minute = time.getMinutes()
                        var second = time.getSeconds()
                        var timevalue = "" + ((hour > 12) ? hour - 12 : hour)
                        timevalue += ((minute < 10) ? ":0" : ":") + minute
                        timevalue += ((second < 10) ? ":0" : ":") + second
                        timevalue += ((hour > 12) ? " PM" : " AM")
                        var convertHour = DifferHour
                        var convertMinute = DifferMinute
                        var convertSecond = DifferSecond
                        var Diffms = Tday[key].getTime() - time.getTime()
                        DifferHour = Math.floor(Diffms / daysms)
                        Diffms -= DifferHour * daysms
                        DifferMinute = Math.floor(Diffms / hoursms)
                        Diffms -= DifferMinute * hoursms
                        DifferSecond = Math.floor(Diffms / Secondms)
                        Diffms -= DifferSecond * Secondms
                        var dSecs = Math.floor(Diffms / microsecond)

                        if (convertHour != DifferHour) a = DifferHour + ":";
                        if (convertMinute != DifferMinute) b = DifferMinute + ":";
                        if (convertSecond != DifferSecond) c = DifferSecond + "分"
                        d = dSecs
                        if (DifferHour > 0) {
                            a = a
                        }
                        else {
                            a = ''
                        }
                        document.getElementById("jstimerBox" + key).innerHTML = a + b + c; //显示倒计时信息
                    }
                </script>
                <script type="text/javascript">
                    TouchSlide({
                        slideCell: "#scroll_best",
                        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
                        effect: "leftLoop",
                        autoPage: true, //自动分页
                        //switchLoad:"_src" //切换加载，真实图片路径为"_src"
                    });
                </script>
                <div class="black"></div>


                <div class="black" style="height:auto;"></div>
                <script type="text/javascript">
                    var url = 'index_bestgoods.php?act=ajax';
                    $(function () {
                        $('#J_ItemList').more({'address': url});
                    });
                </script>
            </div>

        </div>
    </section>


    <div class="index_search">
        <div class="index_search_mid">
            <input id="searchtext" name="searchtext" type="text" style="width:80%; margin:auto; height:22px; border:none; padding:2px 2px 2px 12px;"> <span>
      <img src="/Public/assets/images/icosousuo.png" onclick="javascript:void(searchgoods())"></span>
        </div>
    </div>
    <div class="entry-list clearfix">
        <nav>
            <ul>
                <li>
                    <a href="/index.php/Home/Goods/showspfl">
                        <img alt="产品分类" src="/Public/assets/images/t1.png">
                        <span>产品分类</span>
                    </a>
                </li>
                <li>
                    <a href="/index.php/Home/Basket">
                        <img alt="购物车" src="/Public/assets/images/t2.png">
                        <span>购物车</span>
                    </a>
                </li>
                <li>
                    <a href="/index.php/Home/Cust/showorderlist">
                        <img alt="我的订单" src="/Public/assets/images/t3.png">
                        <span>我的订单</span>
                    </a>
                </li>
                <li>
                    <a href="/index.php/Home/Cust">
                        <img alt="会员中心" src="/Public/assets/images/t4.png">
                        <span>会员中心</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>


    <script type="text/javascript">
        TouchSlide({
            slideCell: "#scroll_hot",
            titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            effect: "leftLoop",
            autoPage: true, //自动分页
            //switchLoad:"_src" //切换加载，真实图片路径为"_src"
        });
    </script>


    <section class="floor_body">

        <div style=" background:#eeeeee">
            <ul>
                <div class="custom-tags js-custom-tags" data-size="3" data-size_type="0" data-buy_btn="1" data-buy_btn_type="1" data-title="0" data-price="1" data-cart="1" data-show_wish_btn="0" data-wish_btn_type="1"
                     data-show_sub_title="0">

                    <div class="js-tabber-tags tabber tabber-bottom red clearfix tabber-n3  ">
                        <div class="custom-tags-more js-show-all-tags"></div>
                        <div id="J_tabber_scroll_wrap" class="custom-tags-scorll clearfix" style="text-align:center;">
                            <img src="/Public/assets/images/hot.png" width="90%"></div>
                    </div>


                    <div class="js-goods-tag js-goods-tag-1" data-alias="bqron00f" style="min-height:100px;">
                        <div class="js-list b-list">
                            <ul style="visibility: visible;" class="js-goods-list sc-goods-list clearfix list size-3" data-size="3">


                                <!-- 商品区域 -->
                                <!-- 展现类型判断 -->
                                <?php if(is_array($indexgoodslist)): $i = 0; $__LIST__ = $indexgoodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="goods-card card">
                                        <div style="position:absolute;width:50px;height:50px;z-indent:2;left:0;top:5px; z-index:2;">
                                            <?php if($vo['cxcount'] > 0): ?><a href="#"><img src="/Public/assets/images/cx.png" alt="促销" width="50" height="50" onclick="showcxcontent('<?php echo ($vo["fmaterialid_id"]); ?>')"></a><?php endif; ?>

                                        </div>
                                        <a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid_id"]); ?>&publishid=<?php echo ($vo["fid"]); ?>" class="js-goods link clearfix" data-goods-id="{vo.fmaterid_id}" title="<?php echo ($vo["fshowname"]); ?>">
                                            <div style="background-color: rgb(255, 255, 255);" class="photo-block">
                                                <img src=http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>>

                                            </div>
                                            <div class="info">
                                                <p class="goods-title"> <?php echo ($vo["fshowname"]); ?></p>

                                                <p class="goods-price"><em>￥<?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></em></p>
                                                <p style=" font-size:12px; color:#999;"><em>统一零售价：￥<?php echo (number_format($vo["tylsj"], 2, '.', '')); ?></em></p>

                                                <div class="goods-buy btn1"></div>
                                                <div class="js-goods-buy buy-response" data-alias="hpxnsh0y" data-postage="0" data-buyway="1" data-id="<?php echo ($vo["fmaterialid_id"]); ?>" data-title="<?php echo ($vo["fshowname"]); ?>" data-price="<?php echo ($vo["fstdprice"]); ?>"
                                                     data-isvirtual="0"></div>
                                            </div>
                                        </a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>


                            </ul>
                        </div>
                    </div>

                    <div class="js-goods-tag js-goods-tag-2 hide" data-alias="ig8kin3t" style="min-height:100px;">
                        <div class="js-list b-list">
                            <ul style="visibility: visible;" class="js-goods-list sc-goods-list clearfix list size-3" data-size="3">


                                <!-- 商品区域 -->
                                <!-- 展现类型判断 -->
                                <?php if(is_array($indexgoodslist_cw)): $i = 0; $__LIST__ = $indexgoodslist_cw;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="js-goods-card goods-card card">
                                        <a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid_id"]); ?>&publishid=<?php echo ($vo["fid"]); ?>" class="js-goods link clearfix" data-goods-id="<?php echo ($vo["fmaterialid_id"]); ?>" title="<?php echo ($vo["fshowname"]); ?>">
                                            <div style="background-color: rgb(255, 255, 255);" class="photo-block">
                                                <img src=http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>>
                                            </div>
                                            <div class="info">
                                                <p class="goods-title"> <?php echo ($vo["fshowname"]); ?></p>
                                                <?php if($vo['cxcount'] > 0): ?><p class="goods-price"><em>该产品有促销活动</em></p><?php endif; ?>
                                                <p class="goods-price"><em>￥<?php echo (number_format($vo["fstdprice"], 2, '.', '')); ?></em></p>
                                                <div class="goods-buy btn1"></div>
                                                <div class="js-goods-buy buy-response" data-alias="hpxnsh0y" data-postage="0" data-buyway="1" data-id="<?php echo ($vo["fmaterialid_id"]); ?>" data-title="<?php echo ($vo["fshowname"]); ?>" data-price="<?php echo ($vo["fstdprice"]); ?>"
                                                     data-isvirtual="0"></div>
                                            </div>
                                        </a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>

                            </ul>
                        </div>
                    </div>


                </div>
            </ul>
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
    <a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a>


</div>
</body>
</html>
<script>
    function searchgoods() {
        var keyword = $("#searchtext").val();
        var categid = "0";
        if (keyword != "") {
            var url = "/index.php/Home/Goods/showcategory?categid=" + categid + "&keyword=" + keyword;
            location.href = url;
        }
    }

    function showcxcontent(materialid) {
        var url = "/index.php/Home/Index/getcxcontent";
        $.get(url, {"materialid": materialid}, function (data) {
            var result = eval('(' + data + ')');
            alert(result.msg);
        });
    }
</script>