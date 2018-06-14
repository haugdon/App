<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>销售出库单序时薄</title>
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
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_cus.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/customer_cus.js'></script>
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
    <script language="javascript" src="/Public/jqueryeasyui/LodopFuncs.js"></script>
    <object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
        <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
    </object>
</head>

<body class="easyui-layout" style="border: none;padding:0px">
<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" id="btn_add" name="btn_add" onclick="addbills()">新增</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'" id="btn_edit" name="btn_edit" onclick="editbills()">修改</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-document-delete'" id="btn_delbill" name="btn_delbill" onclick="delbills()">删除</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-print'" id="btn_print" name="btn_print" onclick="prints()">打印</a>
    <a href="javascript:void(0)" style="display:none" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-check'" onclick="audit_bill()" id="btnaudit" name="btnaudit">提交审核</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
    <a href="javascript:void(0)"  class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-check'" onclick="cancel_audit_bill()" id="btncancelaudit" name="btncancelaudit">撤销审核</a>
</div>
<div  data-options="region:'center'" style="border: none">

    <!-- 内容 -->

    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/billinfo/getbill_salelist',
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
            <th data-options="field:'billno',width:90,align:'center'">单据号</th>
            <th data-options="field:'billdate',width:70,align:'center'">日期</th>
            <th data-options="field:'fname',width:80,align:'center',formatter:formatTotal">商品名称</th>
            <th data-options="field:'fspecification',width:60,align:'center'">规格型号</th>
            <th data-options="field:'qty',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}" >数量</th>
			<th data-options="field:'unit',width:60,align:'center'" >单位</th>
            <th data-options="field:'realprice',width:60,align:'center'">售价</th>
            <th data-options="field:'amount',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}">金额</th>
            <th data-options="field:'batchno',width:60,align:'center'" editor="{type:'textbox'}">批次号</th>
            <th data-options="field:'remark',width:60,align:'center'" editor="{type:'textbox'}">用途备注</th>
            <th data-options="field:'customername',width:70,align:'center'" >客户</th>
			<th data-options="field:'idno',width:122,align:'center'" >身份证</th>
			<th data-options="field:'tel',width:70,align:'center'" >联系电话</th>
			<th data-options="field:'addr',width:70,align:'center'" >联系地址</th>
            <th data-options="field:'warehousename',width:70,align:'center'" >售货点</th>
            <th data-options="field:'modifier',width:70,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:80,align:'center'">最后修改时间</th>

        </tr>
        </thead>
    </table>





    <div id="tb" style="padding:3px;background-color: #e0e8eb">
        <form id="fm" method="post">
            <div id="cc" class="easyui-calendar"></div>
            货位：<input class="easyui-combobox" name="warehouse" style="width: 88px" id="warehouse" data-options="valueField:'fcustid',textField:'fname',url:'/index.php/Home/billinfo/getwarehouse' " required="true">
            日期：<input id="billdate" name="billdate" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">
            至 <input id="billdate2" name="billdate2" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:93px">
            客户：<input type="text" id="customer" name="customer"  style="width:200px;" class="editbox">
            <input type="hidden" id="custid" name="custid" value=""/>

            商品信息：<input type="text" class="editbox" id="item" name="item" data-options="prompt:'输入名称|拼音码查询...'" style="width:200px;" required="true">
            <input type="hidden" id="itemid" name="itemid" value=""/>
            类型：<select class="easyui-combobox" name="state" style="width:90px;" name="billstatus" id="billstatus" >
            <option value="1" checked="checked">已审核单据</option>
                       <option value="0">未审核单据</option>

                    </select>
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
        customersDropDownList("customer", "/index.php/Home/billinfo/getCustomerlist",0,10,"cusid");
        $("#btncancelaudit").linkbutton("disable");
        $("#btncancelaudit").hide();
        $("#btnaudit").linkbutton("disable");
        $("#btn_delbill").linkbutton("disable");
        $("#btn_edit").linkbutton("disable");
        $("#billstatus").combobox({
            onSelect: function (rec) {
              doSearch();
              if($("#billstatus").combobox('getValue')==1){
                  $("#btnaudit").linkbutton("disable");
                  $("#btn_delbill").linkbutton("disable");
                  $("#btn_edit").linkbutton("disable");
                  $("#btncancelaudit").linkbutton("enable");
              }else
              {
                  $("#btnaudit").linkbutton("enable");
                  $("#btn_delbill").linkbutton("enable");
                  $("#btn_edit").linkbutton("enable");
                  $("#btncancelaudit").linkbutton("disable");
              }
            }
        });
        $('#billstatus').combobox('setValue', '1');
        $('#warehouse').combobox({
            onLoadSuccess : function(data) {
                $('#warehouse').combobox('setValue', data[0].fcustid);
            }
        });
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
        $("#billdate").datebox("setValue", strDate);
        $("#billdate2").datebox("setValue", strDate);
        //Export
        $("#btnexport").click(function() {
            var billstatus=$('#billstatus').combobox('getValue');
            var startdate=$('#billdate').datebox('getValue');
            var enddate=$('#billdate2').datebox('getValue');
            var customerid=$('#cusid').val();
            var itemid=$('#itemid').val();
            var url='/index.php/Home/billinfo/salelist_export?billstatus='+billstatus+'&startdate='+startdate+'&enddate='+enddate+'&customerid='+customerid+'&itemid='+itemid;
            location.href=url;
        });

    });

    //Delbill
    function delbills(){
        Showbo.Msg.confirm("确认要删除该单据全部记录吗?",function(btn){
            if(btn=="yes"){
                var row = $("#tt").datagrid("getSelected");
                if(row) {
                    var url = "/index.php/Home/billinfo/delBills";
                    var billno = row.billno;
                    $.get(url, {"billno": billno},
                            function (req) {
                                //成功时的回调方法
                                var result = eval('(' + req + ')');
                                Showbo.Msg.alert(result.msg);
                                $('#tt').datagrid('reload');	// reload the user data
                            });
                }}
        });
    }
    //打印单据
    function print(billno){
        var host="http://"+window.location.host;
        var LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
        LODOP=getLodop();
        LODOP.PRINT_INIT("小票打印");
        LODOP.SET_PRINT_PAGESIZE(3,"58.0mm","3mm","CreateCustomPage");
        LODOP.SET_PRINT_STYLE("FontSize",12);
        LODOP.SET_PRINT_STYLE("Bold",1);
        LODOP.ADD_PRINT_TEXT(30,33,260,39,"成都市龙泉驿区");
        LODOP.ADD_PRINT_TEXT(50,13,260,39,"农业投入品溯源系统");
     //   LODOP.ADD_PRINT_TEXT(70,23,260,39,"<?php echo ($printtitle); ?>");
        LODOP.SET_PRINT_STYLE("FontSize",10);
        LODOP.ADD_PRINT_URL(92,14,"58mm","800",host+"/Home/Print/getbillprint?billno="+billno);
       // LODOP.SET_PRINT_STYLEA(1,"Stretch",1);//(可变形)扩展缩放模式 
        //LODOP.PRINT();
        LODOP.PREVIEW();
    }
    //Delbill
    function prints(){

                var row = $("#tt").datagrid("getSelected");
                if(row) {
                    var billno = row.billno;
                    print(billno);
                }
    }
    function formatTotal(value,row,index){
        if(value=="Total"){
            return "合计";}else{
            return value;
        }
    }


</script>
<script type="text/javascript">

    function doSearch(){
        var selectcusid;
        if($("#customer").val()=="")
        {
            selectcusid=0;
        }else
        {
            selectcusid=$('#custid').val();
        }
        var selectitemid;
        if($("#item").val()=="")
        {
            selectitemid=0;
        }else
        {
            selectitemid=$('#itemid').val();
        }
        $('#tt').datagrid('load',{
            startdate:$('#billdate').datebox('getValue'),
            enddate:$('#billdate2').datebox('getValue'),
            customerid:selectcusid,
            itemid:selectitemid,
            billstatus:$('#billstatus').combobox('getValue')
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

    //提交单据
    function audit_bill()
    {
        Showbo.Msg.confirm('确认审核该单据吗？',function(btn){
            if(btn=="yes"){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
            var url = "/index.php/Home/billinfo/cancel_audit_bill";
            var billno = row.billno;

            $.get(url, {"billno": billno},
                    function (req) {
                        //成功时的回调方法
                        var result = eval('(' + req + ')');
                        Showbo.Msg.alert('提示', result.msg);
                        window.location.reload();
                        //$('#tt').datagrid('reload');	// reload the user data
                    });
        }else{
            Showbo.Msg.alert("请选中记录后再提交审核");
        }}
    });
    }
    //撤销审核
    function cancel_audit_bill()
    {
        Showbo.Msg.confirm('确实要撤销审核该单据吗？',function(btn){
            if(btn=="yes"){
                var row = $("#tt").datagrid("getSelected");
                if(row) {
                    var url = "/index.php/Home/billinfo/cancel_audit_bill";
                    var billno = row.billno;
                    $.get(url, {"billno": billno},
                            function (req) {
                                //成功时的回调方法
                                var result = eval('(' + req + ')');
                                Showbo.Msg.alert('撤销成功', result.msg);
                               // window.location.reload();
                                $('#tt').datagrid('reload');	// reload the user data
                            });
                }else{
                    Showbo.Msg.alert("请选中记录后再撤销审核");
                }}
        });
    }
    //新增单据
    function addbills(){
        var url = "/index.php/Home/billinfo/salebill";
        location.href=url;
      //  art.dialog.open(url, {title: '销售出库（收费）',width:1024,height:500});
    }
    //修改单据
    function editbills(){
        var row = $("#tt").datagrid("getSelected");
        if(row) {
        var url = "/index.php/Home/billinfo/editsalebill?billno="+row.billno;
            location.href=url;
        //art.dialog.open(url, {title: '销售出库（收费）单修改',width:1024,height:500});
        }
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
                var d = '<a href="#" onclick="deleterow(this)">删除</a>';
                return e+d;
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
                var url = "/index.php/Home/billinfo/billupdate";
                $.get(url, {billid: row.billid,qty:row.qty,amount:row.amount,batchno:row.batchno,remark:row.remark},
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
        $.messager.confirm('Confirm','Are you sure?',function(r){
            if (r){
                var selectedRow = $('#tt').datagrid('getSelected');  //获取选中行
                $.ajax({
                    url:'/index.php/Home/billinfo/delBill?billid='+selectedRow.billid,
                    success:function(){alert('删除成功');}
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