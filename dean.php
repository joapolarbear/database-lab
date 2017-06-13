<?php
	include "header.php";
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow = date('Y-m-d H:i:s');
	// var_dump($_COOKIE);

	echo "<center>";
	echo "<body>";
	echo "<h1>管理员</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您是管理员，您拥有系统最高权限<br>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";

	echo "<form action='dean_op.php?time=$datenow' method='post'>";
	echo "<div class='row2'><input class='btn', type='submit' name ='option' value='添加人员'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='删除人员'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='查看人员'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='财务统计'></div>";
	echo "</form>";
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='index.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出登录'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>