<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-09-21
 * Time: 13:15
 */

namespace Home\Controller;

use \Think\Controller;

class ShyController extends CommonController {
    public function index() {

        $M = new \Think\Model();
        $list = $M->query("exec Jp_get_sfaudit_param");
        foreach ($list as $row) {
            $sfaudit = $row['param'];
        }
        $this->assign("sfaudit", $sfaudit);
        $this->showqiandanlist();
        if ($sfaudit != "否") {
            $this->showunauditorder();
        }
        $this->showdaisonghuolist();
        $this->showoverlist();
        $this->display();
    }

    /**
     * 获取当前可抢订单列表
     */
    public function showqiandanlist() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }

        $ChildM = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist_shyqiangdan " . $shyid . ",0,'A'");
        foreach ($list as $n => $val) {
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("qdorderlist", $list);
    }

    /**
     * 获取当前已抢单待送货单据
     */
    public function showdaisonghuolist() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }

        $ChildM = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist_shy_dsh " . $shyid . ",0,'A'");
        foreach ($list as $n => $val) {
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("songhuoorderlist", $list);
    }

    /**
     * 获取当前已送货完成订单
     */
    public function showoverlist() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $ChildM = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist_shy_over " . $shyid . ",0,'A'");
        foreach ($list as $n => $val) {
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("overorderlist", $list);
    }

    /**
     * 获取当前待审核订单(抢单)
     */
    public function showunauditorder() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $ChildM = new \Think\Model();
        $list = $M->query("exec Jp_getorderlist_shy " . $shyid . ",0,'A'");
        foreach ($list as $n => $val) {
            $list[$n]['childList'] = $ChildM->query("exec Jp_getorderlist_detail " . $val["fid"] . " ");
        }
        $this->assign("orderlist", $list);
    }

    public function showxuandan() {
        $defrq = date('Y-m-d');
        $this->assign("defrq", $defrq);
        $custid = session("custid");
        //查询所关联的客户
        $M = new \Think\Model();
        $list = $M->query("select fname from t_bd_customer_l where fcustid=" . $custid . "");
        foreach ($list as $row) {
            $shyname = $row["fname"];
        }
        $list = $M->query("exec Jp_getshy_cust '" . $shyname . "'");
        $this->assign("khlist", $list);

        $this->display("shy/search");
    }

    /**
     * 查询可选订单
     */
    public function searchorder() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $rq1 = I('post.rq1', date('Y-m-d'));
        $rq2 = I('post.rq2', date('Y-m-d'));
        $khid = I('post.khid', 0);
        $list = $M->query("exec Jp_getsaleorder_shy_weixin " . $shyid . ",'" . $rq1 . "','" . $rq2 . "'," . $khid . "");
        $this->assign("list", $list);
        $this->display("shy/search_list");
    }

    /**
     * 计算周转箱需求
     */
    public function calcboxbill() {
        $sel_id = I('post.checkbox', '');
        $custid = session("custid");
        $count = count($sel_id);
        if ($count == 0) {
            echo json_encode(array("msg" => urldecode("当前购物车没有内容！！")));
            exit();
        }
        $chkentryid = "";
        for ($i = 0; $i < $count; $i++) {
            $chkentryid .= $sel_id[$i] . ",";
        }
        $chkentryid = rtrim($chkentryid, ",");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid,b.fname from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
            $shyname = $r["fname"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        if ($shyname == null) {
            $shyname = '';
        }
        $list = $M->query("exec Jp_calc_shy_orderzzx_weixin " . $shyid . ",'" . $shyname . "','" . $chkentryid . "'");
        $this->assign("list", $list);
        $this->assign("checkedentry", $chkentryid);
        $this->display("Shy/search_detail");

    }

    /**
     * 保存周转箱瓶订单
     */
    public function saveorder() {
        $custid = session("custid");
        $userid = session("userid");
        $billdate = date('Y-m-d');
        $checkedentry = I("post.checkedentry", "0"); //分录体ID
        $materialid = I('post.boxid');

        $count = count($materialid);
        if ($checkedentry == "" || empty($materialid[0])) {
            echo "没有任何事务可以保存！点击<a href='../Shy' >返回</a>. ";
            exit();
        }
        $total_amount = 0;
        $dj = I('post.price');
        for ($i = 0; $i < $count; $i++) //判断是否金额大于0
        {
            $total_amount = $total_amount + $dj[$i];
        }
        if ($total_amount > 0) //如果金额大于0，则跳转到结算支付页面
        {
            $M = new \Think\Model();
            $userid = session("userid");
            $qty = I('post.useqty');
            $boxmid = I('post.boxmaterialid');
            $randid = rand(1000, 9999);
            for ($i = 0; $i < $count; $i++) //判断是否金额大于0
            {
                $sql = "exec Jp_setBasket_shy " . $materialid[$i] . "," . $qty[$i] . "," . $userid . ",0," . $dj[$i] . "," . $randid . "," . $boxmid[$i] . " ";
                $res = $M->execute($sql);
            }
            if ($res) {
                $sql = "exec Jp_getorder_sn " . $randid . ",'" . $checkedentry . "'"; //把原单ID写进临时表，并查询出序列传送到结算页面
                $rs = $M->query($sql);
                foreach ($rs as $rr) {
                    $url = "../Checkout?isbox=1&randid=" . $randid . "&zj=1&sel_goods=" . $rr["fid"];
                }
            }
            //echo $url;
            header('Location:' . $url);
            exit();
        }

        $sql = "exec Jp_set_SalOrder " . $userid . ",0," . $custid . ",'" . $billdate . "',0";
        $M = new \Think\Model();
        //查询出送货员ID
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        $toplist = $M->query($sql);
        foreach ($toplist as $row) {
            $FID = $row["fid"];
            $custjhdd_id = $row["custjhdd_id"];
            $custaddress = $row["custaddress"];
        }

        $boxmaterialid = I('post.boxmaterialid');
        $useqty = I('post.useqty');
        $price = I('post.price');
        //保存单据体
        $seq = 1;
        for ($i = 0; $i < $count; $i++) {
            $sql = "exec Jp_set_SalOrderEntry " . $FID . ",'" . $billdate . "'," . $seq . "," . $materialid[$i] . "," . $useqty[$i] . "," . $price[$i] . ",0," . $custid . "," . $custjhdd_id . ",'" . $custaddress . "'," . $boxmaterialid[$i] . "";
            $rs = $M->execute($sql);
            $seq++;
        }
        //更新单据财务信息表
        $rs = $M->execute("exec Jp_set_SalOrderCWINFO " . $FID . ",'" . $checkedentry . "'");
        $M->execute("exec Jp_setOrder_shy_update " . $shyid . "," . $FID . "");//更新单据的送货员信息
        $M->execute("exec Jp_setOrder_shy_audit " . $FID . "");//送货员的单据更新为审核状态
        $M->execute("exec Jp_set_zzxorder_source " . $FID . ",'" . $checkedentry . "'"); //写入临时表
        if ($rs) {
            $this->display("shy/saveok");
        }
    }

    /**
     * 订单审核
     */
    public function auditorder() {
        $FID = I('fid', 0);
        $custid = session("custid");
        $M = new \Think\Model();
        $userid = session("userid");
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $res = $M->execute("exec Jp_auditsalorder " . $FID . "," . $shyid . "," . $userid . "");
        if ($res) {
            echo json_encode(array("msg" => urldecode("审核成功！")));
        } else {
            echo json_encode(array("msg" => urldecode("审核失败！")));
        }
    }

    /**
     * 抢单
     */
    public function qiangdan() {
        $fid = I("fid", 0);
        $custid = session("custid");
        $M = new \Think\Model();
        $userid = session("userid");
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        if ($shyid == null) {
            $shyid = 0;
        }
        $r = $M->execute("exec Jp_setOrder_shy_update " . $shyid . "," . $fid . "");
        if ($r) {
            echo json_encode(array("msg" => urldecode("抢单成功！")));
        } else {
            echo json_encode(array("msg" => urldecode("抢单失败！")));
        }
    }

    /**
     * 每日 汇总
     */
    public function gethuizong() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        $d1 = I("d1", date("Y-m-d"));
        $d2 = I("d2", date("Y-m-d"));
        $list = $M->query("exec Jp_getshu_goods_huizong " . $shyid . ",'" . $d1 . "','" . $d2 . "'");
        $this->assign("hzlist", $list);
    }

    /**
     * 一键抢单
     */
    public function getfullqiandan() {
        $custid = session("custid");
        $M = new \Think\Model();
        $mlist = $M->query("select b.fid from t_bd_customer_l a,t_hr_empinfo_l b where a.fname=b.fname and a.fcustid=" . $custid . "");
        foreach ($mlist as $r) {
            $shyid = $r["fid"];
        }
        $list = $M->query("exec Jp_Full_shyqiangdan " . $shyid . "");
        foreach ($list as $row) {
            $count = $row["counts"];
            //echo json_encode(array("msg"=>urldecode("成功抢到：".$row["counts"]."单")));
        }
        $this->success("成功抢到：" . $count . " 单", '/Home/Shy');
    }

    /**
     * 显示每日 汇总
     */
    public function showdayhz() {
        $this->gethuizong();
        $this->display("Shy/dayhz");
    }

}
