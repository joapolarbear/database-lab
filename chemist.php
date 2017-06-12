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
	$datenow=date('Y-m-d H:i:s');
	// var_dump($_COOKIE);

	echo "<center>";
	echo "<h1>药房管理</h1>";
	echo "<br><b>亲爱的 $stf_name ，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div id='container' style='width:600px'>";

	echo "<div id='content1' style='height:320px;width:300px;float:left;'>";
	echo "<form action='chemist_op.php?time=$datenow' method='post'>";
	echo "<input style = 'background-color:White; color: Black;', type='submit' name ='option' value='入药'><br><br>";
	echo "<input type='submit' name ='option' value='查看药品'><br><br>";
	//echo "<input type='submit' name ='option' value='查看药品'><br><br>";
	//echo "<input type='submit' name ='option' value='查看科室'><br><br>";
	echo "</div>";

	echo "<div id='content2' style='height:320px;width:300px;float:left;'>";
	echo "<input type='submit' name ='option' value='出药'><br><br>";
	echo "<input type='submit' name ='option' value='更新药品'><br><br>";
	//echo "<input type='submit' name ='option' value='预约医生'><br><br>";
	// echo "<input type='submit' name ='option' value='取消预约'><br><br>";
	echo "</div>";
	echo "<input type='submit' name ='option' value='退出登录'><br><br>";
	echo "</form>";
	echo "</center>";


?>