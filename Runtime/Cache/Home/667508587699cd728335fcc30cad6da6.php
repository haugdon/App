<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="ECSHOP v2.7.3">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>收藏夹-雪宝集团</title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/user.css">
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/public.css">
    <script src="/Public/assets/js/modernizr.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery_002.js"></script>
    <script type="text/javascript" src="/Public/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/assets/js/transport.js"></script>
    <script type="text/javascript" src="/Public/assets/js/common.js"></script>
    <script type="text/javascript" src="/Public/assets/js/utils.js"></script>
</head>
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

<body class="body_bj">

<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid">我的收藏</div>

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

    <div class="sc_nav">
        <ul>
            <li class="tab_head on" id="goods_ka1">收藏的宝贝</li>

        </ul>
    </div>

    <div class="main" id="user_goods_ka_1">
        <form name="theForm" method="post" action="">
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="shouchang">
                    <dl>
                        <dt><a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fpublishid"]); ?> ">
                            <img src=http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>></a></dt>
                        <dd>
                            <a href="/index.php/Home/Goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fpublishid"]); ?> ">
                                <p><?php echo ($vo["fshowname"]); ?></p>
                                <strong><?php echo ($vo["fstdprice"]); ?></strong>
                            </a>
                            <span>
       <a href="javascript:addBasket('<?php echo ($vo["fpublishid"]); ?>')" class="s_flow" style=" color:#E71F19;font-size:14px;">加入购物车</a>
       <a href="javascript:delFavorite('<?php echo ($vo["fpublishid"]); ?>')" class="s_out" style=" color:#999;font-size:14px;">删除</a>
      </span>
                        </dd>
                    </dl>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
        <section class="list-pagination">
            <div style="" class="pagenav-wrapper" id="J_PageNavWrap">
                <div class="pagenav-content">
                    <div class="pagelist" id="J_PageNav">
                        <?php echo ($page); ?>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div class="main" id="user_goods_ka_2" style="display:none">
        <div class="dotm_no">
            <dl>
                <dd>您还没有收藏店铺哦！</dd>
            </dl>
        </div>

    </div>
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
    function addBasket(publishid) {
        var qty = 1;
        var url = "/index.php/Home/Goodsdetail/addBasket";
        $.get(url, {"publishid": publishid, "qty": qty},
            function (req) {
                var result = eval('(' + req + ')');
                alert(result.msg);
            });

    }

    function delFavorite(publishid) {
        var url = "/index.php/Home/Cust/delFavorite";
        $.get(url, {"publishid": publishid},
            function (req) {
                var result = eval('(' + req + ')');
                location.reload();
            });
    }

</script>