<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_COOKIE["x"]; 
	$ptt_name = $_COOKIE['CK_PTT_NAME'];
	$dct_id = $_GET['name'];
	$datenow=date('Y-m-d H:i:s');

	$s = "select * from doctor where DCT_NO ='{$dct_id}' and DCT_ON = 1";
	// echo $s;
	$rst = mysqli_query($lnk, $s);
	$array = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";

	echo "<h1>患者您好</h1>";
	echo "<h2>亲爱的 $ptt_name </h2>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<div class='middle'>";
	if($array == null)
	{
		echo "这个医生不存在！预约失败";
	}
	else
	{
		$s1 = "insert into appointment values('{$dct_id}', '{$ptt_id}', '{$datenow}', '0')";
		//echo $s1;
		$rst1 = mysqli_query($lnk, $s1);	
		$s2 = "select * from doctor where DCT_NO ='{$dct_id}'";
		$rst2 = mysqli_query($lnk, $s2);
		$array2 = mysqli_fetch_assoc($rst2);
		$name = $array2['DCT_NAME'];
		echo "您已成功预约 $name 医生！";
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