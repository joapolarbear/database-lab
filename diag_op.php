<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>医院管理系统</title>
	<link rel="shortcut icon" type="image/x-icon" href="myapp.ico" />
	<style type="text/css">
		.leftdiv{
			width: 300px;
			//float: left;
			text-align: left;
		}
	</style>
</head>
<?php
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_GET['name1'];
	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];
	$option = $_POST['option'];

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<br><b>尊敬的 $dct_name 医生, 您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<br><b>您正在诊断患者 {$a['PTT_NAME']}</b><br><br>";
	echo "<br><br>";

	if($option == '患者信息')
	{
		echo "<div class = 'leftdiv'>";
		echo "患者编号： {$a['PTT_NO']}<br><br>";
		echo "患者姓名： {$a['PTT_NAME']}<br><br>";
		echo "患者性别： {$a['PTT_SEX']}<br><br>";
		echo "患者电话： {$a['PTT_TEL']}<br><br>";
		echo "患者地址： {$a['PTT_ADDR']}<br><br>";
		echo "</div>";
	}
	else if($option == '患者病历')
	{

	}
	else if($option == '诊断')
	{
		echo "<form action='diag_check.php?name1=$ptt_id&time={$datenow}' method='post'>";
		echo "<div class = 'leftdiv'>";
		echo "病名：<input type='text' name='what'><br><br>";
		echo "病情描述：<input type='text' name='desc'><br><br>";
		echo "</div>";
		echo "<input type='submit' name='option' value='下一步'>";
		echo "</form>";
	}
	else if($option = '结束诊断')
	{
		$s = "update appointment set APT_STATE = 3 where PTT_NO = {$ptt_id} and DCT_NO = {$dct_id} and (APT_STATE = 1 or APT_STATE = 2)";
		$rst = mysqli_query($lnk, $s);
		header("Location: http://127.0.0.1:8000/doctor.php");
	}
	else
	{
		echo '未选择功能';
	}

?>