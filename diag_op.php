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
	$option = $_POST['option'];

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "<h2>您正在诊断患者 {$a['PTT_NAME']}</h2>";
	echo "您本次登录时间为：$datenow <br>";

	if($option == '患者信息')
	{
		echo "<div class='middle'>";
		echo "<div class='row2'>患者信息</div>";
		echo "<div class='row3'>患者编号：{$a['PTT_NO']}</div>";
		echo "<div class='row3'>患者姓名：{$a['PTT_NAME']}</div>";
		echo "<div class='row3'>患者性别：{$a['PTT_SEX']}</div>";
		echo "<div class='row3'>患者电话：{$a['PTT_TEL']}</div>";
		echo "<div class='row3'>患者地址：{$a['PTT_ADDR']}</div>";
		echo "</div>";
	}
	else if($option == '患者病历')
	{
		$s = "select * from diagnosis, doctor where diagnosis.DCT_NO = doctor.DCT_NO and PTT_NO ='{$ptt_id}'";
		$rst = mysqli_query($lnk, $s);
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='4'>患者病历</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>诊疗时间</th>";
		echo "<th>医生姓名</th>";
		echo "<th>病情名称</th>";
		echo "<th>病情描述</th>";
		echo "</tr>";
		while($a = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$a['DIAG_DATE']}</td>";
			echo "<td>{$a['DCT_NAME']}</td>";
			echo "<td>{$a['DIAG_NAME']}</td>";
			echo "<td>{$a['DIAG_DESC']}</td>";
			echo "</tr>";
		}
		echo "</table> ";
	}
	else if($option == '诊断')
	{
		echo "<div class='middle'>";
		echo "<form action='diag_check.php?name1=$ptt_id&time={$datenow}' method='post'>";
		echo "<div class='row'>病名：<input type='text' name='what'></div>";
		echo "<div class='row'>病情描述：<input type='text' name='desc'></div>";
		echo "<div class='row2'><input class='btn' type='submit' name='option' value='下一步'></div>";
		echo "</form>";
		echo "</div>";
	}
	else if($option = '结束诊断')
	{
		$s = "update appointment set APT_STATE = 3 where PTT_NO = {$ptt_id} and DCT_NO = {$dct_id} and (APT_STATE = 1 or APT_STATE = 2)";
		$rst = mysqli_query($lnk, $s);
		header("Location: http://127.0.0.1:8000/doctor.php");
	}
	else
	{
		echo "<div class='middle'>";
		echo '未选择功能';
		echo "</div>";
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