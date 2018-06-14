<?php
/**
 * Created by scjr.
 * User: Tanzhoubin
 * Date: 2016-09-06
 * Time: 8:13
 */

namespace Home\Controller;


class BasketController extends CommonController {
    public function index() {
        $this->getbasket();
        $this->display();
    }

    /**
     * 获取客户的购物车内容
     */
    public function getbasket() {
        $buyerid = session("userid");
        $publishid = I('publishid', 0);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodsBasket " . $buyerid . "," . $publishid . "");
        $this->assign("list", $list);
    }

    /**
     * 删除购物车
     */
    public function delbasket() {
        $buyerid = session("userid");
        $M = new \Think\Model();
        $publishid = I("get.publishid", 0);
        $res = $M->execute("delete t_cp_goodsbasket where fbuyerid=" . $buyerid . " and fid=" . $publishid . "");
        if ($res) {
            echo json_encode(array("success" => true));
        }
    }


    /**
     * 获取当前金额合计
     */
    public function getbasketamountsum() {
        $M = new \Think\Model();
        $buyerid = session("userid");
        $sel_goods = I('sel_goods', '');
        $count = count($sel_goods);
        $pubshid = "";
        for ($i = 0; $i < $count; $i++) {
            $pubshid .= $sel_goods[$i] . ",";
        }
        $pubshid = rtrim($pubshid, ",");
        $list = $M->query("exec Jp_getgoodsBasket_sum " . $buyerid . ",'" . $pubshid . "'");
        foreach ($list as $row) {
            $amount = number_format($row["famount"], 2);
            $qtysum = number_format($row["fqty"], 0);
        }
        if ($amount == null) {
            $amount = 0.00;
            $qtysum = 0;
        }
        echo json_encode(array("amountsum" => $amount, "qtysum" => $qtysum));
    }

    /**
     * 获取之前订单金额合计
     */
    public function getbeforeamountsum() {
        $M = new \Think\Model();
        $custid = session("custid");
        $amount = I('amountsum', '');
        $fhrq = I('fhrq', '');
        $list = $M->query("exec Jp_getbeforeamountsum '" . $custid . "','" . $amount . "', '" . $fhrq . "'");
        foreach ($list as $row) {
            $flag = $row["flag"];
        }
        echo json_encode(array("flag" => $flag));//有echo的,前面就不能有打印到控制台的
    }

    /**
     * 数量增减
     */
    public function setbaseketqty() {
        $M = new \Think\Model();
        $buyerid = session("userid");
        $publishid = I("publishid", 0);
        $qty = I("qty", 0);
        $res = $M->execute("exec Jp_setbasketqty " . $buyerid . "," . $publishid . "," . $qty . "");
        if ($res) {
            echo json_encode(array("success" => true));
        }
    }

    /**
     * 显示结算页面
     */
    public function showjiesuan() {
        $this->display("basket/jiesuan");
    }

}