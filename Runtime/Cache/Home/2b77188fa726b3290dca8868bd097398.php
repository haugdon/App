<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>销售记录欠款管理</title>
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

</head>

<body class="easyui-layout" style="border: none;padding:0px">
<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-reload'" onclick="doSearch()">刷新</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-check'" onclick="showshoukuan()" id="btnaudit" name="btnaudit">收款</a>
    <a href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-table_export'" id="btnexport" name="btnexport">导出</a>
</div>
<div  data-options="region:'center'" style="border: none">

    <!-- 内容 -->

    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/billinfo/getbill_unjiesalelist',
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

            <th data-options="field:'realamount',width:60,align:'center'" >应收金额</th>
            <th data-options="field:'skamount',width:60,align:'center'">已收金额</th>
            <th data-options="field:'zkamount',width:60,align:'center'">欠款</th>
            <th data-options="field:'symoney',width:60,align:'center'" >余额支付</th>
            <th data-options="field:'name',width:70,align:'center'">客户名称</th>
            <th data-options="field:'number',width:70,align:'center'">客户编号</th>
            <th data-options="field:'tel',width:70,align:'center'">联系电话</th>
            <th data-options="field:'addr',width:70,align:'center'">联系地址</th>
            <th data-options="field:'idno',width:70,align:'center'">身份证号</th>
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

           <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="doSearch()" id="btnSearch">查询</a>
            &nbsp;<span id="mess" style="color:red"></span>
        </form>


    </div>
</div>

<div id="dlg" class="easyui-dialog" style="width:400px;height:218px;padding:10px 20px;"
     closed="true" buttons="#dlg-buttons" inline="true" >
    <form id="fmjs" method="post">

        <div class="fitem"><input type="hidden" id="billno"><input type="hidden" id="cusid">
            <label>应收金额：</label>
            <input name="yinshouje" id="yinshouje" class="easyui-numberbox"   required="true" isautotab="true" disabled="true"  data-options="precision:2">
        </div>
        <div class="fitem">
            <label>余额支付：</label>
            <input name="usermoney" id="usermoney" class="easyui-numberbox"   required="true" isautotab="true" data-options="precision:2">&nbsp;<span id="kymoney" style="color:red"></span>
            <input id="kyye" type="hidden" />
        </div>
        <div class="fitem">
            <label>本次收款：</label>
            <input name="skamount" id="skamount" class="easyui-numberbox"   required="true" isautotab="true"  data-options="precision:2">
        </div>
        <div class="fitem" style="display:none">
            <label>欠费金额：</label>
            <input name="syamount" id="syamount" class="easyui-numberbox"   required="true" isautotab="true" data-options="precision:2">
        </div>
        <span id="message" style="color:red"></span>
    </form>
</div>
<div id="dlg-buttons">
    <a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveJiesuan()" id="btnjiesuan">确认</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
</div>

</body>
</html>
<script>
    $(function(){
        customersDropDownList("customer", "/index.php/Home/billinfo/getCustomerlist",0,10,"cusid");
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
            var startdate=$('#billdate').datebox('getValue');
            var enddate=$('#billdate2').datebox('getValue');
            var customerid=$('#cusid').val();
            if($('#cusid').val()=="")
            {customerid=0;}

            var url='/index.php/Home/billinfo/shoukuan_export?startdate='+startdate+'&enddate='+enddate+'&customerid='+customerid;
            location.href=url;
        });

    });





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
        $('#tt').datagrid('load',{
            startdate:$('#billdate').datebox('getValue'),
            enddate:$('#billdate2').datebox('getValue'),
            customerid:selectcusid
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

    function showshoukuan() {
        var row = $("#tt").datagrid("getSelected");
        if (row) {
            var url = '/index.php/Home/billinfo/getjiesuan_shoukuanje';
            var billno = row.billno;
            var customerid=row.customerid;

            $.get(url, {"billno": billno,"customerid":customerid}, function (data) {
                if (data) {
                    var result = eval('(' + data + ')');
                    if (result.data !== "false") {
                        $('#dlg').dialog('open').dialog('setTitle', '收款');
                        $('#kymoney').html('可用余额：' + result.usermoney + '元');
                        $('#billno').val(billno);
                        $('#cusid').val(customerid);
                        $('#kyye').val(result.usermoney);
                        $('#yinshouje').textbox('setValue', result.qkamount); //本次应收欠款
                        if (parseFloat(result.qkamount) <= parseFloat(result.usermoney)) {
                            $('#usermoney').textbox('setValue', result.qkamount); //使用应收金额 10<20
                        } else {
                            if (parseFloat(result.usermoney) > 0) {
                                $('#usermoney').textbox('setValue', result.usermoney); //使用全部的余额
                                var skje = 0.00;
                                skje = parseFloat(result.qkamount) - parseFloat(result.usermoney);//不足部分
                                $('#skamount').textbox('setValue', skje);
                            } else {
                                $('#usermoney').textbox('setValue', 0);
                                $('#skamount').textbox('setValue', result.qkamount);//全部自费
                            }
                        }
                        $('#syamount').textbox('setValue', 0);
                    }
                }
            });
        } else {
            alert('请先选中行再点击');
            return false;
        }
    }

    function saveJiesuan()
    {
        var url="/index.php/Home/billinfo/saveshoukuan";
        var billno=$('#billno').val();

        var realamount=$('#yinshouje').textbox('getValue');
        var skamount=$('#skamount').textbox('getValue');//本次收金额
        var zkamount=$('#syamount').textbox('getValue');//欠费金额
        var employee='';
        var symoney=$('#usermoney').textbox('getValue');//余额支付
        var moneys=$('#kyye').val();//可用余额
        var customerid=$('#cusid').val();

        if(parseFloat(symoney)>parseFloat(moneys)){
            $('#message').html('使用余额大于了客户可用余额，请修改后再保存！');
            return false;
        } else  if((parseFloat(symoney)+parseFloat(skamount))>parseFloat(realamount))
        {
            $('#message').html('收款+余额大于了本次应收金额，请修改后再保存!');
            return false;
        } else {
            $('#message').html('');
        }
        $('#btnjiesuan').linkbutton('disable');
        $.get(url,{"billno":billno,"realamount":realamount,"skamount":skamount,"zkamount":zkamount,"employee":employee,"symoney":symoney,"customerid":customerid},function(data){
            if(data)
            {

                $('#btnjiesuan').linkbutton('enable');
                $('#dlg').dialog('close');		// close the dialog
                $('#tt').datagrid('reload');	// reload the user data
            }
        });

    }



</script>