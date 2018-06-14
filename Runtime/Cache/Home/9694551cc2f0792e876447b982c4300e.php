<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/icon.css">
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/locale/easyui-lang-zh_CN.js"></script>

</head>


<body >

<div class="container">
    <div class="detail-page">
<div class="detail-section">
    <h6 style="border-bottom:1px solid #ccc;margin:6px;font-size:12px;coror:#2b2b2b" title="通知公告">通知公告</h6>
    <div class="row detail-row">
        <table border="0" cellpadding="1" cellspacing="1" style="background-color: #DDDDDD">
            <tr><td style="background-color: #f4f4f4;width:160px;font-family: 宋体, Arial, sans-serif;font-size:13px;line-height: 22px;padding-left: 2px">标题</td>
                <td style="background-color: #f4f4f4;font-family: 宋体, Arial, sans-serif;font-size:13px;line-height: 22px;padding-left: 2px">公告内容</td></tr>
        <?php if(is_array($noticelist)): $i = 0; $__LIST__ = $noticelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td style="background-color: #ffffff;font-family: 宋体, Arial, sans-serif;font-size:12px;line-height: 22px;padding-left: 2px"><?php echo ($vo["title"]); ?></td>
            <td style="background-color: #ffffff;font-family: 宋体, Arial, sans-serif;font-size:12px;;padding-left: 2px"><?php echo ($vo["content"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
    </div>
        </div>
    <div id="down">
        <h6 style="border-bottom:1px solid #ccc;margin:6px;font-size:12px;color:#2b2b2b" title="打印控件安装">打印控件安装</h6>
        <span id="downcaption"></span>
        <br>
        <a href="/Public/prints/Firefox-full-latest.exe" title="火狐浏览器下载" >火狐浏览器下载</a><br/>
        <a href=/Public/prints/install_lodop32.exe title='下载后进行安装即可'>32位浏览器_点击下载打印控件进行安装</a>
    </div>
    </div>
</body>

</html>

<script type="text/javascript">

    function getCPU()

    {

        var agent=navigator.userAgent.toLowerCase();

        if(agent.indexOf("win64")>=0||agent.indexOf("wow64")>=0) return "x64";

        return navigator.cpuClass;

    }
     var lx=getCPU();
        var host="http://"+window.location.host;
        if (getCPU()=='x64')
        {
            $("#downcaption").html("<a href=/Public/prints/install_lodop64.exe title='下载后进行安装即可'>点击下载打印控件进行安装</a>");
        }else{
            $("#downcaption").html("<a href=/Public/prints/install_lodop32.exe title='下载后进行安装即可'>点击下载打印控件进行安装</a>");
        }

</script>