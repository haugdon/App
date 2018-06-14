<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>采购入库单填制</title>
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
    <script type='text/javascript' src='/Public/autop/js/item_pur.js'></script>

    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_cus.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/supplier.js'></script>

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

<body class="easyui-layout" style="border: none;padding:0px">

<div  data-options="region:'north'" style="height:40px;;padding-left: 10px;background-color: #E0Ecff;align-content: center;vertical-align: middle;padding-top: 6px;padding-right: 100px;">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-check',plain:true" onclick="audit_bill()" title="将单据提交到库存中" style="border:dashed 1px #ff7500;height:22px;font-weight:bold">提交</a>
</div>


<!-- 内容 -->
<div data-options="region:'center'"   style="border: none;">
    <table id="tt" class="easyui-datagrid"  style="width:100%;height:100%"
           data-options="
				url: '/index.php/Home/billinfo/getbill?billno=<?php echo ($billno); ?>',
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
            <th data-options="field:'name',width:80,align:'center',formatter:formatTotal">商品名称</th>
            <th data-options="field:'model',width:60,align:'center'">规格型号</th>
            <th data-options="field:'qty',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}" >采购数量</th>
            <th data-options="field:'costprice',width:60,align:'center'">采购单价</th>
            <th data-options="field:'amount',width:60,align:'center'" editor="{type:'numberbox',options:{precision:2}}">采购金额</th>
            <th data-options="field:'batchno',width:60,align:'center'" editor="{type:'textbox'}">批次号</th>
            <th data-options="field:'remark',width:70,align:'center'" editor="{type:'textbox'}">备注</th>
            <th data-options="field:'stockname',width:70,align:'center'" >仓库</th>
            <th data-options="field:'modifier',width:70,align:'center'">最后修改人</th>
            <th data-options="field:'modifiertime',width:80,align:'center'">最后修改时间</th>
            <th data-options="field:'billid',width:40,align:'center',formatter:formatAction">操作</th>
        </tr>
        </thead>
    </table>





<div id="tb" style="padding:3px;background-color: #e0e8eb">
    <form id="fm" method="post">
    <div id="cc" class="easyui-calendar"></div>
        <span style="font-weight: bold;text-align: center;display: block;font-size:18px;">采购入库单</span>
        <h2 style="height: 2px;border: groove 1px"></h2>
        NO：<?php echo ($billno); ?> 
    仓库：<input class="easyui-combobox" name="warehouse" id="warehouse" data-options="valueField:'fcustid',textField:'fname',url:'/index.php/Home/billinfo/getwarehouse' " required="true">
    日期：<input id="billdate" name="billdate" class="easyui-datebox" data-options="sharedCalendar:'#cc'" required="true" style="width:95px;">
    供应商：<input type="text" id="supplier" name="supplier"  style="width:220px;" class="editbox">
        <input type="hidden" id="supid" name="supid" value=""/>
        <h1 style="height: 1px;border: groove 1px"></h1>
    采购商品：<input type="text" class="editbox" id="item" name="item" data-options="prompt:'输入名称|拼音码查询...'" style="width:130px;" required="true">
    <input type="hidden" id="itemid" name="itemid" value=""/><input type="hidden" id="realprice" name="realprice" value=""/>
    数量：<input  name="qty" id="qty" class="easyui-numberbox"   isautotab="true" data-options="precision:2" required="true" style="width:60px;" value="1">
        <span id="unit" style="background-color: #BDD1EE;"></span>
    采购单价：<input  name="amount" id="amount" class="easyui-numberbox"   isautotab="true" data-options="precision:2" required="true" style="width:60px;" value="0">
    批次号：<input name="batchno" id="batchno" class="easyui-textbox" required="true" style="width:70px" value="0">
    备注：<input name="remark" id="remark" class="easyui-textbox" style="width:80px">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="addInfo()" id="btnAdd">加入</a>
        &nbsp;<span id="mess" style="color:red"></span>



    </form>


</div>

</div>
</body>
</html>
<script>
    $(function(){
        itemsDropDownList("item", "/index.php/Home/billinfo/getItemlist_pur",1,10,"itemid");
        supplierDropDownList("supplier", "/index.php/Home/billinfo/getSupplierlist",0,10,"supid");
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
        //Supplierlist

        //Itemlist

        $('#qty').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
               $('#amount').textbox('textbox').focus();
                $('#amount').textbox('textbox').select();
            }
        });
        $('#amount').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#batchno').textbox('textbox').focus();
                $('#batchno').textbox('textbox').select();
            }
        });
        $('#batchno').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#remark').textbox('textbox').focus();
            }
        });
        $('#item').keydown(function (e) {
            if (e.keyCode == 13) {
                itemCheck();

            }
        });
        $('#supplier').keydown(function (e) {
            if (e.keyCode == 13) {
                $('#item').focus();
           }
        });
        $('#remark').textbox('textbox').keydown(function (e) {
            if (e.keyCode == 13) {
               addInfo();
            }
        });

    });
    function itemCheck()
    {
        var barcode=$('#item').val();
        $.get("/index.php/Home/Billinfo/getItemPurEnter", {"q": barcode},
                function (req) {
                    //成功时的回调方法
                    var data = eval('(' + req + ')');

                        $("#itemid").val(data.itemid);
                        $("#item").val(data.itemname);
                        $("#mess").html('');
                        $("#unit").html(data.unit);
                        $("#realprice").val(data.price);
                        $('#qty').textbox('textbox').focus();
                        $('#qty').textbox('textbox').select();

                });
    }
    function formatDelete(value,row,index){
        if(value){
        return "<a href='javascript:void(0)' onclick='delCustomer("+row.customerid+")' > 删除 </a>";}
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
         //   typenames: $('#typenames').combobox('getValue'),
        //    searchname: $('#searname').textbox('getValue')
        });
    }


    function addInfo(){
        if($("#supid").val()==""||$("#supplier").val()=="")
        {
            $("#mess").text('请选择供应商');
            $("#supplier").focus();
            return false;
        }
        if($("#itemid").val()==""||$("item").val()=="")
        {
            $("#item").focus();
            $("#mess").text("请选择采购商品");
            return false;
        }
        var itemid=$('#itemid').val();
        var batchno=$('#batchno').textbox('getValue');
        var qty=$('#qty').textbox('getValue');
        if(qty<0)
        {
            alert("采购入库不允许输入负数");
            return false;
        }
        //进行检测



           $('#fm').form('submit', {
                url: '/index.php/Home/billinfo/saveBill',
                onSubmit: function (param) {
                    param.billtype = 1;
                    param.billno = '<?php echo ($billno); ?>';
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.msg) {
                        Showbo.Msg.alert(result.msg);

                    } else {
                        $('#tt').datagrid('reload');	// reload the user data
                        //clear
                        $("#item").val('');
                        $("#itemid").val('');
                        $("#batchno").val('0');
                        $("#item").focus();
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

//提交单据
    function audit_bill()
    {
        var url = "/index.php/Home/billinfo/audit_bill";
        var billno='<?php echo ($billno); ?>';
        $.get(url, {"billno": billno},
                function (req) {
                    //成功时的回调方法
                    var result = eval('(' + req + ')');
                    Showbo.Msg.alert(result.msg);
                    window.location.reload();
                    //$('#tt').datagrid('reload');	// reload the user data
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
</script>