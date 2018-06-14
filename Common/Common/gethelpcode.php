<?php
namespace Common\Common;
 /**
  * Modified by http://iulog.com @ 2013-05-07
  * �޸����ַ����ҷ���
  * ����ƴ������ĸ������
  *  ע�� Ӣ�ĵ��ִ������䷵��(��������)    eg .abc123 => abc123
  *      �����ַ���������ƴ�����ַ�        eg. �����ַ��� => CSZFC
  *      ��Ӣ��ϴ�: ����ƴ�����ַ���Ӣ��   eg. ��i��j => WIWJ
  *  eg.
  *  $py = new str2PY();
  *  $result = $py->getInitials('���ɲŵĶ��ɾͺ�i�Ϳ�������Ŷƽȥ������uv����һ��');
  */
class str2PY
{
    private $_pinyins = array(
        176161 => 'A',
        176197 => 'B',
        178193 => 'C',
        180238 => 'D',
        182234 => 'E',
        183162 => 'F',
        184193 => 'G',
        185254 => 'H',
        187247 => 'J',
        191166 => 'K',
        192172 => 'L',
        194232 => 'M',
        196195 => 'N',
        197182 => 'O',
        197190 => 'P',
        198218 => 'Q',
        200187 => 'R',
        200246 => 'S',
        203250 => 'T',
        205218 => 'W',
        206244 => 'X',
        209185 => 'Y',
        212209 => 'Z',
    );
    private $_charset = null;
    /**
     * ���캯��, ָ����Ҫ�ı��� default: utf-8
     * ֧��utf-8, gb2312
     *
     * @param unknown_type $charset
     */
    public function __construct( $charset = 'utf-8' )
    {
        $this->_charset    = $charset;
    }
    /**
     * �����ַ��� substr
     *
     * @param string $str
     * @param int    $start
     * @param int    $len
     * @return string
     */
    private function _msubstr ($str, $start, $len)
    {
        $start  = $start * 2;
        $len    = $len * 2;
        $strlen = strlen($str);
        $result = '';
        for ( $i = 0; $i < $strlen; $i++ ) {
            if ( $i >= $start && $i < ($start + $len) ) {
                if ( ord(substr($str, $i, 1)) > 129 ) $result .= substr($str, $i, 2);
                else $result .= substr($str, $i, 1);
            }
            if ( ord(substr($str, $i, 1)) > 129 ) $i++;
        }
        return $result;
    }
    /**
     * �ַ����з�Ϊ���� (���ֻ���һ���ַ�Ϊ��λ)
     *
     * @param string $str
     * @return array
     */
    private function _cutWord( $str )
    {
        $words = array();
        while ( $str != "" )
        {
            if ( $this->_isAscii($str) ) {/*������*/
                $words[] = $str[0];
                $str = substr( $str, strlen($str[0]) );
            }else{
                $word = $this->_msubstr( $str, 0, 1 );
                $words[] = $word;
                $str = substr( $str, strlen($word) );
            }
        }
        return $words;
    }
    /**
     * �ж��ַ��Ƿ���ascii�ַ�
     *
     * @param string $char
     * @return bool
     */
    private function _isAscii( $char )
    {
        return ( ord( substr($char,0,1) ) < 160 );
    }
    /**
     * �ж��ַ���ǰ3���ַ��Ƿ���ascii�ַ�
     *
     * @param string $str
     * @return bool
     */
    private function _isAsciis( $str )
    {
        $len = strlen($str) >= 3 ? 3: 2;
        $chars = array();
        for( $i = 1; $i < $len -1; $i++ ){
            $chars[] = $this->_isAscii( $str[$i] ) ? 'yes':'no';
        }
        $result = array_count_values( $chars );
        if ( empty($result['no']) ){
            return true;
        }
        return false;
    }
    /**
     * ��ȡ�����ִ���ƴ�����ַ�
     *
     * @param string $str
     * @return string
     */
    public function getInitials( $str )
    {
        if ( empty($str) ) return '';
        if ( $this->_isAscii($str[0]) && $this->_isAsciis( $str )){
            return $str;
        }
        $result = array();
        if ( $this->_charset == 'utf-8' ){
            $str = iconv( 'utf-8', 'gb2312', $str );
        }
        $words = $this->_cutWord( $str );
        foreach ( $words as $word )
        {
            if ( $this->_isAscii($word) ) {/*������*/
                $result[] = $word;
                continue;
            }
            $code = ord( substr($word,0,1) ) * 1000 + ord( substr($word,1,1) );
            /*��ȡƴ������ĸA--Z*/
            if ( ($i = $this->_search($code)) != -1 ){
                $result[] = $this->_pinyins[$i];
            }
        }
        return strtoupper(implode('',$result));
    }
    private function _getChar( $ascii )
    {
        if ( $ascii >= 48 && $ascii <= 57){
            return chr($ascii);  /*����*/
        }elseif ( $ascii>=65 && $ascii<=90 ){
            return chr($ascii);   /* A--Z*/
        }elseif ($ascii>=97 && $ascii<=122){
            return chr($ascii-32); /* a--z*/
        }else{
            return '-'; /*����*/
        }
    }
    /**
     * ������Ҫ�ĺ�������(gb2312) ��Ӧ��ƴ���ַ�( ���ַ� )
     *
     * @param int $code
     * @return int
     */
    private function _search( $code )
    {
        $data = array_keys($this->_pinyins);
        $lower = 0;
        $upper = sizeof($data)-1;
        $middle = (int) round(($lower + $upper) / 2);
        if ( $code < $data[0] ) return -1;
        for (;;) {
            if ( $lower > $upper ){
                return $data[$lower-1];
            }
            $tmp = (int) round(($lower + $upper) / 2);
            if ( !isset($data[$tmp]) ){
                return $data[$middle];
            }else{
                $middle = $tmp;
            }
            if ( $data[$middle] < $code ){
                $lower = (int)$middle + 1;
            }else if ( $data[$middle] == $code ) {
                return $data[$middle];
            }else{
                $upper = (int)$middle - 1;
            }
        }
    }
}
?>
