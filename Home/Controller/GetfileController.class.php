<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-09-09
 * Time: 8:56
 */

namespace Home\Controller;

use \Think\Controller;

class GetfileController extends CommonController {
    public function index() {
        $this->display();
    }

    public function downfile($path) {
        download_file("./Public/upload/20160909084434.jpg");
    }
}