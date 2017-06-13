<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_GET['name1'];
	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];
	$what = $_POST['what'];
	$desc = $_POST['desc'];

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "<h2>您正在诊断患者 {$a['PTT_NAME']}</h2>";
	echo "您本次登录时间为：$datenow <br>";
	//插入诊断表新行
	$id = strtr($datenow, array(' '=>''));
	$id = "{$id}{$dct_id}";
	$s = "insert into diagnosis values('{$id}', '{$datenow}', '{$what}', '{$desc}', NULL, NULL, NULL, '{$dct_id}', '{$ptt_id}')";
	$rst = mysqli_query($lnk, $s);

	echo "<div class='middle'>";
	echo "<form action='diag_drug.php?name1=$ptt_id&diag=$id&time={$datenow}' method='post'>";
	echo "<div class='row'>检查项目：<input type='text' name='program'></div>";
	echo "<div class='row'>检查科室：<input type='text' name='dept'></div>";
	
	echo "<div class='row2'>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='确认'></span>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='跳过'></span>";
	echo "</div>";

	echo "</form>";
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='diagnosis.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";


?>