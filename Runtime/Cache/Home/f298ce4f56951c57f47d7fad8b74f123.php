<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <title>Title</title>
</head>
<body>
<script>
    $(function(){
        var auth_code="<?php echo ($auth_code); ?>";
        var url2="https://qyapi.weixin.qq.com/cgi-bin/service/get_login_info?access_token=ACCESS_TOKEN";
        alert(url2);
        $.post(url2,{"auth_code":auth_code},function(req){
            alert(req);
        });
    });
</script>
</body>
</html>