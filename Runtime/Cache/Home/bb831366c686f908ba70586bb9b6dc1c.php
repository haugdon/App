<?php if (!defined('THINK_PATH')) exit();?><div class="v_nav">
<div class="vf_nav">
<ul>
<li> <a href="#">
    <i class="vf_1"></i>
    <span>首页</span></a></li>
<li><a href="#">
    <i class="vf_2"></i>
    <span>客服</span></a></li>
<li><a href="#">
    <i class="vf_3"></i>
    <span>分类</span></a></li>
<li>
<a href="/index.php/Home/Basket">
   <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style="right:9px;"> <?php if(is_array($basketcount)): $i = 0; $__LIST__ = $basketcount;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vobasket): $mod = ($i % 2 );++$i; echo ($vobasket["qty"]); endforeach; endif; else: echo "" ;endif; ?> </em>
   <i class="vf_4"></i>
   <span>购物1车</span>
   </a></li>
<li><a href="/index.php/Home/Cust">
    <i class="vf_5"></i>
    <span>我的</span></a></li>
</ul>
</div>
</div>