<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_COOKIE['x']; 
	$ptt_name = $_COOKIE['CK_PTT_NAME'];
	$datenow=date('Y-m-d H:i:s');

	$ptt_name = $_POST['ptt_name'];
	$ptt_sex = $_POST['ptt_sex'];
	$ptt_tel = $_POST['ptt_tel'];
	$ptt_addr = $_POST['ptt_addr'];
	$ptt_birth = $_POST['ptt_birth'];
	$ptt_psw = $_POST['ptt_psw'];
	$ptt_psw1 = $_POST['ptt_psw1'];

	echo "<center>";
	echo "<body>";

	echo "<h1>患者您好</h1>";
	echo "<h2>亲爱的 $ptt_name </h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";

	if($ptt_name==null||$ptt_sex==null||$ptt_tel==null||$ptt_psw==null||$ptt_psw1==null)
	{
		echo "您的信息填写不全，请重新修改！<br>";
	}
	else
	{
		if($ptt_psw1 != $ptt_psw)
		{
			echo "您两次输入密码不一致，请重新输入！<br>";
		}
		else
		{
			$s = "update patient set PTT_NAME = '{$ptt_name}', PTT_SEX = '{$ptt_sex}', 
						PTT_PSW = '{$ptt_psw}', PTT_TEL='{$ptt_tel}', PTT_ADDR = '{$ptt_addr}', PTT_BIRTH = '{$ptt_birth}' where PTT_ID='{$ptt_id}'";
			$rst = mysqli_query($lnk, $s);
			echo "个人信息修改成功！";		
		}
	}

	echo "</div>";
	echo "<div class='middle'>";
	echo "<form action='patient.php?' method='post'>";
	echo "<input class='btn' type='submit' value='确认'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";


?>



