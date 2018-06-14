<?php

/**
 * 菜单
 */
function loadmenu(){
	$Menu = M("jtmenus");
	$where['parentid']=0;
	$menulist = $Menu->where($where)->order("seq")->select();
	foreach($menulist as $row)
	{
		$icon=$row['icons'];
		echo "<div title=".$row['menuname']." style=overflow:auto;padding:10px; data-options=iconCls:'{$icon}'>";
		$CMenu = M("jtmenus");
		$condition['parentid']=$row['menuid'];
		if(session('users')<>"admin")
		{
			//$condition['menunumber']=array('not in',array('A002','A003','A007','A05','A009'));
		}else{
			$condition['menunumber']=array('not in',array('A002','A003','A004'));
		}
		$Clist=$CMenu->where($condition)->order("seq,menunumber")->select();
		foreach($Clist as $crow)
		{
			$link="Home/".$crow['menulink'];
			$icon_c=$crow['icons'];
			echo "<a href=# onclick=Open('".$crow['menuname']."','{$link}') class=easyui-linkbutton data-options=plain:true,iconCls:'{$icon_c}' >".$crow['menuname']."</a><br/>";
		}
		echo "</div>";
	}
	//$this->assign("menulist",$menulist);
}
function genderchk($idno)
{
   if(strlen($idno)==15)
	{
		$no=substr($idno,14,1);
	}else{
		$no=substr($idno,16,1);
	}
	if (($no%2)==1)
	{
		$res='男';
	}else{
		$res='女';
	}
	return $res;
}

/**
 * 菜单
 */
function loadchildmenu($parent){
	$Menu = M("jtmenus");
	$where['parentid']=$parent;
	if(session('users')<>"admin")
	{
		$where['menunumber']=array('not in',array('A05','A06','A07'));
	} else{
		$where['menunumber']=array('not in',array('A02','A03','A04'));
	}
	$menulist = $Menu->where($where)->order("seq")->select();
	foreach($menulist as $row)
	{
		echo "<a href=# class=easyui-linkbutton data-options=plain:true,iconCls:'icon-cancel'>".$row['menuname']."</a><br>";
	}
}

/**
 * 字符串截取，支持中文和其他编码
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    $charset = strtolower($charset);
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 检测输入的验证码是否正确
 * @param string $code 为用户输入的验证码字符串
 * @return boolen
 */
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 对用户的密码进行加密
 * @param string $password
 * @param string $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='') {
	$pwd = array();
	$pwd['encrypt'] =  $encrypt ? $encrypt : Org\Util\String::randString(6);
	$pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
	return $encrypt ? $pwd['password'] : $pwd;
}

/**
 * 解析多行sql语句转换成数组
 * @param string $sql
 * @return array
 */
function sql_split($sql) {
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query) {
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return($ret);
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 取得文件扩展
 * @param $filename 文件名
 * @return 扩展名
 */
function file_ext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/**
 * 文件是否存在
 * @param string $filename  文件名
 * @return boolean  
 */
function file_exist($filename ,$type=''){
	switch (STORAGE_TYPE){
		case 'Sae':
			$arr = explode('/', ltrim($filename, './'));
	        $domain = array_shift($arr);
	        $filePath = implode('/', $arr);
	        $s = new SaeStorage();
			return $s->fileExists($domain, $filePath);
			break;
		default:
			return \Think\Storage::has($filename ,$type);
	}
}

/**
 * 文件内容读取
 * @param string $filename  文件名
 * @return boolean         
 */
function file_read($filename, $type=''){
	switch (STORAGE_TYPE){
		case 'Sae':
			$arr = explode('/', ltrim($filename, './'));
	        $domain = array_shift($arr);
			$filePath = implode('/', $arr);
			$s=new SaeStorage();
			return $s->read($domain, $filePath);
			break;
		default:
			return \Think\Storage::read($filename, $type);
	}
}

/**
 * 文件写入
 * @param string $filename  文件名
 * @param string $content  文件内容
 * @return boolean         
 */
function file_write($filename, $content, $type=''){
	switch (STORAGE_TYPE){
		case 'Sae':
			$s=new SaeStorage();
			$arr = explode('/',ltrim($filename,'./'));
			$domain = array_shift($arr);
			$save_path = implode('/',$arr);
			return $s->write($domain, $save_path, $content);
			break;
		default:
			return \Think\Storage::put($filename, $content, $type);
	}
}

/**
 * 文件删除
 * @param string $filename  文件名
 * @return boolean     
 */
function file_delete($filename ,$type=''){
	switch (STORAGE_TYPE){
		case 'Sae':
			$arr = explode('/', ltrim($filename, './'));
	        $domain = array_shift($arr);
	        $filePath = implode('/', $arr);
	        $s = new SaeStorage();
			return $s->delete($domain, $filePath);
			break;
		default:
			return \Think\Storage::unlink($filename ,$type);
	}
}

/**
 * 获取文件URL
 * @param string $filename  文件名
 * @return string
 */
function file_path2url($filename){
	$search = array_keys(C('TMPL_PARSE_STRING'));
	$replace = array_values(C('TMPL_PARSE_STRING'));
	return str_ireplace($search, $replace, $filename);
}
function get_letter($string) {
	$charlist = mb_str_split($string);
	return implode(array_map("getfirstchar", $charlist));
}
function mb_str_split($string) {
	// Split at all position not after the start: ^
	// and not before the end: $
	return preg_split('/(?<!^)(?!$)/u', $string);
}
function getfirstchar($s0) {
	$fchar = ord(substr($s0, 0, 1));
	if (($fchar >= ord("a") and $fchar <= ord("z"))or($fchar >= ord("A") and $fchar <= ord("Z"))) return strtoupper(chr($fchar));
	$s = iconv("UTF-8", "GBK", $s0);
	$asc = ord($s{0}) * 256 + ord($s{1})-65536;
	if ($asc >= -20319 and $asc <= -20284)return "A";
	if ($asc >= -20283 and $asc <= -19776)return "B";
	if ($asc >= -19775 and $asc <= -19219)return "C";
	if ($asc >= -19218 and $asc <= -18711)return "D";
	if ($asc >= -18710 and $asc <= -18527)return "E";
	if ($asc >= -18526 and $asc <= -18240)return "F";
	if ($asc >= -18239 and $asc <= -17923)return "G";
	if ($asc >= -17922 and $asc <= -17418)return "H";
	if ($asc >= -17417 and $asc <= -16475)return "J";
	if ($asc >= -16474 and $asc <= -16213)return "K";
	if ($asc >= -16212 and $asc <= -15641)return "L";
	if ($asc >= -15640 and $asc <= -15166)return "M";
	if ($asc >= -15165 and $asc <= -14923)return "N";
	if ($asc >= -14922 and $asc <= -14915)return "O";
	if ($asc >= -14914 and $asc <= -14631)return "P";
	if ($asc >= -14630 and $asc <= -14150)return "Q";
	if ($asc >= -14149 and $asc <= -14091)return "R";
	if ($asc >= -14090 and $asc <= -13319)return "S";
	if ($asc >= -13318 and $asc <= -12839)return "T";
	if ($asc >= -12838 and $asc <= -12557)return "W";
	if ($asc >= -12556 and $asc <= -11848)return "X";
	if ($asc >= -11847 and $asc <= -11056)return "Y";
	if ($asc >= -11055 and $asc <= -10247)return "Z";
	return null;
}


/**
 * 获取文件路径
 * @param string $fileurl  文件URL
 * @return string
 */
function file_url2path($fileurl){
	$search = array_values(C('TMPL_PARSE_STRING'));
	$replace = array_keys(C('TMPL_PARSE_STRING'));
	return str_ireplace($search, $replace, $fileurl);
}
/*
 * 单据反审核
 */
function bill_cancelaudit($billno)
{
	$MB=M("jtbills");
	$condi['billno']=$billno;
	$condi['billstatus']=1;
	$field=("billid,case billtype when 1 then 1 when 2 then 0 else 1 end billtype,billno,billdate,supplierid,jtbills.itemid,qty,costprice,realprice,amount,jtbills.remark,jtbills.billstatus,batchno,");
	$field.=("warehouseid,customerid,1 as iskc");
	$res=$MB->field($field)-> where($condi)->select();
	foreach($res as $row)
	{
		if($row['iskc']==1) {
			$result = inventoryupdate($row['warehouseid'], $row['itemid'], $row['batchno'], $row['qty'],$row['billtype']);
			$where['billid']=$row['billid'];
			$MB->where($where)->setField('billstatus',0);//单据ID状态更新为1
		}
	}
	return $result;
}
/*
 * 单据更新提交
 */
function bill_audit($billno)
{
	$MB=M("jtbills");
	$condi['billno']=$billno;
	$condi['billstatus']=0;
	$field=("billid,case billtype when 1 then 0 when 2 then 1 else 0 end billtype,billno,billdate,supplierid,jtbills.itemid,qty,costprice,realprice,amount,jtbills.remark,jtbills.billstatus,batchno,");
	$field.=("warehouseid,customerid,1 as iskc");
	$res=$MB->field($field)-> where($condi)->select();
	foreach($res as $row)
	{
		if($row['iskc']==1) {
			$result = inventory_update($row['warehouseid'], $row['itemid'], $row['batchno'],$row['costprice'],$row['realprice'],$row['qty'],$row['supplierid'],$row['billid'],$row['billtype']);
		}
		$where['billid']=$row['billid'];
		$MB->where($where)->setField('billstatus',1);//单据ID状态更新为1
	}
   return true;
}
/**
 * 库存表更新 仓库、物料、批号、成本价、数量、单据Id $kctype 0 增加 1 减少
 */
function inventory_update($warehouseid,$itemid,$batchno,$costprice,$realprice,$qty,$supplierid,$billid,$kctype)
{
	//判断是否存在
	$M=M("jtinventorys");
	$condition['warehouseid']=$warehouseid;
	$condition['itemid']=$itemid;
	$condition['batchno']=$batchno;
	$condition['costprice']=$costprice;
	$condition['supid']=$supplierid;
	$res=$M->where($condition)->select();
	if($res)
	{
     //UPDATE
		if($kctype==0){
		$result = $M->where($condition)->setInc('usaqty',$qty);
		$result = $M->where($condition)->setInc('realqty',$qty);
		}
		else
		{
			//判断是否负数量
			if( $qty<0 ){
				$result = $M->where($condition)->setInc('usaqty',abs($qty));
				$result = $M->where($condition)->setInc('realqty',abs($qty));
			}else{
				$result = $M->where($condition)->setDec('usaqty',$qty);
				$result = $M->where($condition)->setDec('realqty',$qty);
			}
		}
		$result = $M->where($condition)->setField('realprice',$realprice); //更新最后的销售单 价
		$result = $M->where($condition)->setField('modifier',session('users'));
		$result = $M->where($condition)->setField('modifiertime',date('Y-m-d H:i:s',time()));
	}else
	{
		$data['warehouseid']=$warehouseid;
		$data['supid']=$supplierid;
		$data['itemid']=$itemid;
		$data['batchno']=$batchno;
		$data['costprice']=$costprice;
		if($kctype==0){
		$data['realqty']=$qty;
		$data['usaqty']=$qty;}
		else{
			$data['realqty']=-$qty;
			$data['usaqty']=-$qty;
		}
		$data['realprice']=$realprice;
		$data['modifier']=session('users');
		$data['modifiertime']=date('Y-m-d H:i:s',time());
		$result = $M->add($data);
	}
	if(!empty($b))
	{
		$r=true;
	}else{
		$r=false;
	}
	return $r;

}


 function getExcel($fileName,$headArr,$data){
	//导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
	import("Org.Util.PHPExcel");
	import("Org.Util.PHPExcel.Writer.Excel5");
	import("Org.Util.PHPExcel.IOFactory");

	$date = date("Y_m_d",time());
	$fileName .= "_{$date}.xls";

	//创建PHPExcel对象，注意，不能少了\
	$objPHPExcel = new \PHPExcel();
	$objProps = $objPHPExcel->getProperties();

	//设置表头
	$key = ord("A");
	//print_r($headArr);exit;

	foreach($headArr as $v){
		$colum = chr($key);
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1',urldecode($v));
		//$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
		$key += 1;
	}

	$column = 2;
	$objActSheet = $objPHPExcel->getActiveSheet();

	//print_r($data);exit;
	foreach($data as $key => $rows){ //行写入
		$span = ord("A");
		foreach($rows as $keyName=>$value){// 列写入
			$j = chr($span);
			$objActSheet->setCellValue($j.$column, $value);
			$span++;
		}
		$column++;
	}

	$fileName = iconv("utf-8", "gb2312", $fileName);

	//重命名表
	//$objPHPExcel->getActiveSheet()->setTitle('test');
	//设置活动单指数到第一个表,所以Excel打开这是第一个表
	$objPHPExcel->setActiveSheetIndex(0);
	ob_end_clean();//清除缓冲区,避免乱码
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=\"$fileName\"");
	header('Cache-Control: max-age=0');

	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output'); //文件通过浏览器下载
	exit;
}

function inventoryupdate($warehouseid,$materialid,$batchno,$realqty)
	{
		$M=M('jtinventorys');
		$condition['warehouseid']=$warehouseid;
		$condition['itemid']=$materialid;
		$condition['batchno']=$batchno;		
		$mcount=$M->where($condition)->count();
		$data['warehouseid']=$warehouseid;
		$data['itemid']=$materialid;
		$data['batchno']=$batchno;
		$data['realqty']=$realqty;
		$data['modifier']=session("custid");
		$data['modifiertime']=date('Y-m-d H:i:s',time());
		$updata=array('modifier'=>session("custid"),'modifiertime'=>date('Y-m-d H:i:s',time()));
		if($mcount==0)
		{
			$b=$M->add($data);
		}else
		{
			$b=$M->where($condition)->setInc('realqty',$realqty);
		    $M->where($condition)->setField($updata);
		}
		if(!empty($b))
		{
			$r=true;
		}else{
			$r=false;
		}
		return $r;
	}
function downinventory()
	{
		//从Kingdee下载 
		$log=M("jtkclog");
		$logdate=$log->query("select max(lastrq) rq from jtkclog where custid=".session('custid')."");
		foreach($logdate as $row)
		{
			$lastdate=$row['rq'];
		}
		if(empty($lastdate))
		{
			$lastdate=date('Y-m-d','2015-10-01');
		}
		$lastdate=$lastdate;
		$custid=session("custid");
		$user=session("users");
		$K=new \Think\Model();//('T_SAL_OUTSTOCK');		
		//查询销售出库单 
		$sql="exec jpgetcustomerinventory ".$custid.",'".$lastdate."','".$user."'";
		$res=$K->execute($sql);
		return true;
        //循环
		//foreach($kingdeelist as $row){
		//	$log=M('jtkclog');
		//	$lrs=$log->where("djfid=".$row['fentryid'])->count();
		//	$logdata['djfid']=$row['fentryid'];
		//	$logdata['lastdate']=date('Y-m-d H:i:s',time());
		//	if($lrs==0)
		//	{
				//写入新库存
		//		inventoryupdate($row['fcustomerid'],$row['fmaterialid'],$row['flot_text'],$row['frealqty']);
		//		$log->add($logdata);
		//	}
		//}
	}

/**
 * 导出数据为excel表格
 *@param $data    一个二维数组,结构如同从数据库查出来的数组
 *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
 *@param $filename 下载的文件名
 *@examlpe
$stu = M ('User');
$arr = $stu -> select();
exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
 */
function exportexcel($data=array(),$title=array(),$filename='report'){
	header("Content-type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=".$filename.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	//导出xls 开始
	if (!empty($title)){
		foreach ($title as $k => $v) {
			$title[$k]=iconv("UTF-8", "GB2312",$v);
		}
		$title= implode("\t", $title);
		echo "$title\n";
	}
	if (!empty($data)){
		foreach($data as $key=>$val){
			foreach ($val as $ck => $cv) {
				$data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
			}
			$data[$key]=implode("\t", $data[$key]);

		}
		echo implode("\n",$data);
	}
}

//下载文件
function download_file($file){
	if(is_file($file)){
		$length = filesize($file);
		$type = mime_content_type($file);
		$showname =  ltrim(strrchr($file,'/'),'/');
		header("Content-Description: File Transfer");
		header('Content-type: ' . $type);
		header('Content-Length:' . $length);
		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
			header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $showname . '"');
		}
		readfile($file);
		exit;
	} else {
		exit('文件已被删除！');
	}
}

/**
 * @param $url
 * @param array $param
 * @return mixed
 * @throws Exception
 * 发送POST请求
 */
function post($url, $param){
	//if(!is_array($param)){
	//	throw new Exception("参数必须为array");
	//}
	$httph =curl_init($url);
	curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
	curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
	curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
	curl_setopt($httph, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_HEADER,1);
	$rst=curl_exec($httph);
	curl_close($httph);
	return $rst;
}

/**
 * @param $url
 * @param $post_data
 * @return bool|string
 * PHPPOST提交
 */
function send_post($url, $post_data) {
	$postdata = http_build_query($post_data);
	$options = array(
			'http' => array(
					'method' => 'POST',
					'header' => 'Content-type:application/x-www-form-urlencoded',
					'content' => $post_data,
					'timeout' => 15 * 60 // 超时时间（单位:s）
			)
	);
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	return $result;
}

function  log_result($file,$word)
{
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

function encrypt($string,$operation,$key=''){
	$key=md5($key);
	$key_length=strlen($key);
	$string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
	$string_length=strlen($string);
	$rndkey=$box=array();
	$result='';
	for($i=0;$i<=255;$i++){
		$rndkey[$i]=ord($key[$i%$key_length]);
		$box[$i]=$i;
	}
	for($j=$i=0;$i<256;$i++){
		$j=($j+$box[$i]+$rndkey[$i])%256;
		$tmp=$box[$i];
		$box[$i]=$box[$j];
		$box[$j]=$tmp;
	}
	for($a=$j=$i=0;$i<$string_length;$i++){
		$a=($a+1)%256;
		$j=($j+$box[$a])%256;
		$tmp=$box[$a];
		$box[$a]=$box[$j];
		$box[$j]=$tmp;
		$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	}
	if($operation=='D'){
		if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
			return substr($result,8);
		}else{
			return'';
		}
	}else{
		return str_replace('=','',base64_encode($result));
	}
}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
	$ckey_length = 4;

	// 密匙
	$key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

	// 密匙a会参与加解密
	$keya = md5(substr($key, 0, 16));
	// 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
	// 密匙c用于变化生成的密文
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):
			substr(md5(microtime()), -$ckey_length)) : '';
	// 参与运算的密匙
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
//解密时会通过这个密匙验证数据完整性
	// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
			sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	// 产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	// 核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// 从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		// 验证数据有效性，请看未加密明文的格式
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
				substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

/**
 *====================20170824 调用金蝶WebAPI==================
 */

//登陆
function invoke_login($cloudUrl,$post_content,$cookie_jar)
{
	$loginurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
	return invoke_post($loginurl,$post_content,$cookie_jar,TRUE);
}
//保存
function invoke_save($cloudUrl,$post_content,$cookie_jar)
{
	$invokeurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Save.common.kdsvc';
	return invoke_post($invokeurl,$post_content,$cookie_jar,FALSE);
}
//提交
function invoke_submit($cloudUrl,$post_content,$cookie_jar)
{
	$invokeurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Submit.common.kdsvc';
	return invoke_post($invokeurl,$post_content,$cookie_jar,FALSE);
}
//审核
function invoke_audit($cloudUrl,$post_content,$cookie_jar)
{
	$invokeurl = $cloudUrl.'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Audit.common.kdsvc';
	return invoke_post($invokeurl,$post_content,$cookie_jar,FALSE);
}

//构造Web API请求格式
function create_postdata($args) {
	$postdata = array(
			'format'=>1,
			'useragent'=>'ApiClient',
			'rid'=>create_guid(),
			'parameters'=>$args,
			'timestamp'=>date('Y-m-d'),
			'v'=>'1.0'
	);
	return json_encode($postdata);
}
//生成guid
function create_guid() {
	$charid = strtoupper(md5(uniqid(mt_rand(), true)));
	$hyphen = chr(45);// "-"
	$uuid = chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
	return $uuid;
}
function invoke_post($url,$post_content,$cookie_jar,$isLogin)
{
	$ch = curl_init($url);
	$this_header = array(
			'Content-Type: application/json',
			'Content-Length: '.strlen($post_content)
	);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_content);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if($isLogin){
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
	}
	else{
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
/***
 * 订单审核调用
 */
function Api_SalOrder_Audit($OrderNO)
{
	header("Content-type:text/html;charset=utf-8");
	$cloudUrl="http://192.168.10.5:8888/K3Cloud/";
	$cookie_jar = tempnam('./tmp','CloudSession');
	//登录
	$logdata = array(
			'593f6fea124c69',//帐套Id
			'user',//用户名
			'abcd1234',//密码
			2052//语言标识
	);
	$post_content = create_postdata($logdata);
	$result = invoke_login($cloudUrl,$post_content,$cookie_jar);
	$obj=json_decode($result);
	$Obj=$obj->Context;
	//echo "当前用户ID：".$Obj->UserId;
	//echo "当前用户名：".$Obj->UserName;
	//单据提交和审核
	$submit_data = array(
			'SAL_SaleOrder',
			array('CreateOrgId'=>100002,'UseOrgId'=>100002,'Numbers'=>(''.$OrderNO.''))
	);

	$post_content = create_postdata($submit_data);
	//提交
	$result = invoke_submit($cloudUrl,$post_content,$cookie_jar);
	//提交结果转换
	$obj=json_decode($result)->Result->ResponseStatus->IsSuccess;
	if($obj==false){
		$jg="f";
		return $jg;
		exit(); //提交失败
	}else{
		//提交成功后审核
		$result=invoke_audit($cloudUrl,$post_content,$cookie_jar);
		//结果转换
		$obj=json_decode($result)->Result->ResponseStatus->IsSuccess;
		if($obj==false){
			$jg="f";
		}else{
			$jg="t";
		}
		return $jg;
	}
}
/***
 * 收款单审核调用
 */
function Api_SKD_Audit($OrderNO)
{
	header("Content-type:text/html;charset=utf-8");
	$cloudUrl="http://192.168.10.5:8888/K3Cloud/";
	$cookie_jar = tempnam('./tmp','CloudSession');
	//登录
	$logdata = array(
			'593f6fea124c69',//帐套Id
			'user',//用户名
			'abcd1234',//密码
			2052//语言标识
	);
	$post_content = create_postdata($logdata);
	$result = invoke_login($cloudUrl,$post_content,$cookie_jar);
	$obj=json_decode($result);
	$Obj=$obj->Context;
	//echo "当前用户ID：".$Obj->UserId;
	//echo "当前用户名：".$Obj->UserName;
	//单据提交和审核
	$submit_data = array(
			'AR_RECEIVEBILL',
			array('CreateOrgId'=>100002,'UseOrgId'=>100002,'Numbers'=>(''.$OrderNO.''))
	);

	$post_content = create_postdata($submit_data);
	//提交
	$result = invoke_submit($cloudUrl,$post_content,$cookie_jar);
	//提交结果转换
	$obj=json_decode($result)->Result->ResponseStatus->IsSuccess;
	if($obj==false){
		$jg="f";
		return $jg; //提交失败
		exit();
	}else{
		//提交成功后审核
		$result=invoke_audit($cloudUrl,$post_content,$cookie_jar);
		//结果转换
		$obj=json_decode($result)->Result->ResponseStatus->IsSuccess;
		if($obj==false){
			$jg="f";
		}else{
			$jg="t";
		}
		return $jg;
	}
}

/***
 * 订单保存调用
 */
function Api_SalOrder_Save($custid)
{
	header("Content-type:text/html;charset=utf-8");
	$cloudUrl="http://192.168.10.5:8888/K3Cloud/";
	$cookie_jar = tempnam('./tmp','CloudSession');
	//登录
	$logdata = array(
			'593f6fea124c69',//帐套Id
			'user',//用户名
			'abcd1234',//密码
			2052//语言标识
	);
	$post_content = create_postdata($logdata);
	$result = invoke_login($cloudUrl,$post_content,$cookie_jar);
	$obj=json_decode($result);
	$obj=$obj->Context;
	//根据客户ID获取出客户的Number
	$custnumber=M("t_bd_customer")->where("fcustid=".$custid."")->getField("fnumber");
	$salerId=M("v_bd_salesman")->join("t_bd_customer on v_bd_salesman.fid=t_bd_customer.fseller")->where("t_bd_customer.fcustid=".$custid." ")->getField("v_bd_salesman.fnumber");
	$date=Date('Y-m-d',time());

	$data='{"Creator":"","NeedUpDateFields":[],"NeedReturnFields":[],"IsDeleteEntry":"True","SubSystemId":"",
	"IsVerifyBaseDataField":"false","Model":{"FID":"0","FBillTypeID":{"FNumber":"XSDD02_SYS"},"FBillNo":"","FDate":"'.$date.'",
	"FSaleOrgId":{"FNumber":"102"},"FCustId":{"FNumber":"'.$custnumber.'"},"FHeadDeliveryWay":{"FNumber":""},"FReceiveId":{"FNumber":""},
	"FHEADLOCID":{"FNUMBER":""},"FCorrespondOrgId":{"FNumber":""},"FSaleDeptId":{"FNumber":""},
	"FSaleGroupId":{"FNumber":""},"FSalerId":{"FNumber":"'.$salerId.'"},"FReceiveAddress":"","FSettleId":{"FNumber":""},
	"FReceiveContact":{"FName":""},"FChargeId":{"FNumber":""},"FNetOrderBillNo":"","FNetOrderBillId":"0",
	"FOppID":"0","FSalePhaseID":{"FNumber":""},"FISINIT":"false","FNote":"","F_PAEZ_Base":{"FStaffNumber":""},
	"F_PAEZ_Assistant":{"FNumber":""},"Fcustupfile":"","F_PAEZ_PrintTimes":"0","FIsMobile":"false","F_PAEZ_PrintDateTime":"1900-01-01",
	"F_PAEZ_CheckBox":"false","F_PAEZ_Amount":"0","F_PAEZ_CheckBox1":"false",
	"FSaleOrderFinance":{"FSettleCurrId":{"FNumber":"PRE001"},"FExchangeRate":"1","FLocalCurrId":{"FNumber":"PRE001"},"FRecConditionId":{"FNumber":""},"FIsPriceExcludeTax":"false",
	"FSettleModeId":{"FNumber":""},"FIsIncludedTax":"false","FPriceListId":{"FNumber":""},"FDiscountListId":{"FNumber":""},
	"FExchangeTypeId":{"FNumber":"HLTX01_SYS"}},"FSaleOrderClause":[{"FEntryID":"0","FClauseId":{"FNumber":""},"FClauseDesc":""}],
	"FSaleOrderEntry":[{"FEntryID":"0","FReturnType":"","FMapId":{"FNumber":""},"FMaterialId":{"FNumber":"0201000018"},
	"FAuxPropId":{},"FUnitID":{"FNumber":"007"},"FCurrentInventory":"0","FInventoryQty":"0","FAwaitQty":"0","FAvailableQty":"0",
	"FQty":"1","FOldQty":"0","FPrice":"0","FTaxPrice":"0","FIsFree":"true","FTaxCombination":{"FNumber":""},"FEntryTaxRate":"0",
	"FProduceDate":"1900-01-01","FExpPeriod":"0","FExpUnit":"","FExpiryDate":"1900-01-01","FLot":{"FNumber":""},"FDiscountRate":"0",
	"FDeliveryDate":"'.$date.'","FStockOrgId":{"FNumber":""},"FSettleOrgIds":{"FNumber":""},"FSupplyOrgId":{"FNumber":""},
	"FOwnerTypeId":"","FOwnerId":{"FNumber":""},"FEntryNote":"","FReserveType":"","FPriority":"0","FMtoNo":"","FPromotionMatchType":"",
	"FNetOrderEntryId":"0","FPriceBaseQty":"1","FSetPriceUnitID":{"FNumber":""},"FStockUnitID":{"FNumber":""},"FStockQty":"1","FStockBaseQty":"1",
	"FServiceContext":"","Fisbuildboxbill":"0","FOUTLMTUNIT":"","Fboxmaterialid":{"FNumber":""},"FOutLmtUnitID":{"FNumber":""},
	"F_PAEZ_Base2":{"FNumber":""},"F_PAEZ_Base3":{"FNumber":""},"FOrderEntryPlan":[{"FDetailID":"0","FDetailLocId":{"FNUMBER":""},
	"FDetailLocAddress":"","FPlanDate":"'.$date.'","FPlanQty":"1","FTransportLeadTime":"0","F_PAEZ_Base1":{"FStaffNumber":""},
	"F_PAEZ_Base4":{"FStaffNumber":""},"F_PAEZ_Base5":{"FNumber":""}}],"FTaxDetailSubEntity":[{"FDetailID":"0","FTaxRate":"0","FSellerWithholding":"false",
	"FBuyerWithholding":"false"}]}],"FSaleOrderPlan":[{"FEntryID":"0","FNeedRecAdvance":"false","FReceiveType":{"FNumber":""},"FRecAdvanceRate":"0",
	"FRecAdvanceAmount":"0","FMustDate":"1900-01-01","FRelBillNo":"","FRecAmount":"0","FControlSend":"","FReMark":"","FPlanMaterialId":{"FNumber":""},
	"FMaterialSeq":"0","FOrderEntryId":"0","FSaleOrderPlanEntry":[{"FDETAILID":"0","FPESettleOrgId":{"FNumber":""}}]}],
	"FSalOrderTrace":[{"FEntryID":"0","FLogComId":{"FCode":""},"FCarryBillNo":"","FSalOrderTraceDetail":[{"FDetailID":"0","FTraceTime":"","FTraceDetail":""}]}]}}
    ';

	//保存
	$save_data = array(
			'SAL_SaleOrder',
			$data
	);

	$post_content = create_postdata($save_data);
	//提交
	$result = invoke_save($cloudUrl,$post_content,$cookie_jar);

	//提交结果转换
	$obj=json_decode($result)->Result->ResponseStatus->IsSuccess;
	$objsuccess=json_decode($result)->Result->ResponseStatus->SuccessEntitys;


	if($obj==false){
		$jg="f";
		return $jg;
	}else{
		return $objsuccess;
	}
}