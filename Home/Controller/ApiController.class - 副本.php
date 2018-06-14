<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-24
 * Time: 8:17
 */

namespace Home\Controller;


use Think\Controller;

class ApiController extends Controller {
    public function test() {
        $billno = 'SKD00103712';
        $res_save = Api_SKD_Save($billno, 0, 2.2);
        //$res_save=Api_SKD_Audit($billno);
        echo $res_save;
        echo $res_save[0]->Id;
    }

    public function index() {
        header("Content-type:text/html;charset=utf-8");
        $cloudUrl = "http://61.1257.143.136:8888/K3Cloud/";
        $cookie_jar = tempnam('./tmp', 'CloudSession');
        //登录
        $logdata = array('593f6fea124c69',//帐套Id
            'user',//用户名
            'abcd1234',//密码
            2052//语言标识
        );
        $post_content = create_postdata($logdata);
        $result = invoke_login($cloudUrl, $post_content, $cookie_jar);
        // echo $result;
        $obj = json_decode($result);
        $Obj = $obj->Context;
        echo "当前用户ID：" . $Obj->UserId;
        echo "当前用户名：" . $Obj->UserName;
        die();
        $OrderNO = 'XSDD201801014945';
        //单据提交和审核
        $submit_data = array('SAL_SaleOrder', array('CreateOrgId' => 100002, 'UseOrgId' => 100002, 'Numbers' => ('' . $OrderNO . '')));
        $post_content = create_postdata($submit_data);
        //提交
        $result = invoke_submit($cloudUrl, $post_content, $cookie_jar);
        echo $result;
        $result = invoke_audit($cloudUrl, $post_content, $cookie_jar);
        echo $result;
    }

}