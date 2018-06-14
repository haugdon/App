<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品信息管理</title>
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
            width:80px;
        }
    </style>

</head>

<body class="easyui-layout" style="border: none;padding:0px">

<div  data-options="region:'north'" style="height:30px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 2px;padding-right: 100px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-setting'"  id="btn_itemtype">项目类别</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="newItem()">新增</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtItem()">修改</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid" style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/item/getitemlist',
				method: 'get',
				fitColumns: true,
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
            <th data-options="field:'typename',width:60,align:'left'">类别</th>
            <th data-options="field:'number',width:60,align:'left'">编码</th>
            <th data-options="field:'barcode',width:80,align:'left'">条码</th>
            <th data-options="field:'name',width:120,align:'left'" >名称</th>
            <th data-options="field:'model',width:80,align:'right'">规格型号</th>
            <th data-options="field:'unit',width:80,align:'center'">计量单位</th>
            <th data-options="field:'pricecost',width:80,align:'center'">成本价</th>
            <th data-options="field:'price',width:80,align:'center'">预售价</th>
            <th data-options="field:'iskc',width:80,align:'center',formatter:formatIskc">是否存货</th>
            <th data-options="field:'sccj',width:80,align:'center'">生产厂商</th>
            <th data-options="field:'isdiscount',width:80,align:'center',formatter:formatIskc">允许折扣</th>
            <th data-options="field:'isintegral',width:80,align:'center',formatter:formatIskc">允许积分</th>
            <th data-options="field:'remark',width:80,align:'center'">备注</th>
            <th data-options="field:'modifier',width:80,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:80,align:'center'">最后修改时间</th>
            <th data-options="field:'itemid',width:50,align:'center',formatter:formatDelete">操作</th>
        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:560px;height:430px;padding:1px 2px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle">项目信息编辑</div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>类别:</label>
            <input class="easyui-combobox" name="typename" id="typename" data-options="valueField:'typeid',textField:'typename',url:'/index.php/Home/item/gettypes' " required="true">
            </input>
        </div>
        <div class="fitem">
            <label>编号:</label>
            <input name="number" class="easyui-textbox"  required="true" isautotab="true">
        </div>
        <div class="fitem">
            <label>条码:</label>
            <input name="barcode" class="easyui-textbox"  isautotab="true">
        </div>
        <div class="fitem">
            <label>名称:</label>
            <input  name="name" class="easyui-textbox" required="true" style="width:360px"  isautotab="true">
        </div>
        <div class="fitem">
            <label>规格型号:</label>
            <input  name="model" class="easyui-textbox"   isautotab="true">
        </div>
        <div class="fitem">
            <label>计量单位:</label>
            <input class="easyui-combobox" name="unit" id="unit" data-options="valueField:'unitname',textField:'unitname',url:'/index.php/Home/item/getunits' " required="true" isautotab="true">
        </div>
        <div class="fitem">
            <label>成本价:</label>
            <input id="pricecost" name="pricecost" class="easyui-numberbox"   isautotab="true" required="true" data-options="precision:4">
        </div>
        <div class="fitem">
            <label>预售价:</label>
            <input  name="price" class="easyui-numberbox"   isautotab="true" required="true" data-options="precision:4">
        </div>
        <div class="fitem">
            <label>是否存货:</label>
            <select class="easyui-combobox" name="iskc" id="iskc">
                <option value="1" selected="selected">是</option>
                <option value="0">否</option>
            </select>
        </div>
        <div class="fitem">
            <label>允许折扣:</label>
            <select class="easyui-combobox" name="isdiscount" id="isdiscount">
                <option value="1" selected="selected">是</option>
                <option value="0">否</option>
            </select>
        </div>
        <div class="fitem">
            <label>允许积分:</label>
            <select class="easyui-combobox" name="isintegral" id="isintegral">
                <option value="1" selected="selected">是</option>
                <option value="0">否</option>
            </select>
        </div>
        <div class="fitem">
            <label>生产厂商:</label>
            <input  name="sccj" class="easyui-textbox"  isautotab="true" >
			&nbsp;&nbsp;
			<label>备注:</label>
            <input name="remark" class="easyui-textbox" isautotab="true">
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveItem()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>


<div id="tb" style="padding:3px">
    类别：<input class="easyui-combobox" name="typenames" id="typenames" data-options="valueField:'typeid',textField:'typename',url:'/index.php/Home/item/gettypes' " >
    <input id="searname" class="easyui-textbox" data-options="prompt:'输入编号/名称/拼音码 查询...'" style="width:200px;height:22px">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()">查询</a>


</div>
    </div>
</body>
</html>
<script>

    function formatIskc(value,row,index){
        if (value==0){
            return '否';
        } else {
            return '是';
        }
    }
    function formatDelete(value,row,index){
        return "<a href='javascript:void(0)' onclick='delItem("+row.itemid+")' > 删除 </a>";
    }
    function delItem(itemid)
    {
       Showbo.Msg.confirm("您确实要删除吗？", function(btn) {
            if (btn=="yes") {
                var url = "/index.php/Home/item/delItem";
                $.get(url, {"itemid": itemid},
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
            typenames: $('#typenames').combobox('getValue'),
            searchname: $('#searname').textbox('getValue')
        });
    }
    function newItem(){
        $('#dlg').dialog('open').dialog('setTitle','新增项目信息');
        $('#fm').form('clear');
        $('#iskc').combobox('setValue', 1);
        $('#isdiscount').combobox('setValue', 1);
        $('#pricecost').textbox('setValue',0);
        $('#isintegral').combobox('setValue',1);
         url = '/index.php/Home/Item/saveItem';
    }
    function edtItem(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            if(row.typename=="充值"){
                Showbo.Msg.alert("充值为系统默认固定项目不允许修改");
                return false;
            }
            $('#dlg').dialog('open').dialog('setTitle', '项目信息修改');
            $('#fm').form('clear');

            $("#fm").form("load", row);
            $('#typename').combobox('setValue', row.typeid);
            $('#iskc').combobox('setValue', row.iskc);
            url = '/index.php/Home/Item/saveItem?itemid='+row.itemid;
        } else{
           Showbo.Msg.alert("请选中记录后再点我");
        }
    }

    function saveItem(){
        $('#fm').form('submit',{
            url: url,
            onSubmit: function(param){
              //  param.aid=<?php echo ($aid); ?>;
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
            //Export
        $("#btnexport").click(function() {
            var typenames=$('#typenames').combobox('getValue');
            var searchname=$('#searname').textbox('getValue');
            var url='/index.php/Home/Item/items_export?typename='+typenames+'&searchname='+searchname;
            location.href=url;
        });
        $('[isautotab]').each(function (index) {
            $(this).keydown(function (event) {
                if (event.keyCode == 13) {
                    $('[isautotab]:eq(' + (index + 1) + ')').focus();
                }
            });
        });

        $("#btn_itemtype").click(function() {
            var url='/index.php/Home/Item/showitemtype';
            location.href=url;
        });

    });
</script>