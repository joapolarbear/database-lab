<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>医院管理系统</title>
	<link rel="shortcut icon" type="image/x-icon" href="myapp.ico" />
</head>

<?php
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow=date('Y-m-d H:i:s');

	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$ptt_name = isset($_POST['ptt_name']) ? $_POST['ptt_name'] : '';
	$option = isset($_POST['option']) ? $_POST['option'] : '';

	echo "<center>";
	echo "<h1>住院部</h1>";
	echo "<br><b>亲爱的 $dct_name 医生，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	$s = "select * from diagnosis, hospitallist where diagnosis.HL_NO = hospitallist.HL_NO and HL_STATE = 1 and PTT_NO = '{$ptt_id}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	if($a)
	{
		$wd_id = $a['WD_NO'];
		$hl_id = $a['HL_NO'];
		$s = "select * from ward where WD_NO = '{$wd_id}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		echo "为患者 {$ptt_id} 分配床位";
		echo "楼栋： {$a['WD_BLD']}<br><br>";
		echo "楼层： {$a['WD_FLOOR']}<br><br>";
		echo "房间： {$a['WD_ROOM']}<br><br>";
		echo "床位： {$a['WD_BED']}<br><br>";
		$s = "update ward set WD_STATE = 1 where WD_NO = '{$wd_id}'";
		$rst = mysqli_query($lnk, $s);
		$s = "update hospitallist set HL_STATE = 2, IN_TIME = '{$datenow}' ,DCT_NO = '{$dct_id}' where 	HL_NO = '{$hl_id}'";
		$rst = mysqli_query($lnk, $s);
	}
	else 
	{
		echo "患者 {$ptt_id} 不能住院，请先开住院单或缴费";
	}

	echo "<br><br>";
	echo "<form action='hospital.php?' method='post'>";
	echo "<input type='submit' value='确认'>";
	echo "</form>";
	echo "</center>";
	echo "<br><br>";
	echo "</center>";


?>