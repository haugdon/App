<?php
/**
 * Created by tzb.
 * User: tzb
 * Date: 2016-11-04
 * Time: 16:51
 */

namespace Home\Controller;

use \Think\Controller;


class AbcController extends CommonController {
    /**
     * ��ʾũ�д���֧��ҳ��
     */
    public function index() {
        //���±���
    }

    public function aa() {
        header('Content-Type:text/html;Charset=utf-8');
        $r = array("success" => true, "msg" => "ok");
        echo $r;

    }

    /**
     * ũ�д���
     */
    public function abcpay_() {
        $order_id = I('order_id', '');
        $order_billno = I('order_billno', '');
        $total_fee = I('total_fee', 0);
        $fkaccount = I('fkaccount', '');
        $fkaccname = I('fkaccname', '');
        $fkaccname = mb_convert_encoding($fkaccname, "GBK", "UTF-8");
        //����Ƿ��͹�
        $sendcount = M("jt_abc_sendrecord")->where("billno='" . $order_billno . "'")->count();
        if ($sendcount == 0) {
            //Send
            $array = $this->abc_payment_send($fkaccount, $total_fee, $order_billno, $order_id, $fkaccname);
            echo $array;
        } else {
            echo json_encode(array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => mb_convert_encoding("�õ������Ѿ���ũ�з��͹���������", "UTF-8", "GBK")));
        }
    }

    public function getcustbank() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("select a.FENTRYID,FACCOUNTNAME,FBANKCODE from T_BD_CUSTBANK a where a.fcustid=" . $custid . " order by FISDEFAULT desc  ");
        $this->assign("banklist", $list);
    }


    /**
     * ũ��֧���ӿ�
     *6651501029326888  22240453300000181 22240401040000713
     * ���ռ��ܺ�ı��ģ����ܺ��͸�ũ��ǰ�û�
     */
    function abc_payment_send($fkaccount, $amount, $billno, $orderid, $fkaccname) {
        $xml_data = '<ap>' . '<Version></Version>' . '<Sign></Sign>' . '<FileFlag>0</FileFlag>' . '<ProductID>ICC</ProductID>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '<AuthNo></AuthNo>' . '<OpNo>0006</OpNo>' . '<CorpNo>22240453300000181</CorpNo>' . '<ChannelType>ERP</ChannelType>' . '<TransCode></TransCode>' . '<CCTransCode>CFRT73</CCTransCode>' . '<Cme>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '</Cme>' . '<MacAddress></MacAddress>' . '<FileComress></FileComress>' . '<LanguageFlag></LanguageFlag>' . '<Cmp>' . '<DbAccNo>' . $fkaccount . '</DbAccNo>' . '<DbProv></DbProv>' . '<DbCur>01</DbCur>' . '<CrAccNo>240401040000713</CrAccNo>' . '<CrCur>01</CrCur>' . '<CrProv>22</CrProv>' . '<CrLogAccNo></CrLogAccNo>' . '<ConFlag>1</ConFlag>' . '</Cmp>' . '<Corp>' . '<DbAccName>' . $fkaccname . '</DbAccName>' . '<DbLogAccName></DbLogAccName>' . '<CrAccName>�Ĵ�ѩ����ҵ���޹�˾</CrAccName>' . '<Postscript>' . $billno . '</Postscript>' . '<ExchangeType>000000</ExchangeType>' . '<CshDraFlag>0</CshDraFlag>' . '<SpAccInd>1</SpAccInd>' . '</Corp>' . '<Amt>' . $amount . '</Amt>' . '</ap>';
        //���ĳ��ȸ�ʽ��
        $_len = "1" . str_pad(strlen($xml_data), 6, ' ');
        $sendData = $_len . $xml_data;


        $result = $this->sendSocketMsg('192.168.10.6', 15999, $sendData, 1); //61.157.143.136
        //д�뷢�ͼ�¼
        $MM = new \Think\Model();
        $MM->execute("insert into jt_abc_sendrecord(billno) values('" . $billno . "')");

        $data = mb_convert_encoding($result, "UTF-8", "GBK");
        $data2 = substr($data, 7, strlen($data));
        $array = json_decode(json_encode((array)simplexml_load_string($data2)), TRUE);
        if ($array["RespSource"] == 0) {
            //֧���ɹ����ø���
            if ($array["RespInfo"] != "") {
                $M = new \Think\Model();
                $M->execute("exec Jp_order_zfupdate " . $orderid . ",1," . $amount . ""); //����ũ��֧�����
                $list = $M->query("select a.fbillno from T_AR_RECEIVEBILL a,T_AR_RECEIVEBILLENTRY b where a.fid=b.fid and b.FSALEORDERNO='" . $billno . "'");
                foreach ($list as $row) {
                    $skdno = $row["fbillno"];
                }
                //����Api�ύ������տ 20171026�޸�
                $shjg = Api_SKD_Audit($skdno);
                if ($shjg == "t") {
                    //����Api�ύ����˶��������ύ������տ
                    $sal_shjg = Api_SalOrder_Audit($billno);
                }
                $api_msg = "";
                if ($shjg == "f") {
                    $api_msg = "��ã���Ķ���֧���ѳɹ�������ϵͳ���տ����ʱ�������⣬�ö�����Ҫ��ϵѩ��������Ա�������´���";
                } else {
                    $api_msg = "";
                }
                if ($sal_shjg == "f") {
                    $api_msg = "��ã���Ķ���֧���ѳɹ�������ϵͳ�ڶ������ʱ�������⣬�ö�����Ҫ��ϵѩ��������Ա�������´���";
                } else {
                    $api_msg = "";
                }
                return json_encode(array("jyjg" => mb_convert_encoding("֧���ɹ�", "UTF-8", "GBK"), "msg" => $array["RespInfo"], "api_msg" => mb_convert_encoding($api_msg, "UTF-8", "GBK")));
            } else {
                return json_encode(array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => mb_convert_encoding("���ӷ���ʧ��", "UTF-8", "GBK")));
            }

        } else {
            return json_encode(array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => $array["RespInfo"] . $array["RxtInfo"]));//mb_convert_encoding($R,"UTF-8","GBK"));
        }
    }

    /*socket�շ�����
   @host(string) socket������IP
   @post(int) �˿�
   @str(string) Ҫ���͵�����
   @back 1|0 socket���Ƿ������ݷ���
  ����true|false|���������
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