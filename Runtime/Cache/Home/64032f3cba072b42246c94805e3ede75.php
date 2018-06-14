<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户信息管理</title>
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
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_kingdee.js' charset="GBK"></script>

    <script type='text/javascript' src='/Public/autop/js/kingdeecustomer.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_kingdee2.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/kingdeecustomer2.js'></script>
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
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="newUser()">新增</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtUser()">修改</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"  data-options="plain:true,iconCls:'icon-edit'" id="btnpwd" name="btnpwd" onclick="getUserpwd()">密码查看</a>
</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/user/getuserlist',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:20,
				pageList:[20,30,40],
				fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'username',width:80,align:'right'">用户名</th>
            <th data-options="field:'usedstatus',width:80,align:'right',formatter:formatStatus" >状态</th>
            <th data-options="field:'remark',width:80,align:'right'">备注</th>
            <th data-options="field:'fname',width:80,align:'right'">Kingdee名称</th>
            <th data-options="field:'userid',width:80,align:'center',formatter:formatDelete">删除</th>

        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:400px;height:300px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle">用户信息编辑</div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>Kingdee关联:</label>
            <input name="kingdeename" type="text" id="kingdeename">
            <input type="hidden" id="custid" name="custid"/>
        </div>
        <div class="fitem">
            <label>用户名:</label>
            <input name="username" class="easyui-textbox"  required="true" id="username">
        </div>
        <div class="fitem">
            <label>密   码:</label>
            <input id="password" name="password" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
        <label>备    注:</label>
            <input name="remark" class="easyui-textbox" id="remark">
        </div>
        <div class="fitem">
            <label>状态</label>
            <select class="easyui-combobox" name="state" id="state">
                <option value="0" selected="selected">正常</option>
                <option value="1">停用</option>
                </select>
        </div>

    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>

<!-- 修改 -->
<div id="dlgedt" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
     closed="true" buttons="#dlg-buttonsedt">
    <div class="ftitle">用户信息编辑</div>
    <form id="fmedt" method="post">
        <div class="fitem">
            <label>Kingdee关联:</label>
            <input name="kingdeename" type="text" id="kingdeename2">
            <input type="hidden" id="custid2" name="custid"/>
        </div>
        <div class="fitem">
            <label>用户名:</label>
            <input name="username" class="easyui-textbox"  required="true" id="username2">
        </div>
        <div class="fitem">
            <label>备注</label>
            <input name="remark" class="easyui-textbox" id="remark2">
        </div>
        <div class="fitem">
            <label>状态</label>
            <select class="easyui-combobox" name="state" id="states">
                <option value="0" selected="selected">正常</option>
                <option value="1">停用</option>
            </select>
        </div>
    </form>
</div>
<div id="dlg-buttonsedt">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="edtsaveUser()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgedt').dialog('close')">取消</a>
</div>
</div>

</body>
</html>
<script>
    $(document).ready(function() {
        kingdeecustomersDropDownList("kingdeename", "/index.php/Home/user/getkingdeeuser", 1, 10, "custid");
        kingdeecustomers2DropDownList("kingdeename2", "/index.php/Home/user/getkingdeeuser", 1, 10, "custid2");
    });
    function formatStatus(value,row,index){
        if (value==0){
            return '正常';
        } else {
            return '停用';
        }
    }
    function formatDelete(value,row,index){
        return "<a href='javascript:void(0)' onclick='delUser("+row.userid+")' > 删除 </a>";
    }
    function delUser(userid)
    {
        Showbo.Msg.confirm("您确实要删除吗？", function (btn) {
            if (btn=="yes") {

                var url = "/index.php/Home/user/delUser";
                $.get(url, {"userid": userid},
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
    function newUser(){

        $('#dlg').dialog('open').dialog('setTitle','新增用户信息');
        $('#fm').form('clear');
        $('#state').combobox('setValue', 0);
        $.get('/index.php/Home/user/create_password',{},
                function (req) {
                    //成功时的回调方法
                    var result = eval('(' + req + ')');
                    $('#password').textbox('setValue',result.data);
                });
        url = '/index.php/Home/user/saveUser';
    }
    function edtUser(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            if(row.username=="admin")
            {
                Showbo.Msg.alert("管理员用户不能修改");
                return;
            }
            $('#dlgedt').dialog('open').dialog('setTitle', '用户信息修改');
            $('#fmedt').form('clear');
           $('#kingdeename2').val(row.fname);
            $('#states').combobox('setValue', row.usedstatus);
            $("#fmedt").form("load", row);
            $("#password").val("");
            url = '/index.php/Home/user/saveUser?userid='+row.userid;
        } else{
            Showbo.Msg.alert("请选中记录后再点我");
        }
    }
    function getUserpwd(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            url = '/index.php/Home/user/getuserpwd?userid='+row.userid;
            $.get(url,{},
                    function (req) {
                        //成功时的回调方法
                        var result = eval('(' + req + ')');
                        alert(result.data);
                    });
        } else{
            Showbo.Msg.alert("请选中记录后再点我");
        }
    }
    function saveUser(){
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
    function edtsaveUser(){
        $('#fmedt').form('submit',{
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
                    $('#dlgedt').dialog('close');		// close the dialog
                    $('#tt').datagrid('reload');	// reload the user data
                }
            }
        });
    }
</script>