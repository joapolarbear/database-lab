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

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow = isset($_GET['time']) ? $_GET['time'] : date('Y-m-d H:i:s');

	$id = strtr($datenow, array(' '=>''));
	$id = "{$id}{$stf_id}";

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$ptt_name = isset($_POST['ptt_name']) ? $_POST['ptt_name'] : '';

	$s = "select * from patient where PTT_NO = {$ptt_id}";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	echo "<center>";
	echo "<h1>收费处</h1>";
	echo "<br><b>亲爱的 {$stf_name} ，您好</b><br><br>";
	echo "您本次登录时间为：{$datenow} <br><br>";

	if($a == null)
	{
		echo "
		<br><br><br><b>!!!患者还未注册，请先注册患者信息!!!</b><br><br><br>
			<form action='register.php' method='post'>
				身份证号:<input type='text' name='new_id'> <br><br>
				密&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp码:<input type='password' name='new_password' value = '1'> <br><br>
				确认密码:<input type='password' name='new_passeord1' value = '1'> <br><br>
				姓&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp名:<input type='text' name='new_name'> <br><br>
				性&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp别：
				&nbsp&nbsp&nbsp&nbsp<input type='radio' name='new_sex' value='男'>男
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='new_sex' value='女'>女&nbsp&nbsp&nbsp<br><br>
				联系方式:<input type='text' name='new_tel'> <br><br>
				家庭住址:<input type='text' name='new_addr'> <br><br>
				出生日期:<input type='date' name='new_birth'> <br><br>
				<input type='submit' value='注册'>
			</form>";
	}
	else{
		echo "患者 {$a['PTT_NAME']} 缴费<br><br>";
		$count = 0;
		//检查单缴费查询
		$s = "select * from diagnosis, checklist where diagnosis.CL_NO = checklist.CL_NO and PTT_NO = '{$ptt_id}' and CL_STATE = 0";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			$ck_name = $a['CL_NAME'];
			$list_no = $a['CL_NO'];
			$s = "select * from checkprogram where CK_NAME = '{$ck_name}'";
			$rst = mysqli_query($lnk, $s);
			$a = mysqli_fetch_assoc($rst);

			echo "检查项目: {$a['CK_NAME']} <br><br>";
			echo "金额: {$a['CK_PRICE']} 元<br<br><br>><br>";
			$count += $a['CK_PRICE'];

			$s = "insert into payment values('{$id}', '{$stf_id}', {$a['CK_PRICE']}, '{$datenow}', 0, '{$list_no}')";
			$rst = mysqli_query($lnk, $s);
			$s = "update checklist set CL_STATE = 1 where CL_NO = '{$list_no}'";
			$rst = mysqli_query($lnk, $s);
		}
		//药单查询
		$s = "select * from diagnosis, druglist where diagnosis.DL_NO = druglist.DL_NO and PTT_NO = '{$ptt_id}' and DL_STATE = 0";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			$list_no = $a['DL_NO'];
			// $ck_name = $a['CL_NAME'];
			$s = "select * from listdrug, drug where listdrug.DRUG_NO = drug.DRUG_NO and DL_NO = '{$list_no}'";
			$rst = mysqli_query($lnk, $s);
			$lin = 0;
			while($a = mysqli_fetch_assoc($rst))
			{
				echo "药品名：{$a['DRUG_NAME']}<br><br>";
				echo "药品数量：{$a['DRUG_AMOUNT']}<br><br>";
				$temp = $a['DRUG_AMOUNT'] * $a['DRUG_PRICE'];
				echo "金额：{$temp} 元<br><br><br>";
				$lin += $temp;
			}
			echo "药单总额：{$lin} 元";
			$count += $lin;

			$s = "insert into payment values('{$id}', '{$stf_id}', {$lin}, '{$datenow}', 1, '{$list_no}')";
			$rst = mysqli_query($lnk, $s);
			$s = "update druglist set DL_STATE = 1 where DL_NO = '{$list_no}'";
			$rst = mysqli_query($lnk, $s);
		}
		//住院单查询
		$s = "select * from diagnosis, hospitallist where diagnosis.HL_NO = hospitallist.HL_NO and PTT_NO = '{$ptt_id}' and HL_STATE = 0";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			$list_no = $a['HL_NO'];
			$wd_no = $a['WD_NO'];
			$s = "select * from ward where WD_NO = '{$wd_no}'";
			$rst = mysqli_query($lnk, $s);
			$a = mysqli_fetch_assoc($rst);

			echo "住院<br><br>";
			echo "楼栋: {$a['WD_BLD']} 楼<br><br>";
			echo "楼层: {$a['WD_FLOOR']} 层<br><br>";
			echo "房间: {$a['WD_ROOM']} 室<br><br>";
			echo "床位: {$a['WD_BED']} 号床<br><br>";
			echo "支付押金： 100元<br><br>";
			$count += 100;

			$s = "insert into payment values('{$id}', '{$stf_id}', 100, '{$datenow}', 2, '{$list_no}')";
			$rst = mysqli_query($lnk, $s);
			$s = "update hospitallist set HL_STATE = 1 where HL_NO = '{$list_no}'";
			$rst = mysqli_query($lnk, $s);
		}

		echo "患者总共需要支付 {$count} 元<br><br><br>";

		echo "<form action='clerk.php' method = 'post'>";
		echo "<input type='submit' name='option' value='确认'>";
		echo "</form>";

	}
	echo "</center>";

?>