<?php
	include 'header.php';
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
				<div class='row'>身份证号:<input type='text' name='new_id'> </div>
				<div class='row'>密码:<input type='password' name='new_password' value = '1'> </div>
				<div class='row'>确认密码:<input type='password' name='new_passeord1' value = '1'> </div>
				<div class='row'>姓名:<input type='text' name='new_name'> </div>
				<div class='row2'>性别：
				<input type='radio' name='new_sex' value='男'>男
				<input type='radio' name='new_sex' value='女'>女</div>
				<div class='row'>联系方式:<input type='text' name='new_tel'> </div>
				<div class='row'>家庭住址:<input type='text' name='new_addr'> </div>
				<div class='row'>出生日期:<input type='date' name='new_birth'> </div>
				<div class='row2'><input class='btn' type='submit' value='注册'></div>
			</form>
		</div>
		</div>
		";
	}
	else{
		echo "<div class='middle'>";
		echo "<div class='row2'>患者 {$a['PTT_NAME']} 缴费</div>";
		echo "</div>";
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

			echo "<div class='middle'>";
			echo "<div class='row2'>检查项目收费 </div>";
			echo "<div class='row3'>检查项目: {$a['CK_NAME']} </div>";
			echo "<div class='row3'>金额: {$a['CK_PRICE']} 元</div>";
			echo "</div>";
			$count += $a['CK_PRICE'];

			$s = "insert into payment values('{$ptt_id}', '{$stf_id}', {$a['CK_PRICE']}, '{$datenow}', 0, '{$list_no}')";
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
			echo "<div class='middle'>";
			echo "<div class='row2'>药单付费</div>";
			while($a = mysqli_fetch_assoc($rst))
			{
				echo "<div class='row3'>药品名：{$a['DRUG_NAME']}</div>";
				echo "<div class='row3'>药品数量：{$a['DRUG_AMOUNT']}</div>";
				$temp = $a['DRUG_AMOUNT'] * $a['DRUG_PRICE'];
				echo "<div class='row3'>金额：{$temp} 元</div><br>";
				$lin += $temp;
			}
			echo "<div class='row2'>药单总额：{$lin} 元</div>";
			echo "</div>";
			$count += $lin;

			$s = "insert into payment values('{$ptt_id}', '{$stf_id}', {$lin}, '{$datenow}', 1, '{$list_no}')";
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

			echo "<div class='middle'>";
			echo "<div class='row2'>住院</div>";
			echo "<div class='row3'>楼栋: {$a['WD_BLD']} 楼</div>";
			echo "<div class='row3'>楼层: {$a['WD_FLOOR']} 层</div>";
			echo "<div class='row3'>房间: {$a['WD_ROOM']} 室</div>";
			echo "<div class='row3'>床位: {$a['WD_BED']} 号床</div>";
			echo "<div class='row3'>支付押金： 100元</div>";
			echo "</div>";
			$count += 100;

			$s = "insert into payment values('{$ptt_id}', '{$stf_id}', 100, '{$datenow}', 2, '{$list_no}')";
			$rst = mysqli_query($lnk, $s);
			$s = "update hospitallist set HL_STATE = 1 where HL_NO = '{$list_no}'";
			$rst = mysqli_query($lnk, $s);
		}
		echo "<div class='middle'>";
		echo "患者总共需要支付 {$count} 元";
		echo "</div>";
	}
	echo "<div class='middle'>";
	echo "<form action='clerk.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>