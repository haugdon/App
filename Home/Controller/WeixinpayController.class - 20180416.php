<?php
/*
+------------------------------------------------------+
| 设计开发：tzb	Tel:13795563112	邮箱：278199132@qq.com	   |
+------------------------------------------------------+
*/

namespace Home\Controller;

use Think\Controller;

class WeixinpayController extends CommonController {
    //初始化
    public function _initialize() {
        //获取来源地址
        //$URL['PHP_SELF'] = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);   //当前页面名称
        //$URL['DOMAIN'] = $_SERVER['SERVER_NAME'];  //域名(主机名)
        //$URL['QUERY_STRING'] = $_SERVER['QUERY_STRING'];   //URL 参数
        //$URL['URI'] = $URL['PHP_SELF'].($URL['QUERY_STRING'] ? "?".$URL['QUERY_STRING'] : "");
        //$this->fromurl = "http://".$URL['DOMAIN'].$URL['PHP_SELF'].($URL['QUERY_STRING'] ? "_".$URL['QUERY_STRING'] : ""); //完整URL地址
    }

    public function index() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //使用jsapi接口
        $jsApi = new \JsApi_pub();
        //=========步骤1：网页授权获取用户openid============
        $user_id = session('userid');
        $useraccount = session('users');
        //获取openid
        $access_token = session("access_token");
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=" . $access_token;
        $postdata = json_encode(array("userid" => $useraccount));
        $getduserinfo = send_post($url, urldecode($postdata));
        $r = json_decode($getduserinfo);
        $openid = $r->openid;

        //订单检测
        $M = new \Think\Model();
        $order_id = I('order_id', '');
        $order_billno = I('order_billno', '');
        $this->assign("order_billno", $order_billno);
        $this->assign("billid", $order_id);
        $order_info = $M->query("select 1 from t_sal_order where fid='" . $order_id . "'");
        if (!$order_info) {
            $errinfo = '该订单不存在';
            $this->assign("errinfo", $errinfo);
            $this->assign("billfid", $order_id);
            $this->display("Weixinpay/fail");
            exit();
        }
        //检查订单的状态
        $order_info = $M->query("select dbo.Jf_getorderstatus(" . $order_id . ") stat ");
        foreach ($order_info as $row) {
            $order_stat = $row["stat"];
        }
        if ("待付款" != $order_stat) {
            //echo '该订单状态不是待付款，请不要重复付款，当前状态：'.$order_stat;
            $errinfo = '该订单状态不是待付款，请不要重复付款，当前状态：' . $order_stat;
            $this->assign("errinfo", $errinfo);
            $this->assign("billfid", $order_id);
            $this->display("Weixinpay/fail");
            exit();
        }
        //$total_fee = 1;//金额
        $zfje = I('total_fee', 0.00);
        $total_fee = I('total_fee', 0.00) * 100;//金额
        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid", $openid);//商品描述
        $unifiedOrder->setParameter("body", '雪宝订单号:' . $order_billno);//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = $order_billno;//\WxPayConf_pub::APPID.$timeStamp;
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
        $unifiedOrder->setParameter("total_fee", $total_fee);//总金额
        $unifiedOrder->setParameter("notify_url", \WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        if (!$prepay_id) {
            $errinfo = '获取预付单据ID出错：原因是该单据已经支付或其它原因！';
            $this->assign("errinfo", $errinfo);
            $this->assign("billfid", $order_id);
            $this->display("Weixinpay/fail");
            exit();
        }
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $this->assign("total_fee", $zfje);
        $this->display();
    }

    //JSAPI支付通知
    public function notify() {
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //使用通用通知接口
        $notify = new \Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL");//返回状态码
            $notify->setReturnParameter("return_msg", "签名失败");//返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        //以log文件形式记录回调信息
        //         $log_ = new Log_();
        //  $log_name= __ROOT__."/Public/Weixin/notify_url.log";//log文件路径

        // log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

        if ($notify->checkSign() == TRUE) {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //   log_result($log_name,"【通信出错】:\n".$xml."\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //  log_result($log_name,"【业务出错】:\n".$xml."\n");
            } else {
                //订单号
                $order_id = $notify->data['out_trade_no'];
                //微信交易号
                $transaction_id = $notify->data['transaction_id'];

                //openid
                $openid = $notify->data['openid'];

                //交易金额，单位分
                $zfje = $notify->data['total_fee'];
                $je = $zfje / 100;
                //交易完成时间
                $finish_time = $notify->data['time_end'];
                $finish_time = date('Y-m-d H:i:s', strtotime($finish_time));
                //交易成功写入支付记录
                //写入结算记录 记录订单的余额抵扣方式、支付方式
                $M = new \Think\Model();
                $order_info = $M->query("select fid from t_sal_order where fbillno='" . $order_id . "'");
                foreach ($order_info as $row) {
                    $FID = $row["fid"];
                }
                $jg = $M->execute("exec Jp_order_zfupdate " . $FID . ",2," . $je . ""); //更新微信支付结果
                //20171026
                // $list=$M->query("select a.fbillno from T_AR_RECEIVEBILL a,T_AR_RECEIVEBILLENTRY b where a.fid=b.fid and b.FSALEORDERNO='".$order_id."'");
                //foreach($list as $row)
                // {
                //    $skdno=$row["fbillno"];
                // }
                $res_save = Api_SKD_Save($order_id, 1, $je);
                if ($res_save == "f") {
                    $api_msg = "你好，你的订单支付已成功，但是系统在调用API保存收款时遇到问题，该订单需要联系雪宝工作人员进行线下处理！";
                } else {
                    $skdno = $res_save[0]->Number;

                    //利用Api提交、审核收款单,收款单审核成功后，再审核销售订单20171026
                    $shjg = Api_SKD_Audit($skdno);
                    $api_msg = "";
                    if ($shjg == "t") {
                        //利用Api提交和审核订单
                        $sal_shjg = Api_SalOrder_Audit($order_id);
                        if ($sal_shjg == "f") {
                            $api_msg = "你好，你的订单支付已成功，但是系统在销售订单审核时遇到问题，该订单需要联系雪宝工作人员进行线下处理！";
                        }
                    } else {
                        $api_msg = "你好，你的订单支付已成功，但是系统在收款审核时遇到问题，该订单需要联系雪宝工作人员进行线下处理！";
                    }
                }
                $this->assign("api_msg", $api_msg);

                $this->display("Weixinpay/success");
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【支付成功】:\n".$xml."\n");
            }

            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }

    //扫码微信支付模式一
    public function native_pay() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //设置静态链接
        $nativeLink = new \NativeLink_pub();

        //设置静态链接参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //time_stamp已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $product_id = \WxPayConf_pub::APPID . "static";//自定义商品id
        $nativeLink->setParameter("product_id", $product_id);//商品id
        //获取链接
        $product_url = $nativeLink->getUrl();
        //使用短链接转换接口
        $shortUrl = new \ShortUrl_pub();
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $shortUrl->setParameter("long_url", $product_url);//URL链接
        //获取短链接
        $codeUrl = $shortUrl->getShortUrl();
        $this->assign('product_url', $product_url);
        $this->assign('codeUrl', $codeUrl);
        $this->display();
    }

    //扫码支付通知
    public function todoPost() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //以log文件形式记录回调信息，用于调试
        $log_name = __ROOT__ . "/Public/Weixin/native_call.log";
        //使用native通知接口
        $nativeCall = new \NativeCall_pub();

        //接收微信请求
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        log_result($log_name, "【接收到的native通知】:\n" . $xml . "\n");
        $nativeCall->saveData($xml);

        if ($nativeCall->checkSign() == FALSE) {
            $nativeCall->setReturnParameter("return_code", "FAIL");//返回状态码
            $nativeCall->setReturnParameter("return_msg", "签名失败");//返回信息
        } else {
            //提取product_id
            $product_id = $nativeCall->getProductId();

            //使用统一支付接口
            $unifiedOrder = new \UnifiedOrder_pub();

            //根据不同的$product_id设定对应的下单参数，此处只举例一种
            switch ($product_id) {

                case \WxPayConf_pub::APPID . "static"://与native_call_qrcode.php中的静态链接二维码对应
                    //设置统一支付接口参数
                    //设置必填参数
                    //appid已填,商户无需重复填写
                    //mch_id已填,商户无需重复填写
                    //noncestr已填,商户无需重复填写
                    //spbill_create_ip已填,商户无需重复填写
                    //sign已填,商户无需重复填写
                    $unifiedOrder->setParameter("body", "贡献一分钱");//商品描述
                    //自定义订单号，此处仅作举例
                    $timeStamp = time();
                    $out_trade_no = \WxPayConf_pub::APPID . $timeStamp;
                    $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号             $unifiedOrder->setParameter("product_id","$product_id");//商品ID
                    $unifiedOrder->setParameter("total_fee", "1");//总金额
                    $unifiedOrder->setParameter("notify_url", \WxPayConf_pub::NOTIFY_URL);//通知地址
                    $unifiedOrder->setParameter("trade_type", "NATIVE");//交易类型
                    $unifiedOrder->setParameter("product_id", $product_id);//用户标识
                    //非必填参数，商户可根据实际情况选填
                    //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
                    //$unifiedOrder->setParameter("device_info","XXXX");//设备号
                    //$unifiedOrder->setParameter("attach","XXXX");//附加数据
                    //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
                    //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
                    //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
                    //$unifiedOrder->setParameter("openid","XXXX");//用户标识

                    //获取prepay_id
                    $prepay_id = $unifiedOrder->getPrepayId();
                    //设置返回码
                    //设置必填参数
                    //appid已填,商户无需重复填写
                    //mch_id已填,商户无需重复填写
                    //noncestr已填,商户无需重复填写
                    //sign已填,商户无需重复填写
                    $nativeCall->setReturnParameter("return_code", "SUCCESS");//返回状态码
                    $nativeCall->setReturnParameter("result_code", "SUCCESS");//业务结果
                    $nativeCall->setReturnParameter("prepay_id", $prepay_id);//预支付ID

                    break;
                default:
                    //设置返回码
                    //设置必填参数
                    //appid已填,商户无需重复填写
                    //mch_id已填,商户无需重复填写
                    //noncestr已填,商户无需重复填写
                    //sign已填,商户无需重复填写
                    $nativeCall->setReturnParameter("return_code", "SUCCESS");//返回状态码
                    $nativeCall->setReturnParameter("result_code", "FAIL");//业务结果
                    $nativeCall->setReturnParameter("err_code_des", "此商品无效");//业务结果
                    break;
            }

        }

        //将结果返回微信
        $returnXml = $nativeCall->returnXml();
        log_result($log_name, "【返回微信的native响应】:\n" . $returnXml . "\n");

        echo $returnXml;
    }

    //微信扫码支付 模式2
    public function native_pays() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("body", "贡献一分钱");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = \WxPayConf_pub::APPID . $timeStamp;
        $unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
        $unifiedOrder->setParameter("total_fee", "1");//总金额
        $unifiedOrder->setParameter("notify_url", \WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type", "NATIVE");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        //获取统一支付接口结果
        $unifiedOrderResult = $unifiedOrder->getResult();

        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL") {
            //商户自行增加处理流程
            echo "通信出错：" . $unifiedOrderResult['return_msg'] . "<br>";
        } elseif ($unifiedOrderResult["result_code"] == "FAIL") {
            //商户自行增加处理流程
            echo "错误代码：" . $unifiedOrderResult['err_code'] . "<br>";
            echo "错误代码描述：" . $unifiedOrderResult['err_code_des'] . "<br>";
        } elseif ($unifiedOrderResult["code_url"] != NULL) {
            //从统一支付接口获取到code_url
            $code_url = $unifiedOrderResult["code_url"];
            //商户自行增加处理流程
            //......
        }
        $this->assign('out_trade_no', $out_trade_no);
        $this->assign('code_url', $code_url);
        $this->assign('unifiedOrderResult', $unifiedOrderResult);

        $this->display();
    }

    //刷卡支付
    public function micropay() {
        Vendor('Wxpay.WxPayMicropayHelper.WxPayMicropayHelper');
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = \WxPayConf_micropay::APPID . $timeStamp;

        //获取用户一维码
        if (isset($_POST["auth_code"])) {
            $auth_code = $_POST["auth_code"];

            //使用被扫支付接口
            $micropayCall = new \MicropayCall();

            //设置被扫支付接口参数
            //设置必填参数
            //appid已填,商户无需重复填写
            //mch_id已填,商户无需重复填写
            //noncestr已填,商户无需重复填写
            //spbill_create_ip已填,商户无需重复填写
            //sign已填,商户无需重复填写
            $micropayCall->setParameter("body", "贡献一分钱");//商品描述
            $micropayCall->setParameter("out_trade_no", "$out_trade_no");//商户订单号
            $micropayCall->setParameter("total_fee", "1");//总金额
            $micropayCall->setParameter("auth_code", "$auth_code");//交易类型
            //非必填参数，商户可根据实际情况选填
            //$micropayCall->setParameter("sub_mch_id","XXXX");//子商户号
            //$micropayCall->setParameter("device_info","XXXX");//设备号
            //$micropayCall->setParameter("attach","XXXX");//附加数据
            //$micropayCall->setParameter("time_start","XXXX");//交易起始时间
            //$micropayCall->setParameter("time_expire","XXXX");//交易结束时间
            //$micropayCall->setParameter("goods_tag","XXXX");//商品标记
            //$micropayCall->setParameter("openid","XXXX");//用户标识
            //$micropayCall->setParameter("product_id","XXXX");//商品ID

            //提交订单
            $micropayCallResult = $micropayCall->getResult();

            //商户根据实际情况设置相应的处理流程,此处仅作举例
            if ($micropayCallResult["return_code"] == "FAIL") {
                echo "通信出错：" . $micropayCallResult['return_msg'] . "<br>";
            } elseif ($micropayCallResult["result_code"] == "FAIL") {
                echo "出错" . "<br>";
                echo "错误代码：" . $micropayCallResult['err_code'] . "<br>";
                echo "错误代码描述：" . $micropayCallResult['err_code_des'] . "<br>";
            } else {
                echo "用户标识：" . $micropayCallResult['openid'] . "<br>";
                echo "是否关注公众账号：" . $micropayCallResult['is_subscribe'] . "<br>";
                echo "交易类型：" . $micropayCallResult['trade_type'] . "<br>";
                echo "付款银行：" . $micropayCallResult['bank_type'] . "<br>";
                echo "总金额：" . $micropayCallResult['total_fee'] . "<br>";
                echo "现金券金额：" . $micropayCallResult['coupon_fee'] . "<br>";
                echo "货币种类：" . $micropayCallResult['fee_type'] . "<br>";
                echo "微信支付订单号：" . $micropayCallResult['transaction_id'] . "<br>";
                echo "商户订单号：" . $micropayCallResult['out_trade_no'] . "<br>";
                echo "商家数据包：" . $micropayCallResult['attach'] . "<br>";
                echo "支付完成时间：" . $micropayCallResult['time_end'] . "<br>";
            }
        } else {
            $this->assign('out_trade_no', $out_trade_no);
            $this->display();
        }
    }

    //发送现金红包
    public function sendRedpack() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //调用请求接口基类
        $Redpack = new \Redpack_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            //$reduct_uri = WEB_HOST."/index.php/Home/WxCashRedPack/sendRedpack";
            $url = $Redpack->createOauthUrlForCode($this->fromurl);
            Header("Location: $url");
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $Redpack->setCode($code);
            $openid = $Redpack->getOpenId();
        }


        //商户订单号
        $Redpack->setParameter('mch_billno', \WxPayConf_pub::APPID . "static");
        //提供方名称
        $Redpack->setParameter('nick_name', "江苏七八九");
        //商户名称
        $Redpack->setParameter('send_name', "江苏七八九");
        //用户openid
        //         $Redpack->setParameter('re_openid', $parameterValue);
        //付款金额
        $Redpack->setParameter('total_amount', 100);
        //最小红包金额
        $Redpack->setParameter('min_value', 100);
        //最大红包金额
        $Redpack->setParameter('max_value', 100);
        //红包发放总人数
        $Redpack->setParameter('total_num', 1);
        //红包祝福语
        $Redpack->setParameter('wishing', "现金红包教程祝大家写代码快乐");
        //活动名称
        $Redpack->setParameter('act_name', "现金红包教程");
        //备注
        $Redpack->setParameter('remark', "现金红包教程祝大家写代码快乐");
        //以下是非必填项目
        //子商户号
        //         $Redpack->setParameter('sub_mch_id', $parameterValue);
        //        //商户logo的url
        //         $Redpack->setParameter('logo_imgurl', $parameterValue);
        //         //分享文案
        //         $Redpack->setParameter('share_content', $parameterValue);
        //         //分享链接
        //         $Redpack->setParameter('share_url', $parameterValue);
        //         //分享的图片
        //         $Redpack->setParameter('share_imgurl', $parameterValue);


        $result = $Redpack->sendRedpack();

        dump($result);
    }

    //发送裂变红包
    public function sendRedpacks() {
        //全局引入微信支付类
        Vendor('Wxpay.WxPayPubHelper.WxPayPubHelper');
        //调用请求接口基类
        $Redpack = new \Groupredpack_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            //$reduct_uri = WEB_HOST."/index.php/Home/WxGroupRedPack/sendRedpack";
            $url = $Redpack->createOauthUrlForCode($this->fromurl);
            Header("Location: $url");
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $Redpack->setCode($code);
            $openid = $Redpack->getOpenId();
        }
        //商户订单号
        $timeStamp = time();
        $Redpack->setParameter('mch_billno', \WxPayConf_pub::APPID . $timeStamp);
        //商户名称
        $Redpack->setParameter('send_name', "gaoyl101");
        //接受红包的种子用户
        //$Redpack->setParameter('re_openid', $parameterValue);
        //付款金额
        $Redpack->setParameter('total_amount', 300);
        //红包发放总人数
        $Redpack->setParameter('total_num', 3);
        $Redpack->setParameter('amt_type', 'ALL_RAND');
        //红包祝福语
        $Redpack->setParameter('wishing', "现金红包教程祝大家写代码快乐");
        //活动名称
        $Redpack->setParameter('act_name', "现金红包教程");
        //备注
        $Redpack->setParameter('remark', "现金红包教程祝大家写代码快乐");
        //以下是非必填项目
        //子商户号
        //         $Redpack->setParameter('sub_mch_id', $parameterValue);
        //        //商户logo的url
        //         $Redpack->setParameter('amt_list', '200|100|100');


        $result = $Redpack->sendRedpack();

        dump($result);
    }

    public function payok() {
        $billno = I("get.billno", "");
        $zfje = I("get.zfje", 0.00);
        $M = new \Think\Model();
        $FID = I("get.billid", 0);
        //  $list=$M->execute("exec Jp_order_zfupdate " . $FID . ",2," . $zfje . ""); //更新微信支付结果
        //  if($list){
        $this->assign("order_billno", $billno);
        $this->assign("total_fee", $zfje);
        $this->assign("zftime", date("Y-m-d"));
        $this->assign("billid", $FID);
        $this->display("Weixinpay/success");
        // }else{
        //		echo $billno."ID".$FID."je:".$zfje;
        //}

    }
}