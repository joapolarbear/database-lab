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

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow=date('Y-m-d H:i:s');

	$s = "select * from doctor where DCT_NO = '{$dct_id}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	$dept = $a['DEPT_NAME'];

	echo "<center>";
	echo "<h1>{$dept} 检查</h1>";
	echo "<br><b>亲爱的 $dct_name 医生，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div id='container' style='width:600px'>";

	echo "<form action='check_final.php?time=$datenow' method='post'>";
	echo "
		<br><br><br><b>患者身份验证</b><br><br><br>
		身份证号: <input type='text' name='ptt_id'> <br><br>
		姓名: <input type='text' name='ptt_name'> <br><br>
		检查结果: <input type='text' name='ptt_rst'> <br><br>
		";

	echo "<input style = 'background-color:White; color: Black;', type='submit' name ='option' value='确认'><br><br>";

	echo "</form>";
	echo "</div>";

	echo "<br><br>";
	echo "<form action='index.php?' method='post'>";
	echo "<input type='submit' value='退出登录'>";
	echo "</form>";
	echo "</center>";
	echo "<br><br>";

	echo "</center>";


?>