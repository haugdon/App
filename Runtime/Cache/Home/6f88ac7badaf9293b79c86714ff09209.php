<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>通知公告信息</title>
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
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="newNotice()">发布通知</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="edtNotice()">修改</a>
</div>

<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid" style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/Notice/getnoticelist',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:10,
				toolbar:'#tb',
				fit:true
			">
        <thead>
        <tr>
            
            <th data-options="field:'title',width:80,align:'center'" >标题</th>
            <th data-options="field:'content',width:80,align:'center'">内容</th>
            <th data-options="field:'fbrq',width:80,align:'center'">发布日期</th>
            <th data-options="field:'fbr',width:80,align:'center'">发布人</th>
            <th data-options="field:'id',width:50,align:'center',formatter:formatDelete">操作</th>
        </tr>
        </thead>
    </table>




<div id="dlg" class="easyui-dialog" style="width:500px;height:400px;padding:10px 20px"
     closed="true" buttons="#dlg-buttons">
    <div class="ftitle">公告信息编辑</div>
    <form id="fm" method="post">
        <div class="fitem">
            <label>标题:</label>
            <input  name="title" class="easyui-textbox" required="true" style="width:260px"  isautotab="true">
        </div>
        <div class="fitem">
        <label>内容</label>
            <input name="content" class="easyui-textbox" data-options="multiline:true" isautotab="true" style="width:300px;height:200px">
        </div>

    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveNotice()">保存</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>


<div id="tb" style="padding:3px">
 <div id="cc" class="easyui-calendar"></div>
 发布日期：<input id="billdate" name="billdate" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">
            至 <input id="billdate2" name="billdate2" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()">查询</a>


</div></div>
</body>
</html>
<script type="text/javascript">
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
    });
function formatDelete(value,row,index){
        return "<a href='javascript:void(0)' onclick='delNotice("+row.id+")' > 删除 </a>";
    }
    function delNotice(id)
    {  Showbo.Msg.confirm("您确实要删除吗？", function (btn) {
            if (btn=="yes") {
                var url = "/index.php/Home/notice/delnotice";
                $.get(url, {"id": id},
                        function (req) {
                            //成功时的回调方法
                          var result = eval('(' + req + ')');
                        //   Showbo.msg.alert(result.msg);
                           $('#tt').datagrid('reload');
                        });
						}
                    
        });
    }
</script>
<script type="text/javascript">
    function doSearch(){
        $('#tt').datagrid('load',{
            billdate: $('#billdate').datebox('getValue'),
			billdate2: $('#billdate2').datebox('getValue')
        });
    }
    function newNotice(){
        $('#dlg').dialog('open').dialog('setTitle','新增公告信息');
        $('#fm').form('clear');
         url = '/index.php/Home/notice/saveNotice';
    }
    function edtNotice(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            $('#dlg').dialog('open').dialog('setTitle', '公告信息修改');
            $('#fm').form('clear');

            $("#fm").form("load", row);

            url = '/index.php/Home/notice/saveNotice?id='+row.id;
        } else{
            Showbo.Msg.alert("请选中记录后再点我");
        }
    }

    function saveNotice(){
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
        $('[isautotab]').each(function (index) {
            $(this).keydown(function (event) {
                if (event.keyCode == 13) {
                    $('[isautotab]:eq(' + (index + 1) + ')').focus();
                }
            });
        });

    });
</script>