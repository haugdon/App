<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>客户档案信息</title>
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
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="newCustomer()">新增</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtCustomer()">修改</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid" style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/customer/getcustomerlist',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:30,
				toolbar:'#tb',
				fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'number',width:60,align:'center'">卡号</th>
            <th data-options="field:'name',width:80,align:'center'" >名称</th>
            <th data-options="field:'gender',width:40,align:'center'">性别</th>
            <th data-options="field:'idno',width:70,align:'center'">身份证号</th>
            <th data-options="field:'tel',width:80,align:'center'">联系电话</th>
            <th data-options="field:'addr',width:80,align:'center'">联系地址</th>
            <th data-options="field:'usermoney',width:60,align:'center'">余额</th>
            <th data-options="field:'modifier',width:80,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:80,align:'center'">最后修改时间</th>
            <th data-options="field:'customerid',width:50,align:'center',formatter:formatDelete">操作</th>
        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:500px;height:400px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle">客户信息编辑</div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>编号:</label>
            <input name="number" class="easyui-textbox"  required="true" isautotab="true">
        </div>
        <div class="fitem">
            <label>名称:</label>
            <input  name="name" class="easyui-textbox" required="true" style="width:260px"  isautotab="true">
        </div>
        <div class="fitem">
            <label>性别:</label>
            <select class="easyui-combobox" name="gender" id="gender">
                <option value="女" selected="selected">女</option>
                <option value="男">男</option>
            </select>
        </div>
        <div class="fitem">
            <label>身份证号:</label>
            <input  name="idno" class="easyui-numberbox"   isautotab="true" data-options="precision:0">
        </div>
        <div class="fitem">
            <label>联系电话:</label>
            <input  name="tel" class="easyui-textbox"  isautotab="true" >
        </div>
        <div class="fitem">
            <label>联系地址</label>
            <input name="addr" class="easyui-textbox" isautotab="true"  required="true" style="width:260px"  >
        </div>
        <div class="fitem">
            <label>生日</label>
            <input name="birthday" class="easyui-textbox" isautotab="true">
        </div>
        <div class="fitem">
        <label>备注</label>
            <input name="remark" class="easyui-textbox" isautotab="true">
        </div>

    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveCustomer()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>


<div id="tb" style="padding:3px">
       <input id="searname" class="easyui-textbox" data-options="prompt:'输入卡号/名称/拼音码 查询...'" style="width:200px;height:22px">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()">查询</a>
</div>

    </div>
</body>
</html>
<script>

    function formatDelete(value,row,index){
        return "<a href='javascript:void(0)' onclick='delCustomer("+row.customerid+")' > 删除 </a>";
    }
    function delCustomer(customerid)
    {
        Showbo.Msg.confirm("您确实要删除吗？", function (btn) {
            if (btn=="yes") {

                var url = "/index.php/Home/customer/delCustomer";
                $.get(url, {"customerid": customerid},
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
            searchname: $('#searname').textbox('getValue')
        });
    }
    function newCustomer(){
        $('#dlg').dialog('open').dialog('setTitle','新增客户信息');
        $('#fm').form('clear');
        $('#gender').combobox('setValue', '女');
         url = '/index.php/Home/customer/saveCustomer';
    }
    function edtCustomer(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            $('#dlg').dialog('open').dialog('setTitle', '客户信息修改');
            $('#fm').form('clear');

            $("#fm").form("load", row);
            $('#typename').combobox('setValue', row.typeid);
            url = '/index.php/Home/customer/saveCustomer?customerid='+row.customerid;
        } else{
            Showbo.Msg.alert("请选中记录后再点我");
        }
    }

    function saveCustomer(){
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

    function edtDeposit(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
        $('#dlg-cz').dialog('open').dialog('setTitle','客户充值');
        $('#fmcz').form('clear');
        $('#curuser').html(row.name);
        url = '/index.php/Home/customer/saveDeposit?cusid='+row.customerid;}
        else{
            Showbo.Msg.alert("请选中客户后再点我");
        }
    }
    //保存客户充值
    function saveCz(){
        $('#fmcz').form('submit',{
            url: url,
            onSubmit: function(param){
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if (result.msg){
                    Showbo.Msg.alert(result.msg);
                } else {
                    $('#dlg-cz').dialog('close');		// close the dialog
                    $('#tt').datagrid('reload');	// reload the user data
                }
            }
        });
    }
    function edtIntegral(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            $('#dlgjf').dialog('open').dialog('setTitle','客户积分变动');
            $('#fmjf ').form('clear');
            $('#curuserjf').html(row.name);
            url = '/index.php/Home/customer/saveIntegral?cusid='+row.customerid;}
        else{
            Showbo.Msg.alert("请选中客户后再点我");
        }
    }
    //保存客户积分变动
    function saveJfbd(){
        $('#fmjf').form('submit',{
            url: url,
            onSubmit: function(param){
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if (result.msg){
                    Showbo.Msg.alert(result.msg);
                } else {
                    $('#dlgjf').dialog('close');		// close the dialog
                    $('#tt').datagrid('reload');	// reload the user data
                }
            }
        });
    }

    $(function() {
        //calcPresent
        $("#usermoney").textbox({
            onChange:function(n,o){
                //alert(n);
                var url="/index.php/Home/customer/calcPresent";
                $.get(url,{usermoney:n},function(data){
                   if(data){
                       var result = eval('('+data+')');
                       $("#presentmoney").textbox('setValue',result.data);
                   }else{
                       $("#presentmoney").textbox('setValue',"0");
                   }
                });
            }
        });
                //Export
        $("#btnexport").click(function() {
            var searchname=$('#searname').textbox('getValue');
            var url='/index.php/Home/Customer/customer_export?searchname='+searchname;
            location.href=url;
        });
        $('[isautotab]').each(function (index) {
            $(this).keydown(function (event) {
                if (event.keyCode == 13) {
                    $('[isautotab]:eq(' + (index + 1) + ')').focus();
                }
            });
        });

    });
</script>