<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 公共控制器
 * @author wangdong
 *
 * TODO
 * 后缀带_iframe的ACTION是在iframe中加载的，用于统一返回格式
 */
class CommonController extends Controller {
    function _initialize() {
        if (IS_AJAX && IS_GET) C('DEFAULT_AJAX_RETURN', 'html');
        self::check_admin();
        //记录上次每页显示数
        if (I('get.grid') && I('post.rows')) cookie('pagesize', I('post.rows', C('DATAGRID_PAGE_SIZE'), 'intVal'));

    }

    /**
     * 判断用户是否已经登陆
     */
    final public function check_admin() {
        if (CONTROLLER_NAME == 'Index' && in_array(ACTION_NAME, array('login', 'code'))) {
            return true;
        }
        if (!session('users')) {
            /*下面为微信验证
            $code=$_GET['code'];
            if(empty($code)){
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ed2e3d5aeb3cfd1&redirect_uri=weixin.xuebaoruye.com&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
            Header("Location:".$url);
            } else {
                session("code",$code);
                $auth_code=session("code");
                //if(!empty($auth_code)){
                    //获取到code后判断
                $Corpid="wx5ed2e3d5aeb3cfd1";
                $secrept="bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
                $url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=wx5ed2e3d5aeb3cfd1&corpsecret=bekg-NY7fEx76lndg8Q9SzOIcNTPjItTBTSu2Kv4mYfr5tfv3aOrd4qeK1wkBqGh";
                $json=file_get_contents($url);
                $arr=json_decode($json, true);
                $access_token=$arr["access_token"];
                session("access_token",$access_token);
                $posturl="https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=".$access_token."&code=".$auth_code;
                $json_user=file_get_contents($posturl);
                $arr_user=json_decode($json_user,true);
                $useraccount=$arr_user["UserId"];
                $sql="select b.fuserid,b.fcustomerid,b.fdefaultorgid,fcustomernumber,b.fcustomermasterid,fisadmin,a.fname  from t_sec_user a,t_cp_userprofile b where a.fuserid=b.fuserid and a.fname='".$useraccount."' ";
                //在数据库中后台检测
                $M=new \Think\Model();
                $rst=$M->query($sql);
                if($rst)
                {
                    foreach($rst as $row){
                        session('users',$row["fname"]);
                        session('userid',$row['fuserid']);
                        session('custid',$row['fcustomerid']);
                        $M2=new \Think\Model();
                        $rs=$M2->query("select fisshy from t_bd_customer where fcustid=".$row['fcustomerid']."");
                        foreach($rs as $ro)
                        {
                            $typeid=$ro["fisshy"];
                        }
                        if($typeid=="1")
                        {
                            $this->success('登录成功','/Home/Shy');
                        }else{
                            $this->success('登录成功','/');
                        }
                    }
                }else{
                    $this->error('当前用户没有在金蝶系统中关联不能登录！'.$useraccount.HTTP_REFERER);
                }



                if (IS_AJAX && IS_GET) {
                    exit('<div style="padding:6px">请先<a href="' . U('Index/') . '">登录</a></div>');
                } else {
                    //$this->display('User/login');
                    $this->error('正在检测用户合法性', U('Index/'), 1);
                    //$this->redirect('Home/User/login');
                }
            }*/

            if (IS_AJAX && IS_GET) {
                exit('<div style="padding:6px">请先<a href="' . U('Index/login') . '">登录</a></div>');
            } else {
                //$this->display('User/login');
                $this->error('正在检测用户合法性', U('Index/login'), 1);
                //$this->redirect('Home/User/login');
            }
        }
    }

    /**
     * 空操作，用于输出404页面
     */
    public function _empty() {
        //针对后台ajax请求特殊处理
        if (!IS_AJAX) send_http_status(404);
        if (IS_AJAX && IS_POST) {
            $data = array('info' => '请求地址不存在或已经删除', 'status' => 0, 'total' => 0, 'rows' => array());
            $this->ajaxReturn($data);
        } else {
            $this->display('Common:404');
        }
    }


    /**
     * +----------------------------------------------------------
     * Export Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
     * +----------------------------------------------------------
     * @param $expTitle     string File name
     * +----------------------------------------------------------
     * @param $expCellName  array  Column name
     * +----------------------------------------------------------
     * @param $expTableData array  Table data
     * +----------------------------------------------------------
     */
    public function exportExcel($expTitle, $expCellName, $expTableData) {
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory");

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        //vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        //	$objPHPExcel = \PHPExcel_IOFactory::load($fileName);
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * +----------------------------------------------------------
     * Import Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
     * +----------------------------------------------------------
     * @param  $file   upload file $_FILES
     * +----------------------------------------------------------
     * @return array   array("error","message")
     * +----------------------------------------------------------
     */
    public function importExecl($file) {
        if (!file_exists($file)) {
            return array("error" => 0, 'message' => 'file not found!');
        }
        Vendor("PHPExcel.PHPExcel.IOFactory");
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        try {
            $PHPReader = $objReader->load($file);
        } catch (Exception $e) {
        }
        if (!isset($PHPReader)) return array("error" => 0, 'message' => 'read error!');
        $allWorksheets = $PHPReader->getAllSheets();
        $i = 0;
        foreach ($allWorksheets as $objWorksheet) {
            $sheetname = $objWorksheet->getTitle();
            $allRow = $objWorksheet->getHighestRow();//how many rows
            $highestColumn = $objWorksheet->getHighestColumn();//how many columns
            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $array[$i]["Title"] = $sheetname;
            $array[$i]["Cols"] = $allColumn;
            $array[$i]["Rows"] = $allRow;
            $arr = array();
            $isMergeCell = array();
            foreach ($objWorksheet->getMergeCells() as $cells) {//merge cells
                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
                    $isMergeCell[$cellReference] = true;
                }
            }
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                $row = array();
                for ($currentColumn = 0; $currentColumn < $allColumn; $currentColumn++) {
                    ;
                    $cell = $objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn + 1);
                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn - 1);
                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
                    $address = $col . $currentRow;
                    $value = $objWorksheet->getCell($address)->getValue();
                    if (substr($value, 0, 1) == '=') {
                        return array("error" => 0, 'message' => 'can not use the formula!');
                        exit;
                    }
                    if ($cell->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC) {
                        $cellstyleformat = $cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat();
                        $formatcode = $cellstyleformat->getFormatCode();
                        if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
                            $value = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                        } else {
                            $value = PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
                        }
                    }
                    if ($isMergeCell[$col . $currentRow] && $isMergeCell[$afCol . $currentRow] && !empty($value)) {
                        $temp = $value;
                    } elseif ($isMergeCell[$col . $currentRow] && $isMergeCell[$col . ($currentRow - 1)] && empty($value)) {
                        $value = $arr[$currentRow - 1][$currentColumn];
                    } elseif ($isMergeCell[$col . $currentRow] && $isMergeCell[$bfCol . $currentRow] && empty($value)) {
                        $value = $temp;
                    }
                    $row[$currentColumn] = $value;
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]["Content"] = $arr;
            $i++;
        }
        spl_autoload_register(array('Think', 'autoload'));//must, resolve ThinkPHP and PHPExcel conflicts
        unset($objWorksheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        return array("error" => 1, "data" => $array);
    }

    /**
     * 读取当前购物车数量合计
     */
    public function getbasketcount() {
        $buyerid = session("userid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcustBasket " . $buyerid . "");
        foreach ($list as $row) {
            echo $row['qty'];
        }
    }

    /**
     * 调用微信发送消息
     */
    public function sendweixinmess() {
        $content = urlencode(I("content", "订单来了！"));
        $FID = I("fid", 0);
        $M2 = new \Think\Model();
        $rr = $M2->query("exec Jp_getorder_songhuoyuan " . $FID . "");
        if ($rr) {
            foreach ($rr as $row) {
                $touser = $row["touser"];
            }
        }
        if (empty($touser)) {
            $touser = "tzb|season9120";
        }
        //$touser="tzb|season9120";
        $access_token = session("access_token");
        $url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=" . $access_token;
        $data = json_encode(array("touser" => $touser, "msgtype" => "text", "toparty" => "", "agentid" => 26, "text" => array("content" => $content), "safe" => 0));
        $ll = send_post($url, urldecode($data));
        if ($ll) {
            echo $ll;
        }
    }

    public function getcustneiqin() {
        $custid = session("custid");
        $M = new \Think\Model();
        $list = $M->query("exec Jp_getcust_neiqin " . $custid . "");
        foreach ($list as $row) {
            $name = $row["fname"];
            $mobile = $row['fmobile'];
        }
        echo json_encode(array("name" => $name, "mobile" => $mobile));
    }
}