<?php
/**
 * Created by tzb.
 * User: tzb
 * Date: 2016-11-04
 * Time: 16:51
 */

namespace Home\Controller;

use \Think\Controller;


class AbcpayController extends CommonController {
    /**
     * ��ʾũ�д���֧��ҳ��
     */
    public function index() {
        $this->getcustbank();
        $order_id = I('get.order_id', '');
        $order_billno = I('get.order_billno', '');
        $total_fee = I('get.total_fee', 0);
        $this->assign("order_id", $order_id);
        $this->assign("order_billno", $order_billno);
        $this->assign("total_fee", $total_fee);

        $this->display();
    }

    public function aa() {
        echo json_encode(array("msg" => "ss"));
    }

    /**
     * ũ�д���
     */
    public function abcpay() {
        $order_id = I('order_id', '');
        $order_billno = I('order_billno', '');
        $total_fee = I('total_fee', 0);
        $fkaccount = I('fkaccount', '');

        //����Ƿ��Ѿ�����
        $M = new \Think\Model();
        $list = $M->query("select 1 from Jt_orderjsrecord where billid=" . $order_id . " and fssje=fzfje ");

        if (count($list) > 0) {
            echo json_encode(array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => mb_convert_encoding("�õ����Ѿ�֧���������ٴ�֧����", "UTF-8", "GBK")));
            exit();
        }
        //$fkaccount='6228480489147433978';
        $fkaccname = '';

        if ($fkaccount == "") {
            echo json_encode(array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => mb_convert_encoding("�����˺Ų���Ϊ�գ�", "UTF-8", "GBK")));
            exit();
        }
        $custid = session("custid");
        //ȡ���ۿ��˻�����
        $list = $M->query("select a.FENTRYID,FACCOUNTNAME,FBANKCODE from T_BD_CUSTBANK a where a.fcustid=" . $custid . " and fbankcode='" . $fkaccount . "'");
        foreach ($list as $row) {
            $fkaccname = $row['faccountname'];
        }
        //����õ����˻�����
        echo json_encode(array("jyjg" => "", "fkaccname" => $fkaccname));
        //����ũ��֧��  ��ҳ��Ҫ��GBK �����޷������ı���
        //$array=$this->abc_payment_send($fkaccount,$total_fee,$order_billno,$order_id,$fkaccname);
        //echo json_encode($array);
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
     */
    function abc_payment_send($fkaccount, $amount, $billno, $orderid, $fkaccname) {
        $xml_data = '<ap>' . '<Version></Version>' . '<Sign></Sign>' . '<FileFlag>0</FileFlag>' . '<ProductID>ICC</ProductID>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '<AuthNo></AuthNo>' . '<OpNo>0006</OpNo>' . '<CorpNo>22240453300000181</CorpNo>' . '<ChannelType>ERP</ChannelType>' . '<TransCode></TransCode>' . '<CCTransCode>CFRT73</CCTransCode>' . '<Cme>' . '<ReqSeqNo>' . $billno . '</ReqSeqNo>' . '</Cme>' . '<MacAddress></MacAddress>' . '<FileComress></FileComress>' . '<LanguageFlag></LanguageFlag>' . '<Cmp>' . '<DbAccNo>' . $fkaccount . '</DbAccNo>' . '<DbProv></DbProv>' . '<DbCur>01</DbCur>' . '<CrAccNo>2404010400007131</CrAccNo>' . '<CrCur>01</CrCur>' . '<CrProv>22</CrProv>' . '<CrLogAccNo></CrLogAccNo>' . '<ConFlag>1</ConFlag>' . '</Cmp>' . '<Corp>' . '<DbAccName>' . $fkaccname . '</DbAccName>' . '<DbLogAccName></DbLogAccName>' . '<CrAccName>�Ĵ�ѩ����ҵ���޹�˾</CrAccName>' . '<Postscript>' . $billno . '</Postscript>' . '<ExchangeType>000000</ExchangeType>' . '<CshDraFlag>0</CshDraFlag>' . '<SpAccInd>1</SpAccInd>' . '</Corp>' . '<Amt>' . $amount . '</Amt>' . '</ap>';
        //���ĳ��ȸ�ʽ��
        $_len = "1" . str_pad(strlen($xml_data), 6, ' ');
        $sendData = $_len . $xml_data;
        /*
         $result=$this->sendSocketMsg('117.173.3.45',9100,$sendData,1); //61.157.143.136
         $data=mb_convert_encoding($result, "UTF-8", "GBK");
         $data2=substr($data,7,strlen($data));
         $array=json_decode(json_encode((array) simplexml_load_string($data2)),TRUE);
        */
        $url = 'http://weixin.xuebaoruye.com:1001/Home/abc?baowen=' . authcode($sendData, 'ENCODE', 'www.kingdee.com', 0);
        //$url='http://weixin.xuebaoruye.com:1001/Home/abc?baowen=907cpBAkYJrHZsXxlIjTK76O+75LV6KATsPVHL1xB8KIMP30BWLhqk6jRmqGTeBa03QRr9pFA/2d90xVi1OGCvtSKqogtDHyXvzMCOlgv8jl7ONzhlFqZDwASLpYVUNOEYJRF6EzVJ9x5/sKeVd7t6+8gQHRgvew9qq4pjEx4PbHE64mCl9n5tozwbSq957Qhn6QRC2WllXmwTWhbIEyliWWERPz/POWWC3wGXwNPhrfSy0yo/MsvlUP2k8yO27yO2B41aHKNdqV6tca0NuwznzSxejbxeywIR6Yk0ursyB0VKfd9SUu4hpl97iUcfd4uKE5GvdvE/9jfd6iFQt6JSIT1q4ffy55mpIJS+b1dAtogV3IkG3tTULAWh8Hq0AlYAiqywEr8UhSIs9Bl2tSN3welrrg+msAfDJ3wbijuDB7/SwySolyLyrZeyEfF8uUTd5HK4QllZ7A5VdPwpeI/1LHs5RKoY5oq6pPQf4pWFnDHP1wuDxv6+cfB4aY6EXGCj26AA48xY08oGln69ARxFeQx0ZRqhR+pGSnxCxiHmy6gfBY8qqFJ13fSQiFrAfwnExymVcnDvBuNsLbdeEPu+IGLDL2TqLkbvRc8bCC78J41TsT9jVaBfGBTze/M7VHlOHJYVOIZRENEg+X93I+w0752GYQOYahoCg03tPt8k6Nyal0XYQx+QQss8BbK13m10gRL/gUr/an3sJAttfRl6yHBSyVuMlfPX4CjKJanL6Ek+2PMn0Yj7oFFiSwV74G9cbvzrzDg5iSUfysHzz7X5cXNWFZJov2l6Bk2QeClaBS+Hbg6MM1vZcbUBDj1sAzcE5UAkzKP2BVFYJcPa8lV2p5ITYo8lc+4DyssieqtSEy1slO4e3EM0xOSypqdVDHqL2lmxj2tl3DyZDqQJzgnNAIvgPqHQxdbvJsZN4MfmdwHw9IyPhGQu1KMDbXxA3WYaBkI8oq+EFDYTbvIPbJ9rFwT44QicvA+XS+WDbfgQGV7SVw/xCHKLaqdi2k1fOwvUY3TsS1vnTH+Lga5GmFKBu2Pf+JnJaKXx7ser16ZuRPu1ySJq2jl8mSA5cnYreisdLUjc/IPn9TnHKPN+ZFvGdGK7Yqq5R9HQqyX4uHfosw2YMosoPXC2fs3OD0QpNj6UZ17rPK';
        // ��ʼ��һ�� cURL ����
        $curl = curl_init();
        // ��������Ҫץȡ��URL
        curl_setopt($curl, CURLOPT_URL, $url);
        // ����header ��Ӧͷ�Ƿ����
        curl_setopt($curl, CURLOPT_HEADER, 1);
        // ����cURL ������Ҫ�������浽�ַ����л����������Ļ�ϡ�
        // 1����ɹ�ֻ��������أ����Զ�����κ����ݡ����ʧ�ܷ���FALSE
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
        // ����cURL��������ҳ
        $data = curl_exec($curl);
        // �ر�URL����
        curl_close($curl);
        // ��ʾ��õ�����
        //   print_r($data);
        $array = $data;
        if ($array["RespSource"] == 0) {
            //֧���ɹ����ø���
            if ($array["RespInfo"] != "") {
                $M = new \Think\Model();
                $M->execute("exec Jp_order_zfupdate " . $orderid . ",1," . $amount . ""); //����ũ��֧�����
                return array("jyjg" => mb_convert_encoding("֧���ɹ�", "UTF-8", "GBK"), "msg" => $array["RespInfo"]);
            } else {
                return array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => mb_convert_encoding("���ӷ���ʧ��", "UTF-8", "GBK"));
            }

        } else {
            return array("jyjg" => mb_convert_encoding("֧��ʧ��", "UTF-8", "GBK"), "msg" => $array["RespInfo"] . $array["RxtInfo"]);//mb_convert_encoding($R,"UTF-8","GBK"));
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


}