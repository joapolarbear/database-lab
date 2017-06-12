<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>医院管理系统</title>
	<link rel="shortcut icon" type="image/x-icon" href="myapp.ico" />
	<style type="text/css">
		.leftdiv{
			width: 300px;
			//float: left;
			text-align: left;
		}
	</style>
</head>
<?php
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
	echo "<br><b>尊敬的 $dct_name 医生, 您好</b><br><br>";
	echo "您本次登录时间为：$datenow <br><br>";
	echo "<br><b>您正在诊断患者 {$a['PTT_NAME']}</b><br><br>";
	echo "<br><br>";
	echo "开药";
	echo "<br><br>";

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
	$s = "select * from drug order by DRUG_NAME";
	$rst = mysqli_query($lnk, $s);
	$array = mysqli_fetch_assoc($rst);
	if($array)
	{
		echo "<table border = '1'>";
		echo "<tr>";
		echo "<th>药品编号</th>";
		echo "<th>药品名称</th>";
		echo "<th>药品价格</th>";
		echo "<th>药品库存</th>";

		echo "<th>选择</th>";
		echo "<th>数量</th>";
		echo "<th>用法用量</th>";
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

	}
	else
	{
		echo "没有药品信息";
		echo "<br><br><br>";
	}
	// echo "</div>";
	echo "<input type='submit' name='option' value='确认'>";
	echo "<input type='submit' name='option' value='跳过'>";
	echo "</form>";
?>