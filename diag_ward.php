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
	$drug = isset($_POST['drug']) ? $_POST['drug'] : '';
	$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
	$usage = isset($_POST['usage']) ? $_POST['usage'] : '';

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
		//插入药单新行，并插入检查表DL_NO域，处理检查单信息
		$id = strtr($datenow, array(' '=>''));
		$id = "{$id}{$dct_id}";
		$s = "insert into druglist values('{$id}', 0, '{$datenow}', NULL)";
		$rst = mysqli_query($lnk, $s);

		$s = "update diagnosis set DL_NO = '{$id}' where DIAG_NO = '{$diag}'";
		$rst = mysqli_query($lnk, $s);
		for($i = 0; $i < count($drug); $i = $i + 1)
		{
			$s = "insert into listdrug values('{$id}', '{$drug[$i]}', '{$usage	[$i]}', {$amount[$i]})";
			$rst = mysqli_query($lnk, $s);
		}
	}
	
	echo "<form action='diag_final.php?name1=$ptt_id&diag=$diag&time={$datenow}' method='post'>";
	echo "<div class = 'leftdiv'>";
	echo "楼栋：<input type='number' name='build'><br><br>";
	echo "楼层：<input type='number' name='floor'><br><br>";
	echo "房间：<input type='number' name='room'><br><br>";
	echo "床号：<input type='number' name='bed'><br><br>";
	echo "</div>";
	echo "<input type='submit' name='option' value='确认'>";
	echo "<input type='submit' name='option' value='跳过'>";
	echo "</form>";
	echo "<br><br><b>医院病床信息</b><br><br>";

	//床位信息
	$s = "select * from ward where WD_STATE = 0 order by WD_BLD, WD_FLOOR, WD_ROOM, WD_BED";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	if($a)
	{
		echo "<table border = '1'>";
		echo "<tr>";
		echo "<th>编号</th>";
		echo "<th>楼栋</th>";
		echo "<th>楼层</th>";
		echo "<th>房间</th>";
		echo "<th>床号</th>";
		do{
			echo "<tr>";
			echo "<td>{$a['WD_NO']}</td>";
			echo "<td>{$a['WD_BLD']}</td>";
			echo "<td>{$a['WD_FLOOR']}</td>";
			echo "<td>{$a['WD_ROOM']}</td>";
			echo "<td>{$a['WD_BED']}</td>";
			echo "</tr>";
			$a = mysqli_fetch_assoc($rst);
		}while($a);
	}
	else{
		echo "没有空闲病床";
	}

?>