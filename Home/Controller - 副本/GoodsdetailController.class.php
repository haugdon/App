<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-09-02
 * Time: 9:12
 */

namespace Home\Controller;

use Think\Controller;

class GoodsdetailController extends CommonController {
    public function index() {
        $this->getgoodsdetail();
        $this->getgoodsspm();
        $this->getBasketCount();
        $Publishid = I("publishid", 0);
        $this->assign("publishid", $Publishid);
        $this->getisfav();
        $this->display();

    }

    function data_uri($contents, $mime) {
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    //获得头像路径
    public function getdetailpic() {
        $db = new \Think\Model();
        $sql = "select FGOODSPICTURE from T_CP_GOODS_PICTURES WHERE FGOODSPICTURE is not null and FENTRYID='100001' ";
        $res = $db->query($sql);
        foreach ($res as $row) {
            //header("Content-type: image/JPG",true);

        }
    }

    /**
     * 读出商品详细情况
     * @materialid
     */
    public function getgoodsdetail() {
        $custid = session("custid");
        $materialid = I("materialid", 0);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodsdetail " . $custid . "," . $materialid . "");
        $this->assign("goodsdetaillist", $list);
    }

    /**
     * 读出该商品 当前促销信息
     */
    public function getgoodsspm() {
        $custid = session("custid");
        $materialid = I("materialid", 0);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodsSPM " . $custid . " ");
        $this->assign("goodsspmlist", $list);
    }

    /**
     *  加入购物车
     */
    public function addBasket() {
        $M = new \Think\Model();
        $publishid = I('get.publishid', 0);
        $qty = I('get.qty', 0);
        $buyerid = session("userid");
        $isyd = I('get.isyd', 0);
        $ydprice = I('get.ydprice', 0);
        $sql = "exec Jp_setBasket " . $publishid . "," . $qty . "," . $buyerid . "," . $isyd . "," . $ydprice . " ";
        $res = $M->execute($sql);
        if ($res) {
            echo json_encode(array('msg' => urldecode('添加成功！')));
        }
    }

    /**
     * @param $w
     * @param $h
     * @param $px
     * @return string
     */

    function hex2image($w, $h, $px) {
        $dir = 'Public/upload/' . date('ym');//生成目录
        $fname = $dir . '/' . time() . '.jpg';
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, 0xFFFFFF);
        $px = explode(",", $px);
        $i = 0;
        for ($rows = 0; $rows <= $h; $rows++) {
            for ($cols = 0; $cols < $w; $cols++) {         //获得单独象素信息
                $value = $px[$i++];
                //如果不为空象素，进行数据处理
                if ($value != NULL) {
                    //保证其长度为6
                    $hex = $value;
                    while (strlen($hex) < 6) {
                        $hex = "0" . $hex;
                    }
                    //根据16位数据信息分别获得三个颜色值
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    //获得具体颜色值
                    $test = imagecolorallocate($img, $r, $g, $b);
                    //绘制象素点
                    imagesetpixel($img, $cols, $rows, $test);
                }
            }
        }
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $simage = imagecreatefromjpeg("exp.jpg");
        imagecopy($simage, $img, 0, 0, 0, 0, $w, $h);
        imagejpeg($simage, "exp.jpg");
        imagedestroy($simage);
        imagedestroy($img);
        //复制文件开始
        copy("exp.jpg", $fname);
        copy("Public/upload/exp.jpg", "exp.jpg");
        return $fname;
    }

    /**
     * 获取购物车数量
     */
    function getBasketCount() {
        $userid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustBasket " . $userid . "");
        if ($list) {
            $this->assign("basketcount", $list);
        }
    }

    /**
     *  加入收藏夹
     */
    public function addFavorite() {
        $M = new \Think\Model();
        $publishid = I('get.publishid', 0);
        $qty = 1;
        $buyerid = session("userid");
        $sql = "exec Jp_setFavorite " . $publishid . "," . $buyerid . " ";
        $res = $M->execute($sql);
        if ($res) {
            echo json_encode(array('msg' => urldecode('收藏成功！')));
        } else {
            echo json_encode(array('msg' => urldecode('已经收藏过了！')));
        }
    }

    /**
     * 判断是否收藏过
     */
    public function getisfav() {
        $M = new \Think\Model();
        $publishid = I('get.publishid', 0);
        $buyerid = session("userid");
        $sql = "exec Jp_getfavorites " . $buyerid . "," . $publishid . " ";
        $res = $M->query($sql);
        foreach ($res as $row) {
            $ct = $row['ct'];
        }
        $this->assign("isfav", $ct);
    }

}