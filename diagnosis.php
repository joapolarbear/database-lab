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
//insert into doctor values('0', 'huang', '0', '男', '1996-01-01', '专家', '11122233344', '0')
	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];
	$ptt_id = $_GET['name'];

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	$diag = isset($_GET['diag']) ? $_GET['diag'] : '';

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<br><b>尊敬的 $dct_name 医生，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<br><b>您正在诊断患者 {$a['PTT_NAME']}</b><br><br>";

	//设置诊疗进行中
	$s = "update appointment set APT_STATE = 2 where PTT_NO = {$ptt_id} and DCT_NO = {$dct_id} and APT_STATE = 1";
	$rst = mysqli_query($lnk, $s);

	echo "<div id='container' style='width:600px'>";

	echo "<div id='content1' style='height:320px;width:300px;float:left;'>";
	echo "<form action='diag_op.php?name1={$ptt_id}&time={$datenow}' method='post'>";
	echo "<input style = 'background-color:White; color: Black;', type='submit' name ='option' value='患者信息'><br><br>";
	echo "<input type='submit' name ='option' value='患者病历'><br><br>";
	echo "</div>";

	echo "<div id='content2' style='height:320px;width:300px;float:left;'>";
	echo "<input type='submit' name ='option' value='诊断'><br><br>";
	echo "<input type='submit' name ='option' value='结束诊断'><br><br>";
	echo "</form>";
	echo "</div>";

	if($option == '取消')
	{
		$s = "delete from diagnosis where DIAG_NO = {'$diag'}";
		$rst = mysqli_query($lnk, $s);
	}

?>