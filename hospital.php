<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow=date('Y-m-d H:i:s');

	echo "<center>";
	echo "<body>";
	echo "<h1>住院部</h1>";
	echo "<h2>亲爱的 $dct_name 护士，您好</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";

	echo "<form action='hospital_final.php?time=$datenow' method='post'>";
	echo "
		<div class='row2'><b>患者身份验证</b></div>
		<div class='row'>身份证号: <input type='text' name='ptt_id'></div>
		<div class='row'>姓名: <input type='text' name='ptt_name'></div>
		";

	echo "<div class='row2'>";
		echo "<span class='row'><input class='btn' type='submit' name ='option' value='住院'></span>";
		echo "<span class='row'><input class='btn' type='submit' name ='option' value='出院'></span>";
	echo "</div>";

	echo "</form>";
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='index.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";


?>