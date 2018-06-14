<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-09-13
 * Time: 15:00
 */

namespace Home\Controller;

use Think\Controller;

class GoodsController extends CommonController {

    public function index() {
        $this->getBasketCount();
        $this->display();
    }

    /**
     * 显示商品分类页面
     */
    public function showspfl() {
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodstype ");
        $this->assign("list", $list);
        $this->display("Goods/spfl");
    }

    /**
     * 显示商品列表
     */
    public function showcategory($rows = 10) {
        $page = I('p', 1);
        $rowscount = 1000;//I('p', 10) * $page;
        $limit = ($page - 1) * $rows + 1;
        $categid = I("categid", 0);
        $custid = session("custid");
        $search = I('keyword', '');
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodslist " . $custid . "," . $categid . ",'" . $search . "'," . $limit . "," . $rowscount . "");
        $this->assign("list", $list);
        $countlist = $M->query("exec Jp_getgoodslist " . $custid . "," . $categid . ",'" . $search . "'");
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
        $this->assign("categid", $categid);
        $this->assign('page', $show);// 赋值分页输出
        $this->display("Goods/category");
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

}