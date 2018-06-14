<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/Public/jqueryeasyui/themes/icon.css">


    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/jqueryeasyui/locale/easyui-lang-zh_CN.js"></script>
    <script type="text/javascript" src="/Public/artDialog/artDialog.js?skin=default"></script>
    <script type="text/javascript" src="/Public/artDialog/plugins/iframeTools.source.js"></script>


    <link rel="stylesheet" type="text/css" href="/Public/autop/js/autocomplete/jquery.autocomplete.css" />
    <link href="/Public/autop/css/style.css" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/thickbox-compressed.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/item_pur.js'></script>
    <script type='text/javascript' src='/Public/autop/js/autocomplete/jquery.autocomplete_cus.js' charset="GBK"></script>
    <script type='text/javascript' src='/Public/autop/js/customer_cus.js'></script>

<script>

        $(function () {
            itemsDropDownList("item", "/index.php/Home/billinfo/getItemlist_pur",0,10,"itemid");
            customersDropDownList("keys", "/index.php/Home/billinfo/getCustomerlist", 0, 10, "cusid");
        });

</script>
</head>
<body>
<input  id="keys" type="text" name="sc"/>
<input id="cusid" type="text">

<input  id="item" type="text" name="sc"/>
<input id="itemid" type="text">
</body>

</html>