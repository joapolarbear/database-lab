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

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	$kind = isset($_POST['kind']) ? $_POST['kind'] : '';
	$dct_id = isset($_POST['dct_id']) ? $_POST['dct_id'] : ''; 
	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$dct_pwd = isset($_POST['dct_pwd']) ? $_POST['dct_pwd'] : '';
	$ptt_pwd = isset($_POST['ptt_pwd']) ? $_POST['ptt_pwd'] : '';

	$eq = '=';
	
	if($option == '挂号')
	{
		header("Location: http://127.0.0.1:8000/registrar.php");
	}
	else if($option == '收费')
	{
		header("Location: http://127.0.0.1:8000/pay.php");
	}
	else
	{
		
	}
?>

