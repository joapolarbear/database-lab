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
	$ptt_rst = isset($_POST['ptt_rst']) ? $_POST['ptt_rst'] : '';

	$s = "select * from doctor where DCT_NO = '{$dct_id}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	$dept = $a['DEPT_NAME'];

	echo "<center>";
	echo "<h1>{$dept} 检查</h1>";
	echo "<br><b>亲爱的 $dct_name 医生，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	//查询该患者未处理的检查单，对应相应的科室部门
	$s = "select * from diagnosis, checklist where diagnosis.CL_NO = checklist.CL_NO and CL_STATE = 1 and PTT_NO = '{$ptt_id}' and DEPT_NAME = '{$dept}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	if($a)
	{
		$cl_id = $a['CL_NO'];
		echo "患者 {$ptt_id} 检查成功<br><br>";

		$s = "update checklist set CL_STATE = 2, RESULT = '{$ptt_rst}' ,CL_DCT = '{$dct_id}' where 	CL_NO = '{$cl_id}'";
		$rst = mysqli_query($lnk, $s);
	}
	else 
	{
		echo "患者 {$ptt_id} 不能检查 {$dept} 项目，请先开检查单或缴费或往相应部门检查<br><br>";
	}

	echo "<br><br>";
	echo "<form action='check.php?time=$datenow' method='post'>";
	echo "<input type='submit' value='确认'>";
	echo "</form>";
	echo "</center>";
	echo "<br><br>";
	echo "</center>";
?>