<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <title>Title</title>
</head>
<body>
<?php echo ($access_token); ?>

<input type="button" name="test" value="usertest" onclick="test()" />
<input type="button" name="test" value="usertest" onclick="send2()" />
<script>
    function send2()
    {
        location.href="/index.php/Home/Index/sendmsg";
    }
    function send()
    {
        var json="";
        var access_token="<?php echo ($access_token); ?>";
        var url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token="+access_token;
        var aj = $.ajax( {
            url:url,// 跳转到 action
            data:{
                touser:"season9120|tzb",
                msgtype:"text",
                agentid:26,
                text:{"content":"订单来了！"}
            },
            type:'post',
            cache:false,
            dataType:'json',
            success:function(data) {
               alert(data);
            },
            error : function(req) {
                // view("异常！");
                var result=('('+req+')');
                alert(result);
            }
        });
    }
    function test()
    {
        var url="https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=a9RMLCnjp_0IK3mn7EKFFUwFMNYIOSz3WkTszvHxSIycR6pVUnPl5n_P6gpLq8kC";
        post(url,{userid:'season9210'});

    }
    function test2()
    {
        var url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ed2e3d5aeb3cfd1&redirect_uri=weixin.xuebaoruye.com%3A1000&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
        location.href=url;
    }
    function useridtooperid()
    {
        var Corpid="wx5ed2e3d5aeb3cfd1";
        var secrept="bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
        var url="/index.php/Home/Index/getaccess_token";
        var access_token="";
        var userid="season9210";
        $.get(url,function(req){
            var result=eval('('+req+')');
            access_token=result.access_token;
            alert(access_token);
            var url2="/index.php/Home/Index/getuseridtooperid";
            $.post(url2,{"access_token":access_token},function(req){
                alert(req);
            });
       });
    }
</script>
</body>
</html>

<script>
    function post(url, params) {
        var temp = document.createElement("form");
        temp.action = url;
        temp.method = "post";
        temp.style.display = "none";
        for (var x in params) {
            var opt = document.createElement("input");
            opt.name = x;
            opt.value = params[x];
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
    }
</script>