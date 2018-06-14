<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>收费项目类别信息</title>
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
            padding:10px 30px;
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
    </style>

</head>

<body class="easyui-layout" style="border: none;padding:0px">

<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="newItemtype()">新增</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtItemtype()">修改</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-back'" id="btnback" name="btnback">返回</a>
</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid" style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/item/getitemtypelist',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:20,

				fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'typename',width:60,align:'center'">类别名称</th>
            <th data-options="field:'typeid',width:50,align:'center',formatter:formatDelete">操作</th>
        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:400px;height:230px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle">收费项目类别信息编辑</div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>类别名称:</label>
            <input name="typename" class="easyui-textbox"  required="true" isautotab="true">
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveItemtype()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>

</div>

</body>
</html>
<script>
    function formatDelete(value,row,index){
        return "<a href='javascript:void(0)' onclick='delItemtype("+row.typeid+")' > 删除 </a>";
    }
    function delItemtype(typeid)
    {
        Showbo.Msg.confirm("您确实要删除该类别吗？删除后将会影响统计查询功能", function (btn) {
            if (btn=="yes") {

                var url = "/index.php/Home/Item/delItemtype";
                $.get(url, {"typeid": typeid},
                        function (req) {
                            //成功时的回调方法
                            var result = eval('(' + req + ')');
                            Showbo.Msg.alert(result.msg);
                            $('#tt').datagrid('reload');	// reload the user data
                        });
                    }
        });
    }

</script>
<script type="text/javascript">
    function doSearch(){
       $('#tt').datagrid('load',{

        });
    }
    function newItemtype(){
        $('#dlg').dialog('open').dialog('setTitle','新增收费类别信息');
        $('#fm').form('clear');
        url = '/index.php/Home/item/saveItemtype';
    }
    function edtItemtype(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            if(row.typename=="充值"){
                Showbo.Msg.alert("充值为系统默认固定项目不允许修改");
                return false;
            }
            $('#dlg').dialog('open').dialog('setTitle', '收费类别信息修改');
            $('#fm').form('clear');
            $("#fm").form("load", row);
            url = '/index.php/Home/item/saveItemtype?typeid='+row.typeid;
        } else{
            Showbo.Msg.alert("请选中记录后再点我");
        }
    }

    function saveItemtype(){
        $('#fm').form('submit',{
            url: url,
            onSubmit: function(param){
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
        $('[isautotab]').each(function (index) {
            $(this).keydown(function (event) {
                if (event.keyCode == 13) {
                    $('[isautotab]:eq(' + (index + 1) + ')').focus();
                }
            });
        });

        $("#btnback").click(function() {
            var url='/index.php/Home/item/';
            location.href=url;
        });

    });
</script>