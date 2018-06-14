<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-10-28
 * Time: 9:01
 */

namespace Home\Controller;

use \Think\Controller;

class BanktestController extends Controller {
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

    /**
     * ũ��֧���ӿڲ���
     *
     */
    public function abc_payment_send() {
        $xml_data = '<ap>' . '<CCTransCode>CFRT73</CCTransCode>' . '<ProductID>ICC</ProductID>' . '<ChannelType>ERP</ChannelType>' . '<CorpNo>6651501029374068</CorpNo>' . '<OpNo>0099</OpNo>' . '<AuthNo>��֤��</AuthNo>' . '<ReqSeqNo>XSDDS2000323</ReqSeqNo>' . '<ReqDate>' . date("Ymd") . '</ReqDate>' . '<ReqTime>' . date("his") . '</ReqTime>' . '<Sign>sfasfd</Sign>' . '<Amt>0.01</Amt>' . '<Cmp>' . '<DbAccNo>1234567890</DbAccNo>' . '<DbProv>22</DbProv >' . '<DbCur>01</DbCur>' . '<CrAccNo>6222022303000550620</CrAccNo>' . '<CrProv>22</CrProv >' . '<CrCur>01</CrCur>' . '<CrLogAccNo></CrLogAccNo>' . '</Cmp>' . '<Corp>' . '<DbAccName>ѩ������</DbAccName>' . '<CrAccName>ѩ��</CrAccName>' . '<CshDraFlag>0</CshDraFlag>' . '<SpAccInd>0</SpAccInd>' . '<ExchangeType>000000</ExchangeType>' . '<Postscript>����</Postscript>' . '</Corp>' . '</ap>';
        //���ĳ��ȸ�ʽ��
        $_len = "1" . str_pad(strlen($xml_data), 6, ' ');
        $sendData = $_len . $xml_data;
        $result = $this->sendSocketMsg('192.168.10.3', 15999, $sendData, 1);
        $data = mb_convert_encoding($result, "UTF-8", "GBK");
        //echo $data;
        $data2 = substr($data, 7, strlen($data));
        $xml = $data2;
        $array = json_decode(json_encode((array)simplexml_load_string($xml)), TRUE);
        echo $array["RespSource"] . "<br>";
        echo $array["RxtInfo"];
    }


    public static function getBytes($string) {
        $bytes = array();
        for ($i = 0; $i < strlen($string); $i++) {
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }


    /**
     * ���շ������ݴ���
     */
    public function recvice() {
        // header("Content-type:text/xml");
        $data = "0554   <ap>" . "<Cmp>" . "<CmeSeqNo>020016237479</CmeSeqNo>" . "<BatchFileName></BatchFileName>" . "<RespPrvData></RespPrvData>" . "</Cmp>" . "<CCTransCode>CFRT73</CCTransCode>" . "<RespSource>3</RespSource>" . "<RespCode>2003</RespCode>" . "<RespInfo>�˺Ų�����</RespInfo>" . "<RxtInfo>�˺�[622202230300055]δ����ҵ[22240153900000044]������Ȩ,���ױ��ܾ�</RxtInfo>" . "<RespDate>20161103</RespDate>" . "<RespTime>083503</RespTime>" . "<FileFlag>0</FileFlag>" . "<Cme>" . "<RecordNum>0</RecordNum>" . "<FieldNum>0</FieldNum>" . "</Cme>" . "<RespSeqNo></RespSeqNo>" . "</ap>";
        $data2 = substr($data, 7, strlen($data));
        $xml = $data2;
        $array = json_decode(json_encode((array)simplexml_load_string($xml)), TRUE);
        echo $array["RespSource"] . "<br>";
        echo $array["RxtInfo"];
    }


}