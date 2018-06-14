<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>门店销售单位设置</title>
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/icon.css">
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/locale/easyui-lang-zh_CN.js"></script>



    <link type="text/css" rel="stylesheet" href="/Public/alert/showBo.css" />
    <script type="text/javascript" src="/Public/alert/showBo.js"></script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:5px 5px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            color:#666;
            padding:2px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
			text-align:right;
            width:120px;
        }
    </style>

</head>

<body class="easyui-layout" style="border: none;padding:0px">

<div  data-options="region:'north'" style="height:30px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 2px;padding-right: 100px;">

    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtItem()">修改</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid" style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/Itemunitrate/getitemlist',
				method: 'get',
				fitColumns: false,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:20,
				toolbar:'#tb',
				fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'fnumber',width:100,align:'center'">编码</th>
            <th data-options="field:'fbarcode',width:100,align:'center'">条码</th>
            <th data-options="field:'fname',width:220,align:'center'" >名称</th>
            <th data-options="field:'fspecification',width:90,align:'center'">规格型号</th>
            <th data-options="field:'unitname',width:90,align:'center'">公司计量单位</th>
            <th data-options="field:'rate',width:90,align:'center'">包装系数(1:X)</th>
            <th data-options="field:'saleunitname',width:110,align:'center'">门店销售计量单位</th>
            <th data-options="field:'modifier',width:80,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:120,align:'center'">最后修改时间</th>
        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:450px;height:300px;padding:1px 2px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle"></div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>编号：</label>
            <input name="fnumber" id="fnumber" class="easyui-textbox"  >
        </div>
        <div class="fitem">
            <label>条码：</label>
            <input name="fbarcode" class="easyui-textbox"  id="fbarcode" >
        </div>
        <div class="fitem">
            <label>名称：</label>
            <input  name="fname" class="easyui-textbox" id="fname"  >
        </div>
        <div class="fitem">
            <label>规格型号：</label>
            <input  name="fspecification" class="easyui-textbox"  id="fspecification">
        </div>
        <div class="fitem">
            <label>公司计量单位：</label>
            <input class="easyui-textbox" name="unitname" id="unitname">
        </div>
        <div class="fitem">
            <label>包装系数（1:X) ：</label>
            <input id="rate" name="rate" class="easyui-numberbox"   isautotab="true" required="true" data-options="precision:0">
        </div>
        <div class="fitem">
            <label>门店销售计量单位：</label>
            <input class="easyui-combobox" name="saleunitname" id="saleunitname" data-options="valueField:'funitid',textField:'fname',url:'/index.php/Home/itemunitrate/getunit' " required="true">
            </input>
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveItem()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>


<div id="tb" style="padding:3px">
    <input id="searname" name="searname" class="easyui-textbox" data-options="prompt:'输入编号/名称/条码 查询...'" style="width:200px;height:22px">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()">查询</a>


</div>
    </div>
</body>
</html>
<script type="text/javascript">

    function doSearch(){
        $('#tt').datagrid('load',{
            searchname: $('#searname').textbox('getValue')
        });
    }

    function edtItem(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            $('#dlg').dialog('open').dialog('setTitle', '设置物料门店销售计量单位');
            $('#fm').form('clear');
            $("#fm").form("load", row);

            $("#fnumber").textbox({disabled:true });
            $("#fname").textbox({disabled:true });
            $("#fbarcode").textbox({disabled:true });
            $("#fspecification").textbox({disabled:true });
            $("#unitname").textbox({disabled:true });

            url = '/index.php/Home/Itemunitrate/saveunitrate?itemid='+row.itemid;
        } else{
           Showbo.Msg.alert("请选中记录后再点我");
        }
    }

    function saveItem(){
        var unitname=$('#saleunitname').combobox('getText');
        $('#fm').form('submit',{
            url: url,
            onSubmit: function(param){
                param.unitname=unitname;
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if (result.msg){
                    Showbo.Msg.alert(result.msg);
                } else {
                    $('#dlg').dialog('close');		// close the dialog
                    $('#tt').datagrid('reload');	// reload the user data
                }
            }
        });
    }
    $(function() {
        $('#searname').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                doSearch();
            }
        });
        $('#tt').datagrid({
            onDblClickRow:function(rowIndex, field, value){
                edtItem();
            }
        });
            //Export
        $("#btnexport").click(function() {
            var typenames=$('#typenames').combobox('getValue');
            var searchname=$('#searname').textbox('getValue');
            var url='/index.php/Home/Item/items_export?typename='+typenames+'&searchname='+searchname;
            location.href=url;
        });
       });
</script>