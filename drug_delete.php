<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow = isset($_GET['time']) ? $_GET['time'] : date('Y-m-d H:i:s');
	$delete = isset($_POST['delete']) ? $_POST['delete'] : '';

	// var_dump($_COOKIE);

	echo "<center>";
	echo "<body>";
	echo "<h1>药房管理</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	for($i = 0; $i < count($delete); $i ++)
	{
		$drug_id = $delete[$i];
		$s = "update drug set DRUG_STORE = 0 where DRUG_NO = '{$drug_id}'";
		$rst = mysqli_query($lnk, $s);
	}

	echo "<div class='middle'>删除过期药品成功</div>";

	echo "<div class='middle'>";
	echo "<form action='chemist.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>