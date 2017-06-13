<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow = date('Y-m-d H:i:s');

	echo "<center>";
	echo "<body>";

	echo "<h1>收费处</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br>";

	echo "<div class='middle'>";

	echo "<form action='pay_check.php?time=$datenow' method='post'>";
	echo "
		<div class='row2'><b>患者身份验证</b></div>
		<div class='row'>身份证号:<input type='text' name='ptt_id'></div>
		<div class='row'>姓名:<input type='text' name='ptt_name'></div>
		";

	echo "<div class='row2'><input class='btn', type='submit' name ='option' value='确认'></div>";

	echo "</form>";
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='clerk.php?' method='post'>";
	echo "<input class='btn' type='submit' value='返回'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>