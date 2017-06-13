<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow=date('Y-m-d H:i:s');

	$option = $_POST['option'];
	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$ptt_name = isset($_POST['ptt_name']) ? $_POST['ptt_name'] : '';

	$s = "select * from patient where PTT_NO = {$ptt_id}";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";

	echo "<h1>收费处</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br>";

	if($a == null)
	{
		echo "
		<div class='middle'>
			<div class='row2'><b>!!!患者还未注册，请先注册患者信息!!!</b></div>
			<form action='register.php' method='post'>
				<div class='row'>身份证号:<input type='text' name='new_id'></div>
				<div class='row'>密码:<input type='password' name='new_password' value = '1'></div>
				<div class='row'>确认密码:<input type='password' name='new_passeord1' value = '1'></div>
				<div class='row'>姓名:<input type='text' name='new_name'></div>
				<div class='row2'>性别：
				<input type='radio' name='new_sex' value='男'>男
				<input type='radio' name='new_sex' value='女'>女</div>
				<div class='row'>联系方式:<input type='text' name='new_tel'></div>
				<div class='row'>家庭住址:<input type='text' name='new_addr'></div>
				<div class='row'>出生日期:<input type='date' name='new_birth'></div>
				<div class='row2'><input class='btn' type='submit' value='注册'></div>
			</form>
		</div>
		";
	}
	else{
		if($option == '已预约')
		{
			$s = "select * from appointment where PTT_NO = {$ptt_id} and APT_STATE = 0";
			$rst = mysqli_query($lnk, $s);
			$array = mysqli_fetch_assoc($rst);

			echo "<div class='middle'>";
			if($array)
			{
				//暂时默认同时只能预约一位医生 hu hanpeng 
				$s = "update appointment set APT_STATE = 1 where PTT_NO = {$ptt_id} and APT_STATE = 0";
				$rst = mysqli_query($lnk, $s);

				$s2 = "select * from doctor where DCT_NO = {$array['DCT_NO']}";
				$rst2 = mysqli_query($lnk, $s2);
				$a2 = mysqli_fetch_assoc($rst2);

				echo "您已成功为患者 {$a['PTT_NAME']} 挂号";
				echo "<br><br>";
				echo "医生：{$a2['DCT_NAME']}";
				echo "<br><br>";
				echo "科室：{$a2['DEPT_NAME']}";
			}
			else{
				echo "患者 {$a['PTT_NAME']} 未预约";
			}
			echo "</div>";
		}
		else if($option == '未预约')
		{
			$s = "select * from doctor where DCT_TITLE <> '检查医师' and DCT_TITLE <> '护士' order by DEPT_NAME";
			$rst = mysqli_query($lnk, $s);
			echo "<table>";
			echo "<tr>";
			echo "<th>科室</th>";
			echo "<th>医生编号</th>";
			echo "<th>医生姓名</th>";
			echo "<th>医生性别</th>";
			echo "<th>医生职称</th>";
			echo "<th>医生电话</th>";
			echo "<th>医生出生日期</th>";
			echo "<th>挂号</th>";
			echo "</tr>";
			while($array = mysqli_fetch_assoc($rst)){
				echo "<tr>";
				// $s2 = "select * from dept where DEPT_NO = $array['DEPT_NO']";
				// $rst2 = mysqli_query($lnk, $s2);
				// $array2 = mysqli_fetch_assoc($rst2);
				// echo "<td>{$array2['DEPT_NAME']}</td>";
				echo "<td>{$array['DEPT_NAME']}</td>";

				echo "<td>{$array['DCT_NO']}</td>";
				echo "<td>{$array['DCT_NAME']}</td>";
				echo "<td>{$array['DCT_SEX']}</td>";
				echo "<td>{$array['DCT_TITLE']}</td>";

				echo "<td>{$array['DCT_TEL']}</td>";
				echo "<td>{$array['DCT_BIRTH']}</td>";
				echo "<form action='reg_insert.php?name={$array['DCT_NO']}' method='post'>";
				echo "<td><input class='btn' type='submit' value='挂号'></td>";
				echo "</form>";
				echo "</tr>";
			}

			echo "</table> ";
			setcookie('ck_ptt_id', $ptt_id, -1);
			setcookie('ck_ptt_name', $ptt_name);
		}
	}

	echo "<div class='middle'>";
	echo "<form action='clerk.php?' method='post'>";
	echo "<input class='btn' type='submit' value='返回'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>