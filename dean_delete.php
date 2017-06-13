<?php
	include "header.php";
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

	$option = isset($_POST['option']) ? $_POST['option'] : '';

	// var_dump($_COOKIE);

	echo "<center>";
	echo "<body>";
	echo "<h1>管理员</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您是管理员，您拥有系统最高权限<br>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";
	if($option == '取消')
	{
		header("Location: http://127.0.0.1:8000/dean.php");
	}
	else if($kind == '' || $id == '' || $name == '')
	{
		echo "信息不完整";
	}
	else if($kind == 'doctor')
	{
		$s = "select * from doctor where DCT_NO = '{$id}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			if($a['DCT_NAME'] == $name)
			{
				$s = "delete from doctor where DCT_NO = '{$id}'";
				$rst = mysqli_query($lnk, $s);
				if($rst) echo "删除医生 {$name} 成功";
				else echo "删除医生 {$name} 失败";
			}
			else 
			{
				echo "医生姓名输入错误";
			}
		}
		else
		{
			echo "不存在该医生";
		}
	}
	else if($kind == 'clerk' || $kind == 'dean' || $kind == 'chemist')
	{
		$s = "select * from staff where STF_NO = '{$id}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			if($a['STF_NAME'] == $name)
			{
				$s = "delete from staff where STF_NO = '{$id}'";
				$rst = mysqli_query($lnk, $s);
				if($rst) echo "删除职员 {$name} 成功";
				else echo "删除职员 {$name} 失败";
			}
			else 
			{
				echo "职员姓名输入错误";
			}
		}
		else
		{
			echo "不存在该职员";
		}
	}
	else
	{
		echo "请选择类型";
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
