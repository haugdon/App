<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>销售日报表</title>
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/icon.css">

    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/locale/easyui-lang-zh_CN.js"></script>


    <link rel="stylesheet" type="text/css" href="/Public/autop/js/autocomplete/jquery.autocomplete.css" />
    <link href="/Public/autop/css/style.css" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/thickbox-compressed.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/employee.js'></script>
    <link type="text/css" rel="stylesheet" href="/Public/alert/showBo.css" />
    <script type="text/javascript" src="/Public/alert/showBo.js"></script>
    <script type="text/javascript" src="/Public/alert/openframe.js"></script>

    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 2px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            color:#666;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        .editbox{
            background: #ffffff;
            border: 1px solid #b7b7b7;
            color: #003366;
            cursor: text;
            font-family: "arial";
            font-size: 9pt;
            height: 18px;
            padding: 1px; /*www.52css.com*/
        }
        .subtotal { font-weight: bold; }/*合计单元格样式*/
    </style>

</head>

<body class="easyui-layout" style="border: none;padding:0px">
<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<div  data-options="region:'center'" style="border: none">

    <!-- 内容 -->

    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/Rpt/getsalereport',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:10,
				toolbar:'#tb',fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'billdate',width:70,align:'center',formatter:formatTotal">日期</th>
            <th data-options="field:'costamount',width:80,align:'center',pattern:'$.00'">成本金额</th>
            <th data-options="field:'amount',width:60,align:'center',pattern:'$.00'">销售金额</th>
			<th data-options="field:'lramount',width:60,align:'center',pattern:'$.00'">毛利</th>
            <th data-options="field:'skamount',width:60,align:'center',pattern:'$.00'">实收金额</th>
            <th data-options="field:'yhje',width:60,align:'center',pattern:'$.00'">优惠金额</th>

        </tr>
        </thead>
    </table>





    <div id="tb" style="padding:3px;background-color: #e0e8eb">
        <form id="fm" method="post">
		<div id="cc" class="easyui-calendar"></div>
            门店：<input class="easyui-combobox" name="warehouse" style="width: 88px" id="warehouse" data-options="valueField:'fcustid',textField:'fname',url:'/index.php/Home/billinfo/getwarehouse' " required="true">
			日期：<input id="billdate" name="billdate" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">
            至 <input id="billdate2" name="billdate2" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">


            
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()" id="btnSearch">查询</a>
            &nbsp;<span id="mess" style="color:red"></span>
        </form>


    </div>
</div>


</body>
</html>
<script>
    $(function(){

 var curr_time = new Date();
        var strDate = curr_time.getFullYear()+"-";
        strDate += curr_time.getMonth()+1+"-";
        strDate += curr_time.getDate()+"-";
        strDate += curr_time.getHours()+":";
        strDate += curr_time.getMinutes()+":";
        strDate += curr_time.getSeconds();

        var n=new Date();
        n.setDate(n.getDate()-30);
        var date2=n.getFullYear()+"-"+ (n.getMonth()+1)+"-"+ n.getDate();
        $("#billdate").datebox("setValue", date2);
        $("#billdate2").datebox("setValue", strDate);
        $('#warehouse').combobox({
            onLoadSuccess : function(data) {
                $('#warehouse').combobox('setValue', data[0].fcustid);
            }
        });

        //Export
        $("#btnexport").click(function() {
            var warehouseid=$('#warehouse').combobox('getValue');

			var startdate=$('#billdate').datebox('getValue');
			var enddate=$('#billdate2').datebox('getValue');
            var url='/index.php/Home/rpt/saleday_export?warehouseid='+warehouseid+'&startdate='+startdate+'&enddate='+enddate;
            location.href=url;
        });

    });



    function formatTotal(value,row,index){
        if(value=="Total"){
            return "合计";}else{
            return value;
        }
    }


</script>
<script type="text/javascript">

    function doSearch(){

       
        var startdate=$('#billdate').datebox('getValue');
		var enddate=$('#billdate2').datebox('getValue');
       
        $('#tt').datagrid('load',{
            warehouseid:$('#warehouse').combobox('getValue'),
               startdate:startdate,
			enddate:enddate
        });
    }
</script>