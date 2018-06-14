<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统参数配置管理</title>
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

</div>
<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/param/getparamlist',
				method: 'get',
				fitColumns: true,
				singleSelect: true,
				rownumbers: true,
				showFooter: true,
				pagination:true,
				pageSize:10,
				fit:true
			">
        <thead>
        <tr>
            <th data-options="field:'paramname',width:80,align:'right'">参数名称</th>
            <th data-options="field:'paramdesc',width:80,align:'right'" >用途</th>
            <th data-options="field:'paramvalue',width:80,align:'right'" editor="{type:'textbox'}">参数值</th>
            <th data-options="field:'id',width:80,align:'center',formatter:formatAction">操作</th>

        </tr>
        </thead>
    </table>




</div>

</body>
</html>

<script type="text/javascript">
    function doSearch(){
       $('#tt').datagrid('load',{

        });
    }
</script>


<script type="text/javascript">
    function formatAction(value,row,index){
        if(value){
            if (row.editing){
                var s = '<a href="#" onclick="saverow(this)">保存</a> ';
                var c = '<a href="#" onclick="cancelrow(this)">取消</a>';
                return s+c;
            } else {
                var e = '<a href="#" onclick="editrow(this)">修改</a> ';
               // var d = '<a href="#" onclick="deleterow(this)">删除</a>';
                return e;//+d;
            }
        }
    }

</script>
<script>
    $.extend($.fn.datagrid.defaults.editors, {
        numberspinner: {
            init: function(container, options){
                var input = $('<input type="text">').appendTo(container);
                return input.numberspinner(options);
            },
            destroy: function(target){
                $(target).numberspinner('destroy');
            },
            getValue: function(target){
                return $(target).numberspinner('getValue');
            },
            setValue: function(target, value){
                $(target).numberspinner('setValue',value);
            },
            resize: function(target, width){
                $(target).numberspinner('resize',width);
            }
        }
    });
    $(function(){
        $('#tt').datagrid({
            onBeforeEdit:function(index,row){
                row.editing = true;
                updateActions(index);
            },
            onAfterEdit:function(index,row){
                row.editing = false;
                updateActions(index);
                var url = "/index.php/Home/param/saveParam";
                $.get(url, {id: row.id,paramvalue:row.paramvalue},
                        function (req) {
                            //成功时的回调方法
                            //  var result = eval('(' + req + ')');
                            $('#tt').datagrid('reload');	// reload the user data
                        });
            },
            onCancelEdit:function(index,row){
                row.editing = false;
                updateActions(index);
            }
        });
    });
    function updateActions(index){
        $('#tt').datagrid('updateRow',{
            index:index,
            row:{}
        });
    }
    function getRowIndex(target){
        var tr = $(target).closest('tr.datagrid-row');
        return parseInt(tr.attr('datagrid-row-index'));
    }
    function editrow(target){
        $('#tt').datagrid('beginEdit', getRowIndex(target));
    }
    function deleterow(target){
        Showbo.Msg.confirm('确实要删除该记录吗？',function(btn){
            if (btn=="yes"){
                var selectedRow = $('#tt').datagrid('getSelected');  //获取选中行
                $.ajax({
                    url:'/index.php/Home/param/delBill?billid='+selectedRow.billid,
                    success:function(){Showbo.Msg.alert('删除成功');}
                });
                $('#tt').datagrid('deleteRow', getRowIndex(target));
            }
        });
    }
    function saverow(target){
        $('#tt').datagrid('endEdit', getRowIndex(target));
        //提交到数据库
    }
    function cancelrow(target){
        $('#tt').datagrid('cancelEdit', getRowIndex(target));
    }
</script>