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
	$datenow=isset($_GET['time']) ? $_GET['time'] : date('Y-m-d H:i:s');
	$option = isset($_POST['option']) ? $_POST['option'] : '';

	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$pro_time = isset($_POST['pro_time']) ? $_POST['pro_time'] : '';
	$exp_time = isset($_POST['exp_time']) ? $_POST['exp_time'] : '';
	$inprice = isset($_POST['inprice']) ? $_POST['inprice'] : '';
	$price = isset($_POST['price']) ? $_POST['price'] : '';
	$amount = isset($_POST['amount']) ? $_POST['amount'] : '';

	echo "<center>";
	echo "<h1>药房管理</h1>";
	echo "<br><b>亲爱的 $stf_name ，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	$id = strtr($datenow, array(' '=>''));
	$id = "{$id}{$stf_id}";

	$s = "insert into drug values('{$id}', '{$name}', '{$pro_time}', '{$exp_time}', {$inprice}, {$price}, {$amount}, '{$datenow}')";
	$rst = mysqli_query($lnk, $s);
	$s = "insert into drugmanage values('{$stf_id}', '{$id}', 1, '{$datenow}', {$amount})";
	$rst = mysqli_query($lnk, $s);

	if($rst) echo "您已成功入药";
	else echo "入药失败";

	echo "<br><br><br>";
	echo "<form action='chemist.php'>";
	echo "<input type='submit' value='确认'>";
	echo "</form>";	

	echo "</center>";
?>