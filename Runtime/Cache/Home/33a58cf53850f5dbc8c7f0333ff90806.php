<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div class="item-list">
    <?php if(is_array($fjlist)): $i = 0; $__LIST__ = $fjlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <div class="inner">
                <div class="item_img_"><a href="/index.php/home/goodsdetail?materialid=<?php echo ($vo["fmaterialid"]); ?>&publishid=<?php echo ($vo["fid"]); ?>"> <img src="http://weixin.xuebaoruye.com:1003/imgserver<?php echo ($vo["imgpath"]); ?>"></a></div>

                <div class="goods_desc edit_info_1">
                    <dl>
                        <dt><?php echo ($vo["fname"]); ?></dt>
                    </dl>
                    <div class="price"><span>￥<?php echo ($vo["fprice"]); ?></span></div>
                </div>
                <div class="goods_number">
                    <div class="qiehuan">
                        <div class="xm-input-number">
                            <?php echo ($vo["fqty"]); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div style="background:#FFF; height:2px;">

            </div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</body>
</html>