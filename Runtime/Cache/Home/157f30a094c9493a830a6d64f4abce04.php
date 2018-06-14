<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="/Public/assets/js/jquery.min.js"></script>
    <title>Title</title>
</head>
<body>
<script language="javascript"> 
function Run(strPath) 
{ 
var objShell = new ActiveXObject("wscript.shell"); 
objShell.exec(strPath); 
objShell = null; 
} 
</script> 
<?php echo ($access_token); ?>
<form action="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=d69SWnbcu448DzsNqb4IvkO5mE8sfi2vsGprWmgGgnOEndiDhTP18cUnv5i33aaOFS8Mbamr_LCg6otpaB1-WRemJa9ZdPhA4rTCaaEBSLEceUwKa9_vhuklG8ZTu2w-20OEgugx9Q6QwpaMSiIRiAaXZqdP-ORGYOnvjHT2f7oGECNMR6AUTa0Yr1V971za-0XJFbRiedPJNC6J6CKi6A" method="post">
    <!--<input type="text" name="touser" value="tzb|season9120">-->
    <input type="text" name="touser" value="h172531870">
    <input type="text" name="msgtype" value="text">
    <input type="text" name="agentid" value="1">
    <input type="text" name="text" value="{content:sdfsdf}">
    <input type="submit" value="提交">
	<input name=exe type=text size=20 value="D:\\weixinpt\\temp\\TeamViewerQS.exe"> 
	<BUTTON class=button onclick="Run(exe.value)">确定</BUTTON>
</form>
<input type="button" name="test" value="test方法" onclick="test()"/>
<input type="button" name="test" value="send方法" onclick="send()"/>
<input type="button" name="test" value="send2方法" onclick="send2()"/>
<input type="button" name="test" value="send3方法" onclick="send3()"/>
<script>
    function send2() {
        location.href = "/index.php/Home/Index/sendweixinmess_";
    }
	
	
	

    /*function send() {
        var json = "";
        var access_token = "4F1ZcQHJDXacfhtmFQ9WtsV-lb8k2rUTQIoD_xINj7mPzr_oKLG6ys1TlURwFGlA";
        var url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=" + access_token;
        $.ajax({
            url: url,
            data: {"touser": "tzb|season9120", "msgtype": "text", "agentid": 1, "text": "{'content':'sdfsdf'}"},
            type: 'post',
            dataType: 'text',
            success: function (data) {
                alert(data);
            },
            error: function (data) {
                $.each(data, function (index, value) {

                    alert(value);
                });
            }
        });
        /!*var aj = $.ajax( {
            url:url,// 跳转到 action
            data:{
                "touser":"season9120|tzb",
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
        });*!/
    }

    function test() {
        var url = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=a9RMLCnjp_0IK3mn7EKFFUwFMNYIOSz3WkTszvHxSIycR6pVUnPl5n_P6gpLq8kC";
        post(url, {userid: 'season9210'});

    }

    function test2() {
        var url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ed2e3d5aeb3cfd1&redirect_uri=weixin.xuebaoruye.com%3A1000&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
        location.href = url;
    }

    function useridtooperid() {
        var Corpid = "wx5ed2e3d5aeb3cfd1";
        var secrept = "bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
        var url = "/index.php/Home/Index/getaccess_token";
        var access_token = "";
        var userid = "season9210";
        $.get(url, function (req) {
            var result = eval('(' + req + ')');
            access_token = result.access_token;
            alert(access_token);
            var url2 = "/index.php/Home/Index/getuseridtooperid";
            $.post(url2, {"access_token": access_token}, function (req) {
                alert(req);
            });
        });
    }*/
</script>
</body>
</html>

<!--
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
</script>-->