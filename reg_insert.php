<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$ptt_id = $_COOKIE["ck_ptt_id"]; 
	$dct_id = $_GET['name'];
	$datenow=date('Y-m-d H:i:s');

	echo "<center>";
	echo "<body>";

	echo "<h1>收费处</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br>";

	$s = "select * from doctor where DCT_NO ='{$dct_id}' and DCT_ON = 1";
	// echo $s;
	$rst = mysqli_query($lnk, $s);
	$array = mysqli_fetch_assoc($rst);

	echo "<div class='middle'>";
	if($array == null)
	{
		echo "这个医生不存在！挂号失败";
	}
	else
	{
		$s1 = "insert into appointment values('{$dct_id}', '{$ptt_id}', '{$datenow}', '1')";
		//echo $s1;
		$rst1 = mysqli_query($lnk, $s1);

		$s2 = "select * from patient where PTT_NO ='{$ptt_id}'";
		$rst2 = mysqli_query($lnk, $s2);
		$array2 = mysqli_fetch_assoc($rst2);

		echo "您已成功为患者 {$array2['PTT_NAME']} 挂号";
		echo "<br><br>";

		$s2 = "select * from doctor where DCT_NO ='{$dct_id}'";
		$rst2 = mysqli_query($lnk, $s2);
		$array2 = mysqli_fetch_assoc($rst2);
		echo "医生：{$array2['DCT_NAME']}";
		echo "<br><br>";
		echo "科室：{$array2['DEPT_NAME']}";
	}
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='clerk.php?' method='post'>";
	echo "<input class='btn' type='submit' value='返回'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>