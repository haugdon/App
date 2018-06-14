<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="Generator" content="ECSHOP v2.7.3">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>订单方案-雪宝集团</title>
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
</head>
<body style="background:#e5e5e5;">

 

<div class="tab_nav">
  <div class="header" style=" position:relative">
    <div class="h-left"> <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a> </div>
    <div class="h-mid"> <?php echo ($famc); ?> </div>
  </div>
  <dl>
    <dd class="top_bar" style=" position:absolute; top:0; right:2%; z-index:999999">
      <div onclick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
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
    <div class="shopmain_title">
      <dl>
        <input type="checkbox" autocomplete="off"  checked=checked class="f_checkbox f_pub_checkbox f_pub_checkbox_1" title="1" style=" margin-top:10px; margin-left:10px;">
        <dt class="shopmain_black"> 添加商品 </dt><dt class="shopmain_red"> 保 存 </dt>
        <dt class="shopmain_dred"> 删除方案 </dt><dt class="shopmain_green"> 下 单 </dt>
        
      </dl>
    </div><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
        <div class="item-list">
              <div class="inner">
        <input type="checkbox" autocomplete="off" name="sel_cartgoods[]" value="752"
                   id="sel_cartgoods_752" checked=checked   
                  class="f_checkbox check-wrapper check-wrapper-1">
        <div class="item_img">  <a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fid"]); ?>">  <img src=http://61.157.143.136:1001/imgserver<?php echo ($vo["imgpath"]); ?> ></a>  </div>
        
        <div class="goods_desc edit_info_1" >
          <dl>
            <dt><?php echo ($vo["fshowname"]); ?></dt>
                    </dl>
          <div class="price"><span>￥<?php echo ($vo["fstdprice"]); ?></span> <em id="goods_numx_752"></span> </div>
        </div>
        <div class="goods_number"><div class="qiehuan">
          <div class="xm-input-number"> 
            <a href="javascript:;" onclick="minus_num(752, 225, 0,0);" id="jiannum752" class="input-sub " ></a>
            <input type="text" onKeyDown='if(event.keyCode == 13) event.returnValue = false' name="goods_number[752]" id="goods_number_752" value="1"  class="input-num"  onblur="change_price(752, 225, 0)"/>
            <input type="hidden" id="hidden_752" value="1">
            <a href="javascript:;" onclick='javascript:add_num(752, 225, 0,0)'  class="input-add"></a> </div><div class="delete">
            <a href="javascript:if (confirm('您确实要把该商品移出订单方案吗？')) delBasket(<?php echo ($vo["fid"]); ?>);">
           删除
          </a> 
           </div>
                  </div></div>
        <div class="num edit_box_1" style="display:none;"> 
                    <div class="qiehuan">
          <div class="xm-input-number"> 
            <a href="javascript:;" onclick="minus_num(752, 225, 0,0);" id="jiannum752" class="input-sub " ></a>
            <input type="text" onKeyDown='if(event.keyCode == 13) event.returnValue = false' name="goods_number[752]" id="goods_number_752" value="1"  class="input-num"  onblur="change_price(752, 225, 0)"/>
            <input type="hidden" id="hidden_752" value="1">
            <a href="javascript:;" onclick='javascript:add_num(752, 225, 0,0)'  class="input-add"></a> </div>
                  </div>  
          
           </div>
      </div>
    </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
        
        <div class="flow_activity"> 
       
       
    </div>
  </div><em id="goods_numx_752"><em id="goods_numx_751">
    <div style=" height:50px"></div>
  <div class="flow_bottom">
    <div class="shopmain_title">
      <dl>
        <input type="checkbox" autocomplete="off"  checked=checked class="f_checkbox f_pub_checkbox f_pub_checkbox_1" title="1" style=" margin-top:10px; margin-left:10px;">
        <dt class="shopmain_black"> 添加商品 </dt><dt class="shopmain_red"> 保 存 </dt>
        <dt class="shopmain_dred"> 删除方案 </dt><dt class="shopmain_green"> 下 单 </dt>
        
      </dl>
    </div>
 <script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="/Public/assets/images/topup.png"></a> 

  </div>
</em></em></form></body></html>