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

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow = isset($_GET['time']) ? $_GET['time'] : date('Y-m-d H:i:s');
	$delete = isset($_POST['delete']) ? $_POST['delete'] : '';

	// var_dump($_COOKIE);

	echo "<center>";
	echo "<h1>药房管理</h1>";
	echo "<br><b>亲爱的 $stf_name ，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	for($i = 0; $i < count($delete); $i ++)
	{
		$drug_id = $delete[$i];
		$s = "update drug set DRUG_STORE = 0 where DRUG_NO = '{$drug_id}'";
		$rst = mysqli_query($lnk, $s);
	}

	echo "<br><br><br>删除过期药品成功<br><br><br>";
	echo "<form action='chemist.php'>";
	echo "<input type='submit' value='确认'>";
	echo "</form>";	
	echo "</center>";


?>