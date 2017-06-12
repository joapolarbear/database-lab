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
	$diag = $_GET['diag'];

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	
	$build = isset($_POST['build']) ? $_POST['build'] : '';
	$floor = isset($_POST['floor']) ? $_POST['floor'] : '';
	$room = isset($_POST['room']) ? $_POST['room'] : '';
	$bed = isset($_POST['bed']) ? $_POST['bed'] : '';

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<br><b>尊敬的 $dct_name 医生, 您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<br><b>您正在诊断患者 {$a['PTT_NAME']}</b><br><br>";
	echo "<br><br>";

	if($option == '确认')
	{
		$s = "select * from ward where WD_BLD = $build and WD_FLOOR	= $floor and WD_ROOM = $room and WD_BED = $bed and WD_STATE = 0";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		//有符合要求的床位
		if($a){
			//插入住院单新行，并插入检查表WL_NO域，处理检查单信息
			$id = strtr($datenow, array(' '=>''));
			$id = "{$id}{$a['WD_NO']}";
			$s = "insert into hospitallist values('{$id}', '{$datenow}', NULL, NULL, NULL, 0, '{$a['WD_NO']}')";
			$rst = mysqli_query($lnk, $s);

			$s = "update diagnosis set WL_NO = '{$id}' where DIAG_NO = '{$diag}'";
			$rst = mysqli_query($lnk, $s);
		}
		else
		{
			echo "输入床位不存在或者不是空闲状态<br><br>";
		}
		
	}

	$s = "select * from diagnosis where DIAG_NO = '{$diag}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	echo "<form action='diagnosis.php?name=$ptt_id&diag=$diag&time={$datenow}' method='post'>";
	echo "<div class = 'leftdiv'>";
	echo "病名：{$a['DIAG_NAME']}<br><br>";
	echo "描述：{$a['DIAG_DESC']}<br><br>";
	echo "检查单：{$a['CL_NO']}<br><br>";
	echo "药单：{$a['DL_NO']}<br><br>";
	echo "住院单：{$a['HL_NO']}<br><br>";
	echo "</div>";
	echo "<input type='submit' name='option' value='确认'>";
	echo "<input type='submit' name='option' value='取消'>";
	echo "</form>";
?>