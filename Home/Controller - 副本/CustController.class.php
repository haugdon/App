<?php
/**
 * Created by .
 * User: tanzhoubin
 * Date: 2016-09-09
 * Time: 11:26
 */

namespace Home\Controller;

use \Think\Controller;

class CustController extends CommonController {
    public function index() {
        $M = new \Think\Model();
        $cust = $M->query("select fname from t_bd_customer_l where fcustid=" . session("custid"));
        foreach ($cust as $r) {
            $cust_name = $r["fname"];
        }
        $this->assign("cust_name", $cust_name);
        $this->getOrderCount();
        $this->getCustbalance();
        $this->getBasketCount();
        $this->display();
    }

    /**
     * 获取订单情况数量
     */
    public function getOrderCount() {
        $custid = session("custid");
        $M = new \Think\Model();
//        $list = $M->query("exec Jp_getcustOrdersum " . $custid . "");
        $list = $M->query("exec Jp_getcustOrdersum_xb " . $custid . "");//modify by kevin holden 20180129 [修复"我的"反应慢]
        $this->assign("ordercountlist", $list);
    }

    /**
     * 获取供商的账户余额信息
     */
    public function getCustbalance() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustAccount " . $custid . "");
        $this->assign("balancelist", $list);
    }

    /**
     * 显示我的订单列表
     */
    public function showorderlist() {
        $this->getorderlist();
        $this->getorderlist_count();
        $this->display("Cust/order_list");
    }

    /**
     * 显示交易明细
     * add by kevin holden 20180129
     */
    public function showjymx() {
        $this->getjymxlist();
        $this->display("Cust/jymx");
    }

    /**
     * 交易明细列表查询
     * add by kevin holden 20180129
     */
    function getjymxlist() {
        //        $status = I("status", 'dfk');
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getjymxlist " . $custid . "");
        $this->assign("jymxlist", $list);
    }

    /**
     * 订单列表查询
     */
    function getorderlist() {
        $status = I("status", 'dfk');
        $custid = session("custid");
        $M = new \Think\Model();
        $ChildM = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist " . $custid . ",'" . $status . "'");
        foreach ($list as $n => $val) {
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("orderlist", $list);
    }

    /**
     * 订单数查询
     */
    function getorderlist_count() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustOrdersum " . $custid . "");
        $this->assign("orderlistcount", $list);
    }

    /*
     * 取消订单
     */
    public function cancelorder() {
        $fid = I("get.fid", 0);
        $M = new \Think\Model();
        $custid = session("custid");
        $userid = session("userid");
        // $list=$M->query("exec Jp_getcust_neiqin ".$custid."");
        $sql = "select a.fbillno from T_AR_RECEIVEBILL a,T_AR_RECEIVEBILLENTRY b where a.fid=b.fid and b.FSALEORDERID='" . $fid . "'";
        $list = $M->query($sql);
        if ($list) {
            $mess = "该订单已存在收款记录，不能取消，请联系雪宝工作人员";
            echo json_encode(array("msg" => $mess));
            exit();
        }
        $list = $M->query("exec Jp_cancelorder " . $fid . "," . $userid . "");
        foreach ($list as $row) {
            $mess = $row['mess'];
        }
        echo json_encode(array("msg" => $mess));
    }

    /**
     *获取经销商的收货地址信息
     */
    public function getcustaddress() {
        $cust = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getCustAddress " . $cust . "");
        $this->assign("addresslist", $list);
    }

    function xmlToArray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    public function getweixinzfparam() {
        $M = new \Think\Model();
        $list = $M->query("select fparameters from T_BAS_SysParameter where FPARAMETEROBJID='PAEZ_weixinzfgl'");
        foreach ($list as $r) {
            $data = $r["fparameters"];
        }
        $xml = $this->xmlToArray($data);
        $flyeshow = $xml['F_PAEZ_ChkFlye'];
        $yckshow = $xml['F_PAEZ_Chkyck'];
        $xyyeshow = $xml['F_PAEZ_Chkxyye'];
        $nhdkshow = $xml['F_PAEZ_Chknhdk'];
        $wxzfshow = $xml['F_PAEZ_Chkwxzf'];
        //检测客户的微信支付
        $custid = session("custid");
        $list = $M->query("select f_wxyn from t_bd_customer where fcustid=" . $custid . "");
        foreach ($list as $r) {
            if ($r["f_wxyn"] != 1) {
                $wxzfshow = "false";
            } else {
                $wxzfshow = "True";
            }
        }

        $qtyhdkshow = $xml['F_PAEZ_Chkqtyhdk'];
        $this->assign("flyeshow", $flyeshow);
        $this->assign("xyyeshow", $xyyeshow);
        $this->assign("yckshow", $yckshow);
        $this->assign("nhdkshow", $nhdkshow);
        $this->assign("wxzfshow", $wxzfshow);
        $this->assign("qtyhdkshow", $qtyhdkshow);
    }

    /**
     * 显示订单详细情况
     */
    public function showorderdetail() {
        $this->getorderdetaillist();
        $M = new \Think\Model();
        $fid = I('get.billid', 0);
        $list = $M->query("exec Jp_getorder_ysqk " . $fid . "");
        $this->assign("fhlist", $list);
        $this->getorderstar();
        $this->getweixinzfparam();
        $api_msg=ContinueSubmit($fid);//显示前进行一次再提交检测
        $this->assign("api_msg",$api_msg);
        $this->display("Cust/order_detail");

    }



    /**
     * 订单详单查询
     */
    function getorderdetaillist() {
        $fid = I('get.billid', 0);
        $M = new \Think\Model();
        $ChildM = new \Think\Model();
        $shM = new \Think\Model();
        $list = $M->query("exec Jp_getorderdetail " . $fid . "");
        foreach ($list as $n => $val) {
            $statusname = $val["statusname"];
            $shlist = $shM->query("exec Jp_getCustAddress_order " . $val["fcustid"] . "," . $val["shaddrid"] . "");
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("shaddrlist", $shlist);
        $this->assign("statusname", $statusname);
        $this->assign("orderdetail", $list);
        $M2 = new \Think\Model();
        $jslist = $M2->query("exec Jp_getorderjsqk " . $fid . "");
        $this->assign("jslist", $jslist);
    }

    /**
     * 显示收藏夹
     */
    public function showfavorite() {
        $this->getfavorite();
        $this->display("Cust/favorite_list");
    }

    /**
     * 获取收藏夹列表
     */
    function getfavorite($rows = 10) {
        $page = I('p', 1);
        $rowscount = I('p', 10) * $page;
        $limit = ($page - 1) * $rows + 1;
        $userid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustFavorite " . $userid . "," . $limit . "," . $rowscount . "");
        $this->assign("list", $list);
        $countlist = $M->query("exec Jp_getcustFavorite " . $userid . "");
        foreach ($countlist as $row) {
            $count = $row["count"];
        }
        $page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $pagecount = 10;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 ' . I('p', 1) . ' 页/共 %TOTAL_PAGE% 页 ( ' . $pagecount . ' 条/页 共 %TOTAL_ROW% 条)');
        $show = $page->show();
        $this->assign('page', $show);// 赋值分页输出
    }

    /**
     * 删除收藏商品
     */
    public function delFavorite() {
        $userid = session("userid");
        $publishid = I('get.publishid', 0);
        $M = new \Think\Model();
        $res = $M->execute("delete T_CP_FAVORITEGOODS where fpublishid=" . $publishid . " and fbuyerid=" . $userid . "");
        if ($res) {
            echo json_encode(array("msg" => urldecode("删除成功！")));
        }
    }

    /**
     * 显示经销商收货地址信息
     */
    public function showcustaddress() {
        $this->getcustaddressfull();
        $this->display("Cust/address");
    }

    /**
     * 获取经销商收货地址
     */
    function getcustaddressfull() {
        $M = new \Think\Model();
        $custid = session("custid");
        $list = $M->query("exec Jp_getCustAddress " . $custid . ",0");
        $this->assign("list", $list);
    }

    /**
     * 显示个人信息
     */
    public function showprofile() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("select FNAME from T_BD_CUSTOMER_L where fcustid=" . $custid . " ");
        foreach ($list as $row) {
            $custname = $row['fname'];
        }
        $this->assign("custname", $custname);
        $this->getcustaddressfull();
        $this->display("Cust/profile");
    }


    /**
     * 获取购物车数量
     */
    function getBasketCount() {
        $buyerid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustBasket " . $buyerid . "");
        foreach ($list as $row) {
            $this->assign("basketqty", $row['qty']);
        }
    }

    /**
     * 显示方案订货
     */
    public function showfalb() {
        $userid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getScheme " . $userid . "");
        $this->assign("list", $list);
        $this->display("Cust/falb");
    }

    /**
     * 显示方案详细情况
     */
    public function showfadetail() {
        $faid = I('get.faid', 0);
        $famc = I('famc', '');
        $this->assign("famc", $famc);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getSchemeentry " . $faid . "");
        $this->assign("list", $list);
        $this->display("Cust/ddfa");
    }

    /**
     * 抄单购买
     */
    public function copybillbuy() {
        $fid = I('get.fid', 0);
        $userid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_copybill_buy " . $fid . "," . $userid . "");
        foreach ($list as $row) {
            $jg = $row['fid'];
        }
        echo json_encode(array('msg' => $jg));
    }

    /**
     * 检查客户的订单是否超3条未进行出库确认
     */
    public function orderchk() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcust_order_3_check " . $custid . "");
        foreach ($list as $row) {
            $count = $row["fidcount"];
        }
        echo json_encode(array("count" => $count));

    }

    /**
     * 显示确认收货页面
     */
    public function shouhuo() {
        $fid = I("get.fid", 0);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist_detail " . $fid . " ");
        $this->assign("list", $list);
        $this->display("Cust/shouhuo");
    }

    /*
     * 收货确认保存
     */
    public function saveshouhuo() {
        $sel_goods = I("post.sel_cartgoods");
        $count = count($sel_goods);
        $qty = I("post.goods_number");
        $billfid = I("post.billfid");
        $userid = session("userid");
        $curstar = I("get.curstar", 0);
        if (empty($curstar)) {
            $curstar = 0;
        }
        $shmemo = I("post.sh_memo");
        if ($count == 0) {
            echo json_encode(array("msg" => urldecode("当前没有内容可确认！！")));
            exit();
        }
        $M = new \Think\Model();
        for ($i = 0; $i < $count; $i++) {
            $r = $M->execute("exec Jp_setshouhuo " . $billfid . "," . $sel_goods[$i] . "," . $qty[$i] . "," . $userid . ",'" . $shmemo[$i] . "'");
        }
        $M->execute("exec Jp_setorder_star " . $billfid . "," . $curstar . "," . $userid . "");
        $this->showorderlist();

    }

    /**
     * 获取订单评论星级
     */
    public function getorderstar() {
        $billid = I("get.billid", 0);
        $M = new \Think\Model();
        $starlist = $M->query("exec Jp_get_order_star " . $billid . "");
        foreach ($starlist as $row) {
            $star = $row["fstar"];
        }
        $this->assign("star", $star);
    }

    /**
     * 显示密码修改页面
     */
    public function showpassword() {
        $this->display("Cust/password");
    }

    public function zfpwdchange() {
        $oldpwd = base64_encode(I("get.oldpwd", ""));
        $newpwd = base64_encode(I("get.newpwd1", ""));
        //检查原密码是否正确
        $M = new \Think\Model();
        $list = $M->query("select fzfpwd from t_cp_userprofile where fuserid=" . session("userid") . " and fzfpwd='" . $oldpwd . "'");
        if (!$list) {
            echo json_encode(array("msg" => urldecode("原密码不正确！")));
            exit();
        }
        $list = $M->execute("update t_cp_userprofile set fzfpwd='" . $newpwd . "' where fuserid=" . session("userid") . "");
        if ($list) {
            echo json_encode(array("msg" => urldecode("密码修改成功！")));
            exit();
        }
    }
}