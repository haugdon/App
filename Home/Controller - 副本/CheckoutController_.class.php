<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-09-07
 * Time: 9:53
 */

namespace Home\Controller;

use Think\Controller;

class CheckoutController extends CommonController {
    public function index() {
        $this->getcusaddr();
        $this->getcxyh();
        $this->getbasket();

        $this->getCustbalance();
        $h = date('H', time());
        if ($h < 9) {
            $def_shtime = date("Y-m-d");
        } else {
            $def_shtime = date("Y-m-d", strtotime("+1 day"));
        }
        $this->assign("def_shtime", $def_shtime);
        $this->getfanlirule();
        $this->getweixinzfparam();
        $this->display();
    }

    /**
     * 获取支付方式 显示
     */
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
        $qtyhdkshow = $xml['F_PAEZ_Chkqtyhdk'];
        $this->assign("flyeshow", $flyeshow);
        $this->assign("xyyeshow", $xyyeshow);
        $this->assign("yckshow", $yckshow);
        $this->assign("nhdkshow", $nhdkshow);
        $this->assign("wxzfshow", $wxzfshow);
        $this->assign("qtyhdkshow", $qtyhdkshow);
    }

    function xmlToArray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    /**
     * 获取返利使用规则
     */
    public function getfanlirule() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getCust_fanliRule " . $custid . "");
        foreach ($list as $row) {
            $orderamount = $row["forderamount"];
            $rate = $row["fuserate"];
        }
        if (empty($orderamount)) {
            $orderamount = 0;
            $rate = 0;
        }
        $this->assign("orderamount", $orderamount);
        $this->assign("rate", $rate);


    }

    /**
     * 获取收货地址
     */
    public function getcusaddr() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("select a.fcustid,fname,FADDRESS,b.fcontact,a.fentryid,a.fisdefaultconsignee as isdef from T_BD_CUSTLOCATION a left join T_BD_CUSTCONTACT b on a.FTCONTACT=b.FCONTACTID  where a.FCUSTID=" . $custid . " order by a.FISDEFAULTCONSIGNEE desc ");//这里应该是a.FISDEFAULTCONSIGNEE
        $this->assign("addrlist", $list);
        //联系人

        $M = new \Think\Model();
        $clist = $M->query("select fcontact from T_BD_CUSTCONTACT where fcustid=" . $custid . " order by fisdefault desc  ");
        $this->assign("contactlist", $clist);

    }

    /**
     * 获取客户的已选择的购物车内容
     */
    public function getbasket() {
        $buyerid = session("userid");
        $custid = session("custid");
        $M = new \Think\Model();
        $sel_goods = I('get.sel_goods', '');
        //先计算当前所选购物的附加促销、周转箱瓶
        $M->execute("exec Jp_Autocalcbox '" . $s . "'");
        $M->execute("exec Jp_auto_spm_calc " . $buyerid . "," . $custid . ",'" . $sel_goods . "'");
        //查询购物车
        $list = $M->query("exec Jp_getgoodsBasket_checked " . $buyerid . ",'" . $sel_goods . "'");
        $this->assign("list", $list);
    }

    /**
     * 获取当前金额合计
     */
    public function getbasketamountsum() {
        $M = new \Think\Model();
        $buyerid = session("custid");
        $sel_goods = I('get.sel_goods', '');
        $list = $M->query("exec Jp_getgoodsBasket_sum " . $buyerid . ",'" . $sel_goods . "'");
        foreach ($list as $row) {
            $amount = number_format($row["famount"]);
        }
        if ($amount == null) {
            $amount = 0.00;
        }
        echo json_encode(array("amountsum" => $amount));
    }

    /**
     * 获取促销优惠
     */
    public function getcxyh() {
        $M = new \Think\Model();
        $custid = session("custid");

        $list = $M->query("exec  Jp_getgoodsSPM " . $custid . "");
        $this->assign("yhlist", $list);
    }

    /**
     * 订单保存
     */
    public function saveOrder() {
        $creatorId = session("userid");
        $M = new \Think\Model();
        $files = $_FILES["upfile"];
        $sel_goods = I("post.sel_cartgoods");
        $count = count($sel_goods);
        $fhrq = I('post.pickdate');
        // $curdate=date('Y-m-d');
        // if(strtotime($fhrq)<strtotime($curdate))
        // {
        //    echo json_encode(array("msg"=>urldecode("送货时间不能小于当前日期！！")));
        //     exit();
        //  }
        $fhrq2 = I('post.picktime');
        $fhtime = $fhrq . " " . $fhrq2 . ":00";

        if ($count == 0) {
            echo json_encode(array("msg" => urldecode("当前购物车没有内容！！")));
            exit();
        }
        $custid = session("custid");
        //检查订单是否超额
        $ddlist = $M->query("exec Jp_getcust_order_3_check " . $custid . "");
        foreach ($ddlist as $row) {
            $ddcount = $row["fidcount"];
        }
        if ($ddcount > 3000) {
            echo json_encode(array("error" => urldecode("你有超过3条未确认订单，不允许再提交新订单！")));
            exit();
        }

        $pubshid = "";
        for ($i = 0; $i < $count; $i++) {
            $pubshid .= $sel_goods[$i] . ",";
        }
        $pubshid = rtrim($pubshid, ",");
        //检查库存数量是否允许下单
        $kcchkmess = "";
        $kclist = $M->query("exec Jp_savebefore_kcchk '" . $pubshid . "'");
        if ($kclist) {
            foreach ($kclist as $kcrow) {
                $kcchkmess = $kcrow["mess"];
            }
            if ($kcchkmess <> "") {
                echo json_encode(array("error" => $kcchkmess));
                exit();
            }
        }

        //余额抵扣方式
        $yedkfs = I("post.yedk", 0); //0不使用1返利余额2信用余额
        $yedkje = I("post.yedkje", 0);
        //支付方式
        $zffs = I("post.payment", 0);//0为农行代扣
        $zfje = I("post.yinfukuan", 0);//应付款


        $userid = session("userid");
        $list = $M->query("select top 1 F_PAEZ_BASE,F_PAEZ_BASE1 from T_BD_CUSTOMER where fcustid=" . $custid);
        foreach ($list as $row) {
            $shyid = $row["f_paez_base"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $sale_erId = 0;
        $billDate = date('Y-m-d');
        $custjhadd_id = I('post.addrlist', 0);
        //写入单据头
        $Res = $M->query("exec Jp_set_SalOrder " . $creatorId . "," . $shyid . "," . $custid . ",'" . $billDate . "'," . $sale_erId . "," . $custjhadd_id . "");

        if ($Res) {
            foreach ($Res as $row) {
                $FID = $row["fid"];
                $custjhdd_id = $row['custjhdd_id'];
                $custjhdd = $row['custaddress'];
            }
            //上传文件
            if ($files) {
                $newfiletype = explode('.', $files['name']);
                $newfilename = date("YmdHis") . "." . $newfiletype[1];
                if (move_uploaded_file($files['tmp_name'], "./Public/upload/" . $newfilename . "")) {
                    $path = "./Public/upload/" . $newfilename;
                    $M->execute("update t_sal_order set FCUSTUPFILE='" . $path . "' where fid=" . $FID . "");
                };
            }
            //循环写入单据体
            $R = $M->execute("exec Jp_postOrder " . $FID . ",'" . $fhtime . "'," . $custid . "," . $userid . "," . $custjhdd_id . ",'" . $custjhdd . "','" . $pubshid . "'");
            //写入信用余额
            if ($yedkfs == 2) {
                $M->execute("exec Jp_set_xingyongbiao " . $custid . "," . $yedkje . "," . $FID . "");
            }
            //写入返利余额支付
            if ($yedkfs == 1) {
                $M->execute("exec Jp_setflyezf " . $custid . "," . $yedkje . "");
            }
            //写入预存款使用
            if ($yedkfs == 3) {
                $M->execute("exec Jp_setyck_dkjl " . $userid . "," . $custid . "," . $yedkje . "," . $FID . "");
            }
            //写入结算记录 记录订单的余额抵扣方式、支付方式
            $M->execute("exec Jp_setorderjsrecord " . $FID . "," . $yedkfs . "," . $yedkje . "," . $zffs . "," . $zfje . ",0");
            if ($R) {
                echo json_encode(array("succuess" => true, "msg" => urldecode("订单提交成功！"), "FID" => $FID, "fhrq" => $fhtime));

            } else {
                echo json_encode(array("msg" => urldecode("订单提交失败！")));
            }
        }


    }

    public function showtest() {
        download_file("./Public/upload/20160908155028.ico");
        $this->display("Checkout/test");
    }

    /**
     * 显示支付页面
     */
    public function showpayment() {
        $FID = I('get.FID', 0);
        $M = new \Think\Model();
        $M2 = new \Think\Model();
        $list = $M->query("exec Jp_getBillsum " . $FID . "");
        foreach ($list as $row) {
            $this->assign("billno", $row["fbillno"]);
            $this->assign("billfid", $FID);

            $this->assign("amount", $row["fbillallamount"]);
        }
        $this->assign("FID", $FID);
        $this->assign("fhrq", I("get.FHTIME"), date("Y-m-d"));
        $jslist = $M2->query("exec Jp_getorderjsqk " . $FID . "");
        $this->assign("jslist", $jslist);
        $this->display("Checkout/payment");
    }

    /**
     * 加载附加计算出的页面
     */
    public function loadorderfj() {
        $buyerid = session("userid");
        $custid = session("custid");
        $M = new \Think\Model();
        $s = I('sel_goods', '');
        $M->execute("exec Jp_Autocalcbox '" . $s . "'");
        $cxlist = $M->query("exec Jp_getgoodsSPM " . $custid . "");
        foreach ($cxlist as $row) {
            $cxid = $row['fid'];
        }
        if ($cxid == null) {
            $cxid = 0;
        }

        $M->execute("exec Jp_auto_spm_calc " . $buyerid . "," . $custid . ",'" . $s . "'");

        $fjlist = $M->query("exec Jp_getjiesuanfujia '" . $s . "'");
        $this->assign("fjlist", $fjlist);
        $this->display("Checkout/orderfj");
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
     * 离开时清除当前购物车临时数量
     */
    public function unloadclear() {
        $sel_goods = I("sel_goods", '');
        $M = new \Think\Model();
        $r = $M->execute("exec Jp_unloadclear '" . $sel_goods . "'");

    }


}