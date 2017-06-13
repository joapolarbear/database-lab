<?php
	include 'header.php';	
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_COOKIE["x"]; 
	$ptt_name = $_COOKIE["CK_PTT_NAME"];
	$datenow=date('Y-m-d H:i:s');

	// var_dump($_POST);

	echo "<center>";
	echo "<body>";

	echo "<h1>患者您好</h1>";
	echo "<h2>亲爱的 $ptt_name </h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	// echo "您可以进行的操作：<br><br>";

	echo "<div class='middle'>";

	echo "<form action='ptt_op.php' method='post'>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='预约'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='取消预约'></div>";

	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='修改个人信息'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='查看个人病历'></div>";
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