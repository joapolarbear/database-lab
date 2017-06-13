<?php
	include 'header.php';	
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = date('Y-m-d H:i:s');
	$option = $_POST['option'];

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	// var_dump($_COOKIE);
	if($option == '诊断')
	{
		//显示所有对应医生且已经挂号的预约患者信息，按时间先后顺序排列
		$s = "select * from appointment, patient where appointment.PTT_NO = patient.PTT_NO and DCT_NO = {$dct_id} and (APT_STATE = 1 or APT_STATE = 2) order by APT_DATE"; 
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a){
			echo "<table>";
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
				echo "<td><input class='btn' type='submit' value='诊断'></td>";
				echo "</form>";
				echo "</tr>";

				$a = mysqli_fetch_assoc($rst);
			}while($a);
			echo "</table> ";
		}
		else
		{
			echo "<div class='middle'>";
			echo "您暂无即将就诊的患者！";
			echo "</div>";
		}
	}

	if($option=='查看检查历史')
	{
		$s = "select * from diagnosis, patient where diagnosis.PTT_NO = patient.PTT_NO and  DCT_NO = '{$dct_id}'";
		$rst = mysqli_query($lnk, $s);
		echo "<table>";
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