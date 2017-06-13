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

	$kind = isset($_POST['kind']) ? $_POST['kind'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$sex = isset($_POST['sex']) ? $_POST['sex'] : '';
	$birth = isset($_POST['birth']) ? $_POST['birth'] : '';
	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
	$dept = isset($_POST['dept']) ? $_POST['dept'] : '';

	// var_dump($_COOKIE);

	echo "<center>";
	echo "<body>";
	echo "<h1>管理员</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您是管理员，您拥有系统最高权限<br>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";

	if($kind == '' || $id == '' || $name == '' || $sex == '' || $birth == '' || $title == '' || $tel == '' || $dept == '')
	{
		echo "信息不完整<br><br>";
	}
	else if($kind == 'doctor')
	{
		$s = "insert into doctor values('{$id}', '{$name}', '1', '{$sex}', '{$birth}', '{$title}', '{$tel}', '{$dept}', 0)";
		$rst = mysqli_query($lnk, $s);
		if($rst) echo "添加医生 {$name} 成功";
		else echo "添加医生 {$name} 失败";
	}
	else if($kind == 'clerk' || $kind == 'dean' || $kind == 'chemist')
	{
		$s = "insert into staff values('{$id}', '1', '{$name}', '{$sex}', '{$birth}', '{$title}', '{$tel}', '{$dept}', 0)";
		$rst = mysqli_query($lnk, $s);
		if($rst) echo "添加职员 {$name} 成功";
		else echo "添加职员 '{$name}' 失败";
	}
	else
	{
		echo "请选择类型<br><br>";
	}
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='dean.php?' method='post'>";
	echo "<input class='btn' type='submit' value='确认'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>
