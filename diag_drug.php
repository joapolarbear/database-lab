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
	$program = isset($_POST['program']) ? $_POST['program'] : '';
	$dept = isset($_POST['dept']) ? $_POST['dept'] : ''		;

	$s = "select * from patient where PTT_NO = $ptt_id";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<body>";
	echo "<h1>医生您好</h1>";
	echo "<h2>亲爱的医生 $dct_name</h2>";
	echo "<h2>您是否为患者 {$a['PTT_NAME']} 开药</h2>";
	echo "您本次登录时间为：$datenow <br>";

	if($option == '确认')
	{
		//插入检查表新行，并插入检查表CL_NO域，处理检查单信息
		$id = strtr($datenow, array(' '=>''));
		$id = "{$id}{$dct_id}";
		$s = "insert into checklist values('{$id}', '{$program}', '{$datenow}', 0, NULL, NULL, '{$dct_id}', '{$dept}')";
		$rst = mysqli_query($lnk, $s);

		$s = "update diagnosis set CL_NO = '{$id}' where DIAG_NO = '{$diag}'";
		$rst = mysqli_query($lnk, $s);
	}

	echo "<form action='diag_ward.php?name1=$ptt_id&diag=$diag&time={$datenow}' method='post'>";
	// echo "<div class = 'leftdiv'>";
	$s = "select * from drug where DRUG_STORE <> 0 order by DRUG_NAME";
	$rst = mysqli_query($lnk, $s);
	$array = mysqli_fetch_assoc($rst);
	if($array)
	{
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='7'>请选择开药或跳过</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>药品编号</th>";
		echo "<th>药品名称</th>";
		echo "<th>药品价格</th>";
		echo "<th>药品库存</th>";

		echo "<th>选择</th>";
		echo "<th>数量</th>";
		echo "<th>用法用量</th>";
		echo "</tr>";
		do{
			echo "<tr>";
			echo "<td>{$array['DRUG_NO']}</td>";
			echo "<td>{$array['DRUG_NAME']}</td>";
			echo "<td>{$array['DRUG_PRICE']}</td>";
			echo "<td>{$array['DRUG_STORE']}</td>";

			echo "<td><input type='checkbox' name='drug[]' value={$array['DRUG_NO']}></td>";
			echo "<td><input type='text' name='amount[]'</td>";
			echo "<td><input type='text' name='usage[]'</td>";
			echo "</tr>";
			$array = mysqli_fetch_assoc($rst);
		}while($array);
		echo "</table>";
	}
	else
	{
		echo "<div class='middle'>";
		echo "没有药品信息";
		echo "</div>";
	}

	echo "<div class='row2'>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='确认'></span>";
	echo "<span class='row'><input class='btn' type='submit' name='option' value='跳过'></span>";
	echo "</div>";
	echo "</form>";

	echo "<form action='diagnosis.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>