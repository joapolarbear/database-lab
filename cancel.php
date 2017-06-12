<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_COOKIE["x"]; 
	$ptt_name = $_COOKIE['CK_PTT_NAME'];
	$dct_id = $_GET['name'];
	$datenow = date('Y-m-d H:i:s');

	$s = "update appointment set APT_STATE = 4 where PTT_NO = {$ptt_id} and DCT_NO = {$dct_id} and (APT_STATE = 0 or APT_STATE = 1)";
	$rst = mysqli_query($lnk, $s);

	$s2 = "select * from doctor where DCT_NO ='{$dct_id}'";
	$rst2 = mysqli_query($lnk, $s2);
	$array2 = mysqli_fetch_assoc($rst2);
	$name = $array2['DCT_NAME'];

	echo "<center>";
	echo "<body>";

	echo "<h1>患者您好</h1>";
	echo "<h2>亲爱的 $ptt_name </h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";
	echo "您已取消预约 $name 医生！";
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='patient.php?' method='post'>";
	echo "<input class='btn' type='submit' value='确认'>";
	echo "</form>";
	echo "</div>";
	
	echo "</center>";
	echo "</body>";
	echo "</html>";
?>