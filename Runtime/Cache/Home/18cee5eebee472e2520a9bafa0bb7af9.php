<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>库存查询</title>
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
    <script type='text/javascript' src='/Public/autop/js/item_sel.js'></script>
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
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" onclick="setcostprice()">嘉禾品种采购单价设置</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<div id="grid"  data-options="region:'center'" style="border: none">

    <!-- 内容 -->

    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/Rpt/getinventorys',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:40,
				toolbar:'#tb',fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'fnumber',width:70,align:'center'">编号</th>
            <th data-options="field:'fname',width:80,align:'center',formatter:formatTotal">名称</th>
            <th data-options="field:'fspecification',width:60,align:'center'">规格型号</th>
            <th data-options="field:'batchno',width:60,align:'center'">批次号</th>
			<th data-options="field:'realqty',width:60,align:'center'" >数量</th>
            <th data-options="field:'costprice',width:100,align:'center'" >采购单价</th>
            <th data-options="field:'unit',width:60,align:'center'" >计量单位</th>
            <th data-options="field:'ly',width:100,align:'center'" >供应商</th>
        </tr>
        </thead>
    </table>





    <div id="tb" style="padding:3px;background-color: #e0e8eb">
        <form id="fm" method="post">
            货位：<input class="easyui-combobox" name="warehouse" style="width: 88px" id="warehouse" data-options="valueField:'fcustid',textField:'fname',url:'/index.php/Home/billinfo/getwarehouse' " required="true">
            品名：<input type="text" class="editbox" id="item" name="item" data-options="prompt:'输入名称|拼音码查询...'" style="width:200px;" required="true">
            <input type="hidden" id="itemid" name="itemid" value=""/>
            供应商：<input class="easyui-textbox" id="gys" name="item" data-options="prompt:'输入供应商名称查询...'" style="width:200px;" >
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()" id="btnSearch">查询</a>
            &nbsp;<span id="mess" style="color:red"></span>
        </form>


    </div>
</div>


</body>
</html>
<script>
    $(function(){
        itemsDropDownList("item", "/index.php/Home/billinfo/getItemlist_list",0,10,"itemid");
        $('#warehouse').combobox({
            onLoadSuccess : function(data) {
                $('#warehouse').combobox('setValue', <?php echo (session('custid')); ?>);
            }
        });

        //Export
        $("#btnexport").click(function() {
            var warehouseid=$('#warehouse').combobox('getValue');
            var itemid=$('#itemid').val();
            var url='/index.php/Home/rpt/inventory_export?warehouseid='+warehouseid+'&itemid='+itemid;
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
        var selectitemid;
        var gysname;
        if($("#item").val()=="")
        {
            selectitemid=0;
        }else
        {
            selectitemid=$('#itemid').val();
        }
        gysname=$('#gys').textbox('getValue');
        $('#tt').datagrid('load',{
            warehouseid:$('#warehouse').combobox('getValue'),
            itemid:selectitemid,
            gys:gysname
        });
    }

    function setcostprice()
    {
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            if(row.ly!="【嘉禾农资】"){
                $.messager.alert('提示','非嘉禾公司品种请在商品档案信息中设置或通过采购录入',"info");
                return false;
            }
            $.messager.prompt("设置采购单价", "输入采购单价：", function (data)  {
                if (data) {
                    var url = '/index.php/Home/Billinfo/setcostprice';
                    $.get(url, {"newdj":data,"itemid":row.itemid,"batchno":row.batchno,"costprice":row.costprice},
                            function (req) {
                                //成功时的回调方法
                                var result = eval('(' + req + ')');
                                $.messager.alert('提示',result.msg ,'info');
                                $('#tt').datagrid('reload');
                            });
                }
            });

        }else{
            $.messager.alert('提示','请先选品种再设置！',"info");
        }
    }
</script>