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
    <link href="<?php echo ($Url); ?>Public/bui-bootstrap/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ($Url); ?>Public/bui-bootstrap/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ($Url); ?>Public/bui-bootstrap/assets/css/page-min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo ($Url); ?>Public/bui-bootstrap/assets/js/bui-min.js"></script>
    <script type="text/javascript" src="<?php echo ($Url); ?>Public/bui-bootstrap/assets/js/config-min.js"></script>
</head>


<body >

<div class="container">
    <div class="detail-page">
<div class="detail-section">
    <h6 style="border-bottom:1px solid #ccc;margin:6px;font-size:12px;coror:#2b2b2b" title="通知公告">通知公告</h6>
    <div class="row detail-row">
        <div class="span24">
            <div id="grid" style="width:99%"></div>
        </div>
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
    BUI.use('bui/grid',function (Grid) {
        var data = <?php echo ($noticelist); ?>,
                grid = new Grid.SimpleGrid({
                    render : '#grid', //显示Grid到此处
                    columns : [
                        {title:'标题',dataIndex:'title',width:60},
                        {title:'公告内容',dataIndex:'content',width:400},
                        {title:'发布日期',dataIndex:'fbrq',width:100,renderer:Grid.Format.dateRenderer}
                    ]
                });
        grid.render();
        grid.showData(data);
    });
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