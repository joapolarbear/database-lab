<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$ptt_id = $_GET['name1'];
	$diag = $_GET['diag'];

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow = $_GET['time'];

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	
	$build = isset($_POST['build']) ? $_POST['build'] : '';
	$floor = isset($_POST['floor']) ? $_POST['floor'] : '';
	$room = isset($_POST['room']) ? $_POST['room'] : '';
	$bed = isset($_POST['bed']) ? $_POST['bed'] : '';

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "<h2>您正在诊断患者 {$a['PTT_NAME']}</h2>";
	echo "您本次登录时间为：$datenow <br>";

	if($option == '确认')
	{
		$s = "select * from ward where WD_BLD = $build and WD_FLOOR	= $floor and WD_ROOM = $room and WD_BED = $bed and WD_STATE = 0";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		//有符合要求的床位
		if($a){
			//插入住院单新行，并插入检查表WL_NO域，处理检查单信息
			$id = strtr($datenow, array(' '=>''));
			$id = "{$id}{$a['WD_NO']}";
			$s = "insert into hospitallist values('{$id}', '{$datenow}', NULL, NULL, NULL, 0, '{$a['WD_NO']}')";
			$rst = mysqli_query($lnk, $s);

			$s = "update diagnosis set HL_NO = '{$id}' where DIAG_NO = '{$diag}'";
			$rst = mysqli_query($lnk, $s);
		}
		else
		{
			echo "<div class='middle'>";
			echo "输入床位不存在或者不是空闲状态";
			echo "</div>";
		}
		
	}

	$s = "select * from diagnosis where DIAG_NO = '{$diag}'";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<div class='middle'>";
	echo "<form action='diagnosis.php?name=$ptt_id&diag=$diag&time={$datenow}' method='post'>";
	echo "<div class='row2'>诊断结果</div>";
	echo "<div class='row3'>病名：{$a['DIAG_NAME']}</div>";
	echo "<div class='row3'>描述：{$a['DIAG_DESC']}</div>";
	echo "<div class='row3'>检查单：{$a['CL_NO']}</div>";
	echo "<div class='row3'>药单：{$a['DL_NO']}</div>";
	echo "<div class='row3'>住院单：{$a['HL_NO']}</div>";

	echo "<div class='row2'>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='确认'></span>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='取消'></span>";
	echo "</div>";

	echo "</form>";
	echo "</div>";
?>