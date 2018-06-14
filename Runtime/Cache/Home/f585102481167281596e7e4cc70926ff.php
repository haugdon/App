<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- End of Meta -->
		
		<!-- Page title -->
		<title>成都市龙泉驿区供销合作社 农业投入品质量溯源系统</title>
		<!-- End of Page title -->
		
		<!-- Libraries -->
		<link type="text/css" href="/Public/login/css/login.css" rel="stylesheet" />	
		<link type="text/css" href="/Public/login/css/smoothness/jquery-ui-1.7.2.custom.html" rel="stylesheet" />	
		
		<script type="text/javascript" src="/Public/login/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="/Public/login/js/easyTooltip.js"></script>
		<script type="text/javascript" src="/Public/login/js/jquery-ui-1.7.2.custom.min.js"></script>
		<!-- End of Libraries -->	
	</head>
	<body>
	<div id="container">
		<div class="logo">
			<a href="#"><img src="/Public/login/assets/logo.png" alt="" /></a>
		</div>
		<div id="box">
			<form action="login?dosubmit=1" method="POST" name="loginfrm">
			<p class="main">
				<label>用户名: </label>
				<input name="username" value="" id="username" isautotab="true"/> 
				<label>密码: </label>
				<input type="password" name="password" value="" id="password" isautotab="true"/>	
				<label>验证码: </label>
				<input type="text" name="code" value="" id="code" isautotab="true">              		
                <img id="code_img" align="top" style="border:1px solid #c2ccd0;margin-left:2px;float:left" onclick="changeCode()" src="code?code_len=4&font_size=15&width=120&height=30" title="点击切换验证码">
				<label></label><input type="button" onclick="login()" style="height:33px;background:#6da552;color:#fff;width:71px;background-image: url('/Public/login/assets/loginbtn.png');" isautotab="true"/>

			</p>

			<p class="space">
			    <span id="info" style="margin-left:90px;color:red"></span>

				
			</p>
			</form>
		</div>
	</div>
	</body>
</html>
<script type="text/javascript">
        $('#username').focus();
		var changeCode = function(){
		var that = document.getElementById('code_img');
		that.src = that.src + '&' + Math.random();
        }
var login = function(){
			if(!$('#username').val()){
				$('#info').text('请填写用户名');				
				$('#username').focus();
				return false;
			}
			if(!$('#password').val()){
				$('#info').text('请填写密码');				
				$('#password').focus();
				return false;
			}
			if(!$('#code').val()){
				$('#info').text('请填写验证码');				
				$('#code').focus();
				return false;
			}
			$.post('login?dosubmit=1', $("form").serialize(), function(data){
				if(!data.status){
					//alert( data.info);
					$('#info').text(data.info);								
					changeCode();
				}else{
					//$.messager.progress({text:'加载中，请稍候...'});
					window.location.href = data.url;
				}
			},'json');
			return false;
		}
$(function() {
$('[isautotab]').each(function (index) {
                $(this).keydown(function (event) {
                    if (event.keyCode == 13) {
                        $('[isautotab]:eq(' + (index + 1) + ')').focus();
                    }
                });
            });
  
});		
</script>