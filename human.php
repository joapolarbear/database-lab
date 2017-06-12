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
	// var_dump($_COOKIE);

	echo "<center>";
	echo "<h1>管理员</h1>";
	echo "<h2>人事管理</h2>";
	echo "<br><b>亲爱的 $stf_name ，您好</b><br><br>";
	echo "您是管理员，您拥有系统最高权限<br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	


?>