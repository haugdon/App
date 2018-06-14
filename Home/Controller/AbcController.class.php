<?php
/**
 * Created by tzb.
 * User: tzb
 * Date: 2016-11-04
 * Time: 16:51
 */

namespace Home\Controller;

use \Think\Controller;


class AbcController extends CommonController {//这个文件的编码格式一定要是GBK,否则农行日志会乱码
    /**
     * 显示农行代扣支付页面
     */
    public function index() {
        //收下报文
    }

    public function aa() {
        header('Content-Type:text/html;Charset=utf-8');
        $r = array("success" => true, "msg" => "ok");
        echo $r;
    }

    /**
     * 农行代扣
     */
    public function abcpay_() {
        $order_id = I('order_id', '');
        $order_billno = I('order_billno', '');
        $total_fee = I('total_fee', 0);
        $fkaccount = I('fkaccount', '');
        $fkaccname = I('fkaccname', '');
        $fkaccname = mb_convert_encoding($fkaccname, "GBK", "UTF-8");
        //检测是否发送过
        $sendcount = M("jt_abc_sendrecord")->where("billno='" . $order_billno . "'")->count();
        if ($sendcount == 0) {
            //Send
            $array = $this->abc_payment_send($fkaccount, $total_fee, $order_billno, $order_id, $fkaccname);
            echo $array;
        } else {
            echo json_encode(array("jyjg" => mb_convert_encoding("支付失败", "UTF-8", "GBK"), "msg" => mb_convert_encoding("该单据你已经向农行发送过代扣请求！", "UTF-8", "GBK")));
        }
    }

    public function getcustbank() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("select a.FENTRYID,FACCOUNTNAME,FBANKCODE from T_BD_CUSTBANK a where a.fcustid=" . $custid . " order by FISDEFAULT desc  ");
        $this->assign("banklist", $list);
    }


    /**
     * 农行支付接口
     *6651501029326888  22240453300000181 22240401040000713
     * 接收加密后的报文，解密后发送给农行前置机
     */
    function abc_payment_send($fkaccount, $amount, $billno, $orderid, $fkaccname) {
        $xml_data = '<ap>' . '<Version></Version>' . '<Sign></Sign>' . '<FileFlag>0</FileFlag>' . '<ProductID>ICC</ProductID>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '<AuthNo></AuthNo>' . '<OpNo>0006</OpNo>' . '<CorpNo>22240453300000181</CorpNo>' . '<ChannelType>ERP</ChannelType>' . '<TransCode></TransCode>' . '<CCTransCode>CFRT73</CCTransCode>' . '<Cme>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '</Cme>' . '<MacAddress></MacAddress>' . '<FileComress></FileComress>' . '<LanguageFlag></LanguageFlag>' . '<Cmp>' . '<DbAccNo>' . $fkaccount . '</DbAccNo>' . '<DbProv></DbProv>' . '<DbCur>01</DbCur>' . '<CrAccNo>240401040000713</CrAccNo>' . '<CrCur>01</CrCur>' . '<CrProv>22</CrProv>' . '<CrLogAccNo></CrLogAccNo>' . '<ConFlag>1</ConFlag>' . '</Cmp>' . '<Corp>' . '<DbAccName>' . $fkaccname . '</DbAccName>' . '<DbLogAccName></DbLogAccName>' . '<CrAccName>四川雪宝乳业有限公司</CrAccName>' . '<Postscript>' . $billno . '</Postscript>' . '<ExchangeType>000000</ExchangeType>' . '<CshDraFlag>0</CshDraFlag>' . '<SpAccInd>1</SpAccInd>' . '</Corp>' . '<Amt>' . $amount . '</Amt>' . '</ap>';
        //报文长度格式化
        $_len = "1" . str_pad(strlen($xml_data), 6, ' ');
        $sendData = $_len . $xml_data;


        $result = $this->sendSocketMsg('192.168.10.6', 15999, $sendData, 1); //61.157.143.136
        //写入发送记录
        $MM = new \Think\Model();
        $MM->execute("insert into jt_abc_sendrecord(billno) values('" . $billno . "')");

        $data = mb_convert_encoding($result, "UTF-8", "GBK");
        $data2 = substr($data, 7, strlen($data));
        $array = json_decode(json_encode((array)simplexml_load_string($data2)), TRUE);
        if ($array["RespSource"] == 0) {
            //支付成功调用更新
            if ($array["RespInfo"] != "") {
                $M = new \Think\Model();
                $M->execute("exec Jp_order_zfupdate " . $orderid . ",1," . $amount . ""); //更新农行支付结果
                // $list=$M->query("select a.fbillno from T_AR_RECEIVEBILL a,T_AR_RECEIVEBILLENTRY b where a.fid=b.fid and b.FSALEORDERNO='".$billno."'");
                // foreach($list as $row)
                // {
                //     $skdno=$row["fbillno"];
                // }
                //利用API保存收款单20171201
                $res_save = Api_SKD_Save($billno, 0, $amount);
                $api_msg = "";
                if ($res_save == "f") {
                    $api_msg = "你好，你的订单支付已成功，但是系统在调用API保存收款时遇到问题，该订单需要联系雪宝工作人员进行线下处理！";
                } else {
                    $skdno = $res_save[0]->Number;
                    $shjg = Api_SKD_Audit($skdno);//利用Api提交、审核收款单 20171026修改
                    if ($shjg == "t") {
                        $sal_shjg = Api_SalOrder_Audit($billno);//利用Api提交和审核订单，并提交、审核收款单
                    }
                    if ($shjg == "f" || $sal_shjg == "f") {
                        $api_msg = "你好，你的订单支付已成功，但是系统在收款审核时遇到问题，该订单需要联系雪宝工作人员进行线下处理！";
                    }
                }
                return json_encode(array("jyjg" => mb_convert_encoding("支付成功", "UTF-8", "GBK"), "msg" => $array["RespInfo"], "api_msg" => mb_convert_encoding($api_msg, "UTF-8", "GBK")));
            } else {
                return json_encode(array("jyjg" => mb_convert_encoding("支付失败", "UTF-8", "GBK"), "msg" => mb_convert_encoding("连接服务失败", "UTF-8", "GBK")));
            }
        } else {
            return json_encode(array("jyjg" => mb_convert_encoding("支付失败[错误位置在经销商订货平台AbcController.php的第113行]", "UTF-8", "GBK"), "msg" => $array["RespInfo"] . $array["RxtInfo"]));//mb_convert_encoding($R,"UTF-8","GBK"));
        }
    }

    /*socket收发数据
   @host(string) socket服务器IP
   @post(int) 端口
   @str(string) 要发送的数据
   @back 1|0 socket端是否有数据返回
  返回true|false|服务端数据
 */
    function sendSocketMsg($host, $port, $str, $back = 0) {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);
        if ($socket < 0) return false;
        $result = @socket_connect($socket, $host, $port);
        if ($result == false) return false;
        socket_write($socket, $str, strlen($str));
        if ($back != 0) {
            $input = socket_read($socket, 1024);
            socket_close($socket);
            return $input;
        } else {
            socket_close($socket);
            return true;
        }
    }


    function encrypt($string, $operation, $key = '') {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }
}