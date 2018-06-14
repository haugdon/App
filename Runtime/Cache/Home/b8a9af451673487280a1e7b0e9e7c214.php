<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>销售出库（收费）单填制</title>
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
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_sale.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/item.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_cus.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/customer_cus.js'></script>
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
<script language="javascript" src="/Public/jqueryeasyui/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<body class="easyui-layout" style="border: none;padding:0px">

<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-check',plain:true" onclick="showjiesuan()" title="将单据提交到库存中" style="border:dashed 1px #ff7500;height:22px;font-weight:bold">提交</a>
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-back',plain:true" onclick="backlist()" title="返回到查询页" id="backlist" >返回</a>
</div>

<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/billinfo/getSalebill?billno=<?php echo ($billno); ?>',
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
            <th data-options="field:'fname',width:80,align:'center',formatter:formatTotal">商品名称</th>
            <th data-options="field:'fspecification',width:60,align:'center'">规格型号</th>
            <th data-options="field:'qty',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}" >数量</th>
            <th data-options="field:'realprice',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}">售价</th>
            <th data-options="field:'discount',width:60,align:'center'"  editor="{type:'numberbox',options:{precision:2}}">折扣率</th>
            <th data-options="field:'discountprice',width:60,align:'center'" >折后售价</th>
            <th data-options="field:'amount',width:60,align:'center'" >金额</th>
            <th data-options="field:'batchno',width:60,align:'center'" >批次号</th>
            <th data-options="field:'remark',width:70,align:'center'" editor="{type:'textbox'}">备注</th>
            <th data-options="field:'modifier',width:70,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:80,align:'center'">最后修改时间</th>
            <th data-options="field:'billid',width:40,align:'center',formatter:formatAction">操作</th>
        </tr>
        </thead>
    </table>





<div id="tb" style="padding:2px;background-color: #e0e8eb">
    <form id="fm" method="post">
    <div id="cc" class="easyui-calendar"></div>
        <span style="font-weight: bold;text-align: center;display: block;font-size:18px;">销售（收费）单</span>
        <h2 style="height: 2px;border: groove 1px"></h2>
        NO：<?php echo ($billno); ?> &nbsp&nbsp;&nbsp;&nbsp;日期：<input id="billdate" name="billdate" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" ><p>
    货位：<input class="easyui-combobox" style="width:70px" name="warehouse" id="warehouse" data-options="valueField:'fcustid',textField:'fname',url:'/index.php/Home/billinfo/getwarehouse' " required="true">
    <input id="custid" name="custid" type="hidden"/>
    客户：<input type="text" id="customer" name="customer"  style="width:180px;" class="editbox">
	身份证号：<input class="easyui-textbox" id="idno" name="idno" style="width:140px">
    联系电话：<input class="easyui-textbox" id="tel" name="tel"   style="width:100px">
    联系地址：<input class="easyui-textbox" id="addr" name="addr" required="true">	
        <h1 style="height: 1px;border: groove 1px"></h1>
    商品：<input type="text" id="item" name="item" data-options="prompt:'输入名称|拼音码查询...'" style="width:130px;height: 18px;" required="true">
    <input type="hidden" id="itemid" name="itemid" value=""/><input type="hidden" id="supid" name="supid" value=""/>
        <input type="hidden" id="costprice" name="costprice" value=""/>
        <input type="hidden" id="unitrate" name="unitrate" value="" />
	库存数量：<input class="easyui-textbox" name="kcqty" id="kcqty" style="width:60px;" value="0" disabled="true">	
    销售数量：<input  name="qty" id="qty" class="easyui-numberbox"   isautotab="true" data-options="precision:2" required="true" style="width:50px;" value="1">
        <span id="unit" style="background-color: #BDD1EE;"></span>  
    售价：<input  name="price" id="price" class="easyui-numberbox"  data-options="precision:2" required="true" style="width:60px;" value="0">

    批次号：<input class="easyui-textbox" name="batchno" id="batchno" style="width:80px;">
    用途说明：<input name="remark" id="remark" class="easyui-textbox" style="width:155px" >
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="addInfo()" id="btnAdd">加入</a>
        &nbsp;<span id="mess" style="color:red"></span>



    </form>


</div>

</div>
<div id="dlg" class="easyui-dialog" style="width:400px;height:238px;padding:10px 20px;"
     closed="true" buttons="#dlg-buttons" inline="true" >
     <form id="fmjs" method="post">
         <div class="fitem">
             <label>应收金额：</label>
             <input name="yinshouje" id="yinshouje" class="easyui-numberbox"   required="true" isautotab="true" disabled="true"  data-options="precision:2">
         </div>
         <div class="fitem">
             <label>优惠金额：</label>
             <input name="yhje" id="yhje" class="easyui-numberbox"   required="true" isautotab="true" data-options="precision:2">
         </div>
         <div class="fitem">
             <label>欠费金额：</label>
             <input name="syamount" id="syamount" class="easyui-numberbox"   required="true" isautotab="true" data-options="precision:2">
         </div>
         <div class="fitem">
             <label>余额支付：</label>
             <input name="usermoney" id="usermoney" class="easyui-numberbox"   required="true" isautotab="true" data-options="precision:2">&nbsp;<span id="kymoney" style="color:red"></span>
             <input id="kyye" type="hidden" />
         </div>
         <div class="fitem">
             <label>本次实收：</label>
             <input name="skamount" id="skamount" class="easyui-numberbox"   required="true" isautotab="true"  data-options="precision:2">
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
    $(document).ready(function(){
	$('#batchno').textbox('textbox').attr('readonly',true);
        $('#yhje').textbox('setValue','0');
        itemsDropDownList("item", "/index.php/Home/billinfo/getItemlist",1,10,"price");
        customersDropDownList("customer", "/index.php/Home/billinfo/getCustomerlist",0,10,"idno");
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
        $("#billdate").datebox("setValue", strDate);
        var isedit='<?php echo ($isedit); ?>';
        if(isedit=='0'||isedit=='')
        {
          $("#backlist").hide();
        }else{
          $("#zk").val("100");
		  $("#custid").val(<?php echo ($customerid); ?>);
		  $("#customer").val('<?php echo ($customername); ?>');
		  $("#idno").textbox('setValue','<?php echo ($idno); ?>');
		  $("#tel").textbox('setValue','<?php echo ($tel); ?>');
		  $("#addr").textbox('setValue','<?php echo ($addr); ?>');
		}
        $('#qty').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
               $('#price').textbox('textbox').focus();
                $('#price').textbox('textbox').select();
            }
        });
        $('#price').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#remark').textbox('textbox').focus();
                $('#remark').textbox('textbox').select();
            }
        });
        $('#batchno').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#remark').textbox('textbox').focus();
            }
        });
        $('#remark').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                addInfo();
            }
        });
        $('#item').keydown(function (e) {
            if (e.keyCode == 13) {
            itemCheck();
             //   setTimeout(itemCheck,"1000");//三秒后执行


            }
        });
        $('#customer').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#idno').textbox('textbox').focus();

            }
        });
        $('#idno').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#tel').textbox('textbox').focus();

            }
        });	
        $('#tel').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#addr').textbox('textbox').focus();

            }
        });	
        $('#addr').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#item').focus();

            }
        });
        $('#yhje').textbox({
            onChange: function(value){
              //  var _trim = $.trim(value);
               // $("#tt1").textbox("setValue", _trim);
                calcskamount();
            }
        });
        $('#syamount').textbox({
            onChange: function(value){
                calcskamount();
            }
        });
        $('#symoney').textbox({
            onChange: function(value){
                calcskamount();
            }
        });
        $('#yhje').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#syamount').textbox('textbox').focus();
            }
        });
        $('#syamount').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#usermoney').textbox('textbox').focus();
            }
        });
        $('#usermoney').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#skamount').textbox('textbox').focus();
            }
        });
        $('#skamount').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                saveJiesuan();
            }
        });

    });
    function itemCheck()
    {
        var barcode=$('#item').val();
        $.get("/index.php/Home/Billinfo/getItemEnter", {"barcode": barcode},
                function (req) {
                    //成功时的回调方法
                    var data = eval('(' + req + ')');
                    if(data.icount==1){
                    $("#itemid").val(data.itemid);
                    $("#unit").html(data.unit);
                    $("#batchno").textbox('setValue',data.batchno);
                    $("#price").textbox('setValue',data.price);
                    $("#kcqty").textbox('setValue',data.kcqty);
                    $('#costprice').val(data.costprice);
                    $('#item').val(data.itemname);
                    addInfo();
                    }
                });
    }
    function formatTotal(value,row,index){
        if(value=="Total"){
            return "合计";}else{
            return value;
        }
    }
    function delBilldetail(billid)
    {
        $.messager.confirm("操作提示", "您确实要删除该行吗？", function (data) {
            if (data) {

                var url = "/index.php/Home/billinfo/delBill";
                $.get(url, {"billid": billid},
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
    function showjiesuan(){
        var url='/index.php/Home/billinfo/getjiesuanje';
        var billno='<?php echo ($billno); ?>';
        $.get(url,{"billno":billno},function(data) {
            if (data) {
                var result = eval('(' + data + ')');
                if (result.data !== "false") {
                    $('#dlg').dialog('open').dialog('setTitle', '提交并更新库存==结算');
                    $('#kymoney').html('可用余额：'+result.usermoney+'元');
                    $('#kyye').val(result.usermoney);
                    $('#yinshouje').textbox('setValue',result.discountamount); //应收金额
                    if(parseFloat(result.discountamount)<=parseFloat(result.usermoney)){
                      $('#usermoney').textbox('setValue',result.discountamount); //使用应收金额 10<20
                        if(parseFloat(result.discountamount)<0)
                        {
                            $('#usermoney').textbox('setValue',0); //使用应收金额 10<20
                            $('#skamount').textbox('setValue',result.discountamount);//
                        }
                    }else{
                        if(parseFloat(result.usermoney)>0){
                      $('#usermoney').textbox('setValue',result.usermoney); //使用全部的余额
                        var skje=0.00;
                        skje=parseFloat(result.discountamount)-parseFloat(result.usermoney);//不足部分
                        $('#skamount').textbox('setValue',skje);
                        }else{
                            $('#usermoney').textbox('setValue',0);
                            $('#skamount').textbox('setValue',result.discountamount);//全部自费
                        }
                    }
                    $('#syamount').textbox('setValue',0);
                }
                $('#yhje').textbox('textbox').focus();
            }
        });
    }

    function addInfo(){
        if($("#customer").val()=="")
        {
            $("#mess").text('请选择客户');
            $("#customer").focus();
            return false;
        }
        if($("#itemid").val()==""||$("item").val()=="")
        {
            $("#item").focus();
            $("#mess").text("请选择收费项目");
            return false;
        }
		if (parseFloat($("#qty").textbox('getValue'))>parseFloat($("#kcqty").textbox('getValue')))
		{
		 $("#qty").textbox('textbox').setfocus;
		 $("#mess").text("出库数量大于可以用库存数量");
		 return false;
		}else{
		 $("#mess").text('');
		}
		

        $('#fm').form('submit',{
            url: '/index.php/Home/billinfo/saveSalebill',
            onSubmit: function(param){
                param.billtype=2;//Sales
                param.billno='<?php echo ($billno); ?>';
                return $(this).form('validate');
            },
            success: function(result){
                var result = eval('('+result+')');
                if (result.msg){
                  //  $.messager.alert("出错了",result.msg);
                    Showbo.Msg.alert(result.msg);
                } else {
                    $('#tt').datagrid('reload');	// reload the user data
                    //clear
                    $("#item").val('');
                    $("#itemid").val('');
                    $("#batchno").val('');
                    $("#qty").textbox('setValue',1);
                    $("#item").focus();
                }
            }
        });
    }
    function calcskamount() //计算实收金额
    {
        var realamount=$('#yinshouje').textbox('getValue');
        var symoney=$('#usermoney').textbox('getValue');//余额支付
        var zkamount=$('#syamount').textbox('getValue');//欠费金额
        var yhje=$('#yhje').textbox('getValue');//优惠金额
        var ssje=parseFloat(realamount)-(parseFloat(symoney)+parseFloat(zkamount)+parseFloat(yhje));//减 余额支付 、欠费金额
        $('#skamount').textbox('setValue',ssje);
    }
    function saveJiesuan()
    {
        var url="/index.php/Home/billinfo/savejiesuan";
        var billno='<?php echo ($billno); ?>';
        var realamount=$('#yinshouje').textbox('getValue');
        var skamount=$('#skamount').textbox('getValue');
        var zkamount=$('#syamount').textbox('getValue');//欠费金额
        var employee='';
        var symoney=$('#usermoney').textbox('getValue');//余额支付
        var moneys=$('#kyye').val();//可用余额
        var customerid=$('#custid').val();
        var yhje=$('#yhje').textbox('getValue');//优惠金额
        var skhj=parseFloat(zkamount)+parseFloat(symoney)+parseFloat(skamount)+parseFloat(yhje);
        if(parseFloat(symoney)>parseFloat(moneys)){
            $('#message').html('使用余额大于了客户可用余额，请修改后再保存！');
            return false;
        } else  if(skhj!=parseFloat(realamount))
        {
            $('#message').html(skhj+'收款+余额+欠费+优惠不等于应收金额，请修改后再保存!');
            return false;
        } else {
            $('#message').html('');
        }
        $('#btnjiesuan').linkbutton('disable');
        $.get(url,{"billno":billno,"realamount":realamount,"skamount":skamount,"zkamount":zkamount,"employee":employee,"symoney":symoney,"customerid":customerid,"yhje":yhje},function(data){
            if(data)
            {
                audit_bill();
            }
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
      //  LODOP.ADD_PRINT_TEXT(70,23,260,39,"<?php echo ($printtitle); ?>");
        LODOP.SET_PRINT_STYLE("FontSize",10);
        LODOP.ADD_PRINT_URL(92,14,"58mm","800",host+"/Home/Print/getbillprint?billno="+billno);
      //  LODOP.SET_PRINT_STYLEA(1,"Stretch",1);//(可变形)扩展缩放模式 
        LODOP.PRINT();
        //LODOP.PREVIEW();
    }
//提交单据
    function audit_bill()
    {
        var url = "/index.php/Home/billinfo/audit_bill";
        var billno='<?php echo ($billno); ?>';
        $.get(url, {"billno": billno},
                function (req) {
                    //成功时的回调方法
                    var result = eval('(' + req + ')');
                  //  $.messager.alert('提示',result.msg);
                 //   Showbo.Msg.alert(result.msg);
                    var isedit='<?php echo ($isedit); ?>';
                    var isprint='<?php echo ($isprint); ?>';
                    if(isprint=="1") {
                        print(billno);
                    }
                    if(isedit==false)
                    {
                        $('#btnjiesuan').linkbutton('enable');
                    window.location.reload();
                    }
                    else
                    {
                        location.href="/index.php/Home/billinfo/salebilllist";
                        $('#btnjiesuan').linkbutton('enable');
                    }

                });
    }
    //返回list
    function backlist()
    {
        location.href="/index.php/Home/billinfo/salebilllist";
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
                    var url = "/index.php/Home/billinfo/salebillupdate";
                    $.get(url, {billid: row.billid,qty:row.qty,price:row.realprice,remark:row.remark,discount:row.discount},
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
                    url:'/index.php/Home/billinfo/delBill?billid='+selectedRow.billid,
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
    $('#tt').datagrid({
        onDblClickRow:function(rowIndex, field, value){
            $('#tt').datagrid('beginEdit', rowIndex);
        }

    });
</script>