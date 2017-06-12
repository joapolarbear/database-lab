<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');
//insert into doctor values('0', 'huang', '0', '男', '1996-01-01', '专家', '11122233344', '0')
	$ptt_id = $_COOKIE['x']; 
	$ptt_name = $_COOKIE['CK_PTT_NAME'];
	$option = $_POST['option'];
	$datenow=date('Y-m-d H:i:s');

	echo "<center>";
	echo "<body>";

	echo "<h1>患者您好</h1>";
	echo "<h2>亲爱的 $ptt_name </h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	// var_dump($_COOKIE);
	if($option == '预约')
	{
		$s = "select * from doctor";
		$rst = mysqli_query($lnk, $s);
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>医生编号</th>";
		echo "<th>医生姓名</th>";
		echo "<th>医生性别</th>";
		echo "<th>医生职称</th>";
		echo "<th>医生科室</th>";
		echo "<th>医生电话</th>";
		echo "<th>医生出生日期</th>";
		echo "<th>预约医生</th>";
		echo "</tr>";
		while($array = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$array['DCT_NO']}</td>";
			echo "<td>{$array['DCT_NAME']}</td>";
			echo "<td>{$array['DCT_SEX']}</td>";
			echo "<td>{$array['DCT_TITLE']}</td>";

			// $s2 = "select * from dept where DEPT_NO = $array['DEPT_NO']";
			// $rst2 = mysqli_query($lnk, $s2);
			// $array2 = mysqli_fetch_assoc($rst2);
			// echo "<td>{$array2['DEPT_NAME']}</td>";
			echo "<td>{$array['DEPT_NAME']}</td>";

			echo "<td>{$array['DCT_TEL']}</td>";
			echo "<td>{$array['DCT_BIRTH']}</td>";
			echo "<form action='appoint.php?name={$array['DCT_NO']}' method='post'>";
			echo "<td><input class='btn' type='submit' value='预约'></td>";
			echo "</form>";
			echo "</tr>";
		}
		echo "</table> ";
	}

	if($option=='取消预约')
	{
		$s = "select * from appointment where PTT_NO = {$ptt_id} and APT_STATE = 0";
		// echo $s;
		$rst = mysqli_query($lnk, $s);
		$array = mysqli_fetch_assoc($rst);
		if($array){
			echo "<table>";
			echo "<tr>";
			echo "<th>医生编号</th>";
			echo "<th>医生姓名</th>";
			echo "<th>医生性别</th>";
			echo "<th>医生职称</th>";
			echo "<th>医生科室</th>";
			echo "<th>医生电话</th>";
			echo "<th>医生出生日期</th>";
			echo "<th>预约时间</th>";
			echo "<th>取消预约</th>";
			do
			{
				$s2 = "select * from doctor where DCT_NO = {$array['DCT_NO']}";
				$rst2 = mysqli_query($lnk, $s2);
				$array2 = mysqli_fetch_assoc($rst2);
				echo "<tr>";
				echo "<td>{$array2['DCT_NO']}</td>";
				echo "<td>{$array2['DCT_NAME']}</td>";
				echo "<td>{$array2['DCT_SEX']}</td>";
				echo "<td>{$array2['DCT_TITLE']}</td>";
				echo "<td>{$array2['DEPT_NAME']}</td>";
				echo "<td>{$array2['DCT_TEL']}</td>";
				echo "<td>{$array2['DCT_BIRTH']}</td>";

				echo "<td>{$array['APT_DATE']}</td>";

				echo "<form action='cancel.php?name={$array['DCT_NO']}' method='post'>";
				echo "<td><input class='btn' type='submit' value='取消'></td>";
				echo "</form>";
				echo "</tr>";

				$array = mysqli_fetch_assoc($rst);
			}while($array);
		}
		else{
			echo "<div class='middle'>您还没有预约信息！</div>";
		}
		// echo "<form action='cancel.php' method='post'>";
		// echo "本操作会取消您目前所有的预约，您确定要取消吗";
		// echo "<input type='submit' value='确定取消'>";		
	}

	if($option=='修改个人信息')
	{
		echo "<div class='middle'>";
		echo "<form action='ptt_alt.php' method='post'>";

		echo "<div class='row'>姓名:<input type='text' name='ptt_name'></div>";
		echo "<div class='row'>密码:<input type='password' name='ptt_psw'></div>";
		echo "<div class='row'>确认密码:<input type='password' name='ptt_psw1'></div>";
		echo "<div class='row'>性别：
				<input type='radio' name='ptt_sex' value='男'>男
				<input type='radio' name='new_sex' value='女'>女</div>";
		echo "<div class='row'>联系方式:<input type='text' name='ptt_tel'></div>";
		echo "<div class='row'>家庭住址:<input type='text' name='ptt_addr'></div>";
		echo "<div class='row'>出生日期:<input type='date' name='ptt_birth'></div>";

		echo "<div class='row2'><input class='btn' type='submit' value='保存'></div>";
		echo "</form>";
		echo "</div>";
	}

	if($option=='查看个人病历')
	{
		$s = "select * from diagnosis, doctor where diagnosis.DCT_NO = doctor.DCT_NO and PTT_NO ='{$ptt_id}'";
		$rst = mysqli_query($lnk, $s);
		echo "<table border='1'>";
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

	echo "<div class='middle'>";
	echo "<form action='patient.php?' method='post'>";
	echo "<input class='btn' type='submit' value='返回'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";

?>