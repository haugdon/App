<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController {
    public function index() {
        $this->shychk();
        $this->getindexgoods();
        $this->getindexgoods_cw();
        $this->display();
    }


    /**
     * 验证码
     */
    public function code() {
        ob_end_clean(); //主要加这个函数
        $verify = new \Think\Verify();
        $verify->codeSet = "0123456789";
        $verify->useCurve = false;
        $verify->useNoise = false;
        $verify->useImgBg = false;
        $verify->bg = array(240, 250, 240);
        if (I('get.code_len')) $verify->length = intval(I('get.code_len'));
        if ($verify->length > 8 || $verify->length < 2) $verify->length = 4;
        if (I('get.font_size')) $verify->fontSize = intval(I('get.font_size'));
        if (I('get.width')) $verify->imageW = intval(I('get.width'));
        if ($verify->imageW <= 0) $verify->imageW = 130;
        if (I('get.height')) $verify->imageH = intval(I('get.height'));
        if ($verify->imageH <= 0) $verify->imageH = 50;
        $verify->entry('admin');
    }

    /**
     * 送货员身份检测
     */
    public function shychk() {
        $useraccount = session("users");
        $sql = "select b.fuserid,b.fcustomerid,b.fdefaultorgid,fcustomernumber,b.fcustomermasterid,fisadmin,a.fname  from t_sec_user a,t_cp_userprofile b where a.fuserid=b.fuserid and a.fname='" . $useraccount . "' ";
        //在数据库中后台检测
        $M = new \Think\Model();
        $rst = $M->query($sql);
        if ($rst) {
            foreach ($rst as $row) {
                session('users', $row["fname"]);
                session('userid', $row['fuserid']);
                session('custid', $row['fcustomerid']);
                $M2 = new \Think\Model();
                $rs = $M2->query("select fisshy from t_bd_customer where fcustid=" . $row['fcustomerid'] . "");
                foreach ($rs as $ro) {
                    $typeid = $ro["fisshy"];
                }
                if ($typeid == "1") {
                    $this->redirect('/Home/Shy');
                }
            }
        }
    }

    /**
     * 用户登录
     */
    public function login() {
        if (I('get.dosubmit')) {
            $admin_db = new \Think\Model();
            $username = I('post.username', '', 'trim') ? I('post.username', '', 'trim') : $this->error('用户名不能为空', HTTP_REFERER);
            $password = I('post.password', '', 'trim') ? I('post.password', '', 'trim') : $this->error('密码不能为空', HTTP_REFERER);
            //验证码判断
            //$code = I('post.code', '', 'trim') ? I('post.code', '', 'trim') : $this->error('请输入验证码', HTTP_REFERER);
            //if(!check_verify($code, 'admin')) $this->error('验证码错误！', HTTP_REFERER);
            $uname = str_replace("'", "", $username);
            $upwd = base64_encode($password);
            $sql = "select b.fuserid,b.fcustomerid,b.fdefaultorgid,fcustomernumber,b.fcustomermasterid,fisadmin,a.fname  from t_sec_user a,t_cp_userprofile b where a.fuserid=b.fuserid and a.fname='" . $uname . "' ";
            $rst = $admin_db->query($sql);
            if ($rst) {
                foreach ($rst as $row) {
                    session('users', $row["fname"]);
                    session('userid', $row['fuserid']);
                    session('custid', $row['fcustomerid']);
                    $M = new \Think\Model();
                    $rs = $M->query("select fisshy from t_bd_customer where fcustid=" . $row['fcustomerid'] . "");
                    foreach ($rs as $ro) {
                        $typeid = $ro["fisshy"];
                    }
                    if ($typeid == "1") {
                        $this->success('登录成功', '/Home/Shy');
                    } else {
                        $this->success('登录成功', '/');
                    }
                }
            } else {
                $this->error('用户名或密码错误！' . $uname, HTTP_REFERER);
            }
        } else {
            $this->display('User/login');
        }
    }

    /**
     * 退出登录
     */
    public function logout() {
        session('users', null);
        session('userid', null);
        $this->success('安全退出！', U('Index/login'));
    }

    public function changepwd() {
        $userid = session('userid');
        $oldpassword = base64_encode(I('password'));
        $newpassword = base64_encode(I('newpassword'));
        $M = M("jtusers");
        $where['userid'] = $userid;
        $where['password'] = $oldpassword;
        $count = $M->where($where)->count();
        if ($count > 0) {
            $res = $M->where("userid=" . $userid)->setField("password", $newpassword);
            if (!empty($res)) {
                echo json_encode(array('msg' => '密码修改成功'));
            } else {
                echo json_encode(array('msg' => '密码修改失败'));
            }
        } else {
            echo json_encode(array('msg' => '原密码不正确'));
        }
    }

    public function gettest() {
        $M = new \Think\Model();
        $list = $M->query("select a.fuserid,a.fname,b.fcustid from t_sec_user a,T_BD_CUSTCONTACT b  where a.FLINKOBJECT=FCONTACTID and a.FUSERACCOUNT='zwg' ");
        echo json_encode($list);
    }

    /**
     * 获取首页商品--低温
     */
    function getindexgoods() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getindexgoods " . $custid . "");
        if ($list) {
            $this->assign("indexgoodslist", $list);
        }

    }

    /**
     * 获取首页商品--常温
     */
    function getindexgoods_cw() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getindexgoods_cw " . $custid . "");
        if ($list) {
            $this->assign("indexgoodslist_cw", $list);
        }
    }

    public function getaccess_token() {
        $Corpid = "wx5ed2e3d5aeb3cfd1";
        $secrept = "bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=wx5ed2e3d5aeb3cfd1&corpsecret=bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
        $access_token = file_get_contents($url);
        echo $access_token;
    }

    public function getuseridtooperid() {
        $access_token = I('access_token', '');
        $userid = "season9210";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=" + $access_token;
        //使用方法
        $post_data = array('userid' => 'season9210');
        $openerid = $this->post($url, $post_data);
        echo $openerid;
    }

    public function showweixintest() {

        $this->display("Index/weixintest");
    }


    function post($url, $post_data = '', $timeout = 5) {//curl

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);

        if ($post_data != '') {

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_HEADER, false);

        $file_contents = curl_exec($ch);

        curl_close($ch);

        return $file_contents;

    }

    public function weitest() {
        $REDIRECT_URI = urlencode("weixin.xuebaoruye.com:1000");
        echo $REDIRECT_URI;
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ed2e3d5aeb3cfd1&redirect_uri=weixin.xuebaoruye.com%3A1000&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
        //$url="https://qy.weixin.qq.com/cgi-bin/loginpage?corp_id=wx5ed2e3d5aeb3cfd1&redirect_uri=".$REDIRECT_URI."&usertype=all";
        $cc = $this->post(file_get_contents($url));
        $code = $_GET["code"];
        echo $cc;

    }

    public function showmesssend() {
        $this->display("Index/weixintest");
    }


    public function getcxcontent() {
        $custid = session("custid");
        $materialid = I("materialid", 0);
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getgoodsSPM_Content " . $custid . "," . $materialid . "");
        foreach ($list as $row) {
            $msg = $row["fname"];
        }
        echo json_encode(array("msg" => urldecode($msg)));

    }

}