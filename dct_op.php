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
//insert into doctor values('0', 'huang', '0', '男', '1996-01-01', '专家', '11122233344', '0')
	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = date('Y-m-d H:i:s');
	$option = $_POST['option'];

	echo "<center>";
	echo "<br><b>尊敬的医生 $dct_name ，您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";

	// var_dump($_COOKIE);
	if($option == '诊断')
	{
		//显示所有对应医生且已经挂号的预约患者信息，按时间先后顺序排列
		$s = "select * from appointment, patient where appointment.PTT_NO = patient.PTT_NO and DCT_NO = {$dct_id} and (APT_STATE = 1 or APT_STATE = 2) order by APT_DATE"; 
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a){
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>患者编号</th>";
			echo "<th>患者姓名</th>";
			echo "<th>状态</th>";
			echo "<th>诊断</th>";
			echo "</tr>";
			do{
				echo "<tr>";
				echo "<td>{$a['PTT_NO']}</td>";
				echo "<td>{$a['PTT_NAME']}</td>";
				if($a['APT_STATE'] == 1)
				{
					echo "<td>未处理</td>";
				}
				else if($a['APT_STATE'] == 2)
				{
					echo "<td style='color:red'>诊疗中</td>";
				}
				echo "<form action='diagnosis.php?name={$a['PTT_NO']}&time={$datenow}' method='post'>";
				echo "<td><input type='submit' value='诊断'></td>";
				echo "</form>";
				echo "</tr>";

				$a = mysqli_fetch_assoc($rst);
			}while($a);
			echo "</table> ";
			echo "<br><br><br><br><br><br><br>";
		}
		else
		{
			echo "暂无患者！";
		}
	}

	if($option=='查看检查历史')
	{
		$s = "select * from diagnosis, patient where diagnosis.PTT_NO = patient.PTT_NO and  DCT_NO = '{$dct_id}'";
		$rst = mysqli_query($lnk, $s);
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>诊疗时间</th>";
		echo "<th>患者姓名</th>";
		echo "<th>病情名称</th>";
		echo "<th>病情描述</th>";
		echo "</tr>";
		while($a = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$a['DIAG_DATE']}</td>";
			echo "<td>{$a['PTT_NAME']}</td>";
			echo "<td>{$a['DIAG_NAME']}</td>";
			echo "<td>{$a['DIAG_DESC']}</td>";
			echo "</tr>";
		}
		echo "</table> ";
		echo "<br><br><br><br><br><br><br>";
	}

	echo "<br><br>";
	echo "<form action='doctor.php?' method='post'>";
	echo "<input type='submit' value='返回'>";
	echo "</form>";
	echo "</center>";
	echo "<br><br>";
	echo "</center>";

?>