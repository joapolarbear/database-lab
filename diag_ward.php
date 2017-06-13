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
	$drug = isset($_POST['drug']) ? $_POST['drug'] : '';
	$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
	$usage = isset($_POST['usage']) ? $_POST['usage'] : '';

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "<h2>您是否为患者 {$a['PTT_NAME']} 开住院单</h2>";
	echo "您本次登录时间为：$datenow <br>";

	if($option == '确认')
	{
		//插入药单新行，并插入检查表DL_NO域，处理检查单信息
		$id = strtr($datenow, array(' '=>''));
		$id = "{$id}{$dct_id}";
		$s = "insert into druglist values('{$id}', 0, '{$datenow}', NULL)";
		$rst = mysqli_query($lnk, $s);

		$s = "update diagnosis set DL_NO = '{$id}' where DIAG_NO = '{$diag}'";
		// echo $s;
		// var_dump($drug);
		// var_dump($amount);
		// var_dump($usage);
		$rst = mysqli_query($lnk, $s);
		$j = 0;
		for($i = 0; $i < count($drug); $i = $i + 1)
		{
			for(; $j < count($drug) && $amount[$i] == ''; $j++);
			$s = "insert into listdrug values('{$id}', '{$drug[$i]}', '{$usage[$j]}', {$amount[$j]})";
			$rst = mysqli_query($lnk, $s);
			$j++;
		}
	}
	
	echo "<div class='middle'>";
	echo "<form action='diag_final.php?name1=$ptt_id&diag=$diag&time={$datenow}' method='post'>";
	echo "<div class='row'>楼栋：<input type='number' name='build'></div>";
	echo "<div class='row'>楼层：<input type='number' name='floor'></div>";
	echo "<div class='row'>房间：<input type='number' name='room'></div>";
	echo "<div class='row'>床号：<input type='number' name='bed'></div>";
	
	echo "<div class='row2'>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='确认'></span>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='跳过'></span>";
	echo "</div>";
	echo "</form>";
	echo "</div>";

	//床位信息
	$s = "select * from ward where WD_STATE = 0 order by WD_BLD, WD_FLOOR, WD_ROOM, WD_BED";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);
	if($a)
	{
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='5'>医院病床信息</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>编号</th>";
		echo "<th>楼栋</th>";
		echo "<th>楼层</th>";
		echo "<th>房间</th>";
		echo "<th>床号</th>";
		echo "</tr>";
		do{
			echo "<tr>";
			echo "<td>{$a['WD_NO']}</td>";
			echo "<td>{$a['WD_BLD']}</td>";
			echo "<td>{$a['WD_FLOOR']}</td>";
			echo "<td>{$a['WD_ROOM']}</td>";
			echo "<td>{$a['WD_BED']}</td>";
			echo "</tr>";
			$a = mysqli_fetch_assoc($rst);
		}while($a);
		echo "</table>";
	}
	else{
		echo "<div class='middle'>";
		echo "没有空闲病床";
		echo "</div>";
	}
	echo "<div class='middle'>";
	echo "<form action='diagnosis.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>