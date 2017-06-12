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
	$what = $_POST['what'];
	$desc = $_POST['desc'];

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<br><b>尊敬的 $dct_name 医生, 您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<br><b>您正在诊断患者 {$a['PTT_NAME']}</b><br><br>";
	echo "<br><br>";
	//插入诊断表新行
	$id = strtr($datenow, array(' '=>''));
	$id = "{$id}{$dct_id}";
	$s = "insert into diagnosis values('{$id}', '{$datenow}', '{$what}', '{$desc}', NULL, NULL, NULL, '{$dct_id}', '{$ptt_id}')";
	$rst = mysqli_query($lnk, $s);

	echo "<form action='diag_drug.php?name1=$ptt_id&diag=$id&time={$datenow}' method='post'>";
	echo "<div class = 'leftdiv'>";
	echo "检查项目：<input type='text' name='program'><br><br>";
	echo "检查科室：<input type='text' name='dept'><br><br>";
	echo "</div>";
	echo "<input type='submit' name='option' value='确认'>";
	echo "<input type='submit' name='option' value='跳过'>";
	echo "</form>";
?>