<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];
	$ptt_id = $_GET['name'];

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	$diag = isset($_GET['diag']) ? $_GET['diag'] : '';

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	//设置诊疗进行中
	$s = "update appointment set APT_STATE = 2 where PTT_NO = {$ptt_id} and DCT_NO = {$dct_id} and APT_STATE = 1";
	$rst = mysqli_query($lnk, $s);

	echo "<div class='middle'>";

	echo "<form action='diag_op.php?name1={$ptt_id}&time={$datenow}' method='post'>";
	echo "<div class='row2'><input class='btn', type='submit' name ='option' value='患者信息'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='患者病历'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='诊断'></div>";
	echo "<div class='row2'><input class='btn' type='submit' name ='option' value='结束诊断'></div>";
	echo "</form>";

	echo "</div>";
	//最后一步医生按取消，回到该界面
	if($option == '取消')
	{
		$s = "delete from diagnosis where DIAG_NO = {'$diag'}";
		$rst = mysqli_query($lnk, $s);
	}

	echo "<div class='middle'>";
	echo "<form action='doctor.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";

?>