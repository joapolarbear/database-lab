<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$dct_id = $_COOKIE['ck_dct_id'];
	$dct_name = $_COOKIE['ck_dct_name'];
	$datenow=date('Y-m-d H:i:s');

	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$ptt_name = isset($_POST['ptt_name']) ? $_POST['ptt_name'] : '';
	$option = isset($_POST['option']) ? $_POST['option'] : '';

	echo "<center>";
	echo "<body>";
	echo "<h1>住院部</h1>";
	echo "<h2>亲爱的 $dct_name 护士，您好</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	echo "<div class='middle'>";
	if($option == '住院')
	{
		$s = "select * from diagnosis, hospitallist where diagnosis.HL_NO = hospitallist.HL_NO and HL_STATE = 1 and PTT_NO = '{$ptt_id}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			$wd_id = $a['WD_NO'];
			$hl_id = $a['HL_NO'];
			$s = "select * from ward where WD_NO = '{$wd_id}'";
			$rst = mysqli_query($lnk, $s);
			$a = mysqli_fetch_assoc($rst);

			echo "<div class='row2'>为患者 {$ptt_id} 分配床位</div>";
			echo "<div class='row3'>楼栋： {$a['WD_BLD']}</div>";
			echo "<div class='row3'>楼层： {$a['WD_FLOOR']}</div>";
			echo "<div class='row3'>房间： {$a['WD_ROOM']}</div>";
			echo "<div class='row3'>床位： {$a['WD_BED']}</div>";

			$s = "update ward set WD_STATE = 1 where WD_NO = '{$wd_id}'";
			$rst = mysqli_query($lnk, $s);
			$s = "update hospitallist set HL_STATE = 2, IN_TIME = '{$datenow}' ,DCT_NO = '{$dct_id}' where 	HL_NO = '{$hl_id}'";
			$rst = mysqli_query($lnk, $s);
		}
		else 
		{
			echo "患者 {$ptt_id} 不能住院，请先开住院单或缴费";
		}
	}
	else // $option = '出院'
	{
		//住院单状态必须为2 已处理状态
		$s = "select * from diagnosis, hospitallist where diagnosis.HL_NO = hospitallist.HL_NO and HL_STATE = 2 and PTT_NO = '{$ptt_id}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			$wd_id = $a['WD_NO'];
			$hl_id = $a['HL_NO'];
			$s = "select * from ward where WD_NO = '{$wd_id}'";
			$rst = mysqli_query($lnk, $s);
			$a = mysqli_fetch_assoc($rst);

			echo "<div class='row2'>患者 {$ptt_id} 出院，空出床位</div>";
			echo "<div class='row3'>楼栋： {$a['WD_BLD']}</div>";
			echo "<div class='row3'>楼层： {$a['WD_FLOOR']}</div>";
			echo "<div class='row3'>房间： {$a['WD_ROOM']}</div>";
			echo "<div class='row3'>床位： {$a['WD_BED']}</div>";

			$s = "update ward set WD_STATE = 0 where WD_NO = '{$wd_id}'";
			$rst = mysqli_query($lnk, $s);
			$s = "update hospitallist set HL_STATE = 3, OUT_TIME = '{$datenow}' ,DCT_NO = '{$dct_id}' where 	HL_NO = '{$hl_id}'";
			$rst = mysqli_query($lnk, $s);
		}
		else 
		{
			echo "患者 {$ptt_id} 不能出院，信息输入有误";
		}
	}
	
	echo "</div>";

	echo "<div class='middle'>";
	echo "<form action='hospital.php?' method='post'>";
	echo "<input class='btn' type='submit' value='确认'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";


?>