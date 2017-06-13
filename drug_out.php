<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$stf_id = $_COOKIE['ck_stf_id'];
	$stf_name = $_COOKIE['ck_stf_name'];
	$datenow=isset($_GET['time']) ? $_GET['time'] : date('Y-m-d H:i:s');
	$option = isset($_POST['option']) ? $_POST['option'] : '';

	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$ptt_name = isset($_POST['ptt_name']) ? $_POST['ptt_name'] : '';

	echo "<center>";
	echo "<body>";
	echo "<h1>药房管理</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	$id = strtr($datenow, array(' '=>''));
	$id = "{$id}{$stf_id}";

	$s = "select * from diagnosis, druglist where diagnosis.DL_NO = druglist.DL_NO and PTT_NO = '{$ptt_id}' and DL_STATE = 1";
	$rst = mysqli_query($lnk, $s);
	$a = mysqli_fetch_assoc($rst);

	if($a)
	{
		$list_no = $a['DL_NO'];
		$s = "select * from listdrug, drug where listdrug.DRUG_NO = drug.DRUG_NO and DL_NO = '{$list_no}'";
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			echo "<table>";
			echo "<tr>";
			echo "<th colspan='3'>出药信息</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<th>药品名称</th>";
			echo "<th>药品数量</th>";
			echo "<th>药品名称</th>";
			echo "</tr>";
			do{
				$drug_no = $a['DRUG_NO'];
				$need = $a['DRUG_AMOUNT'];
				$name = $a['DRUG_NAME'];
				$price = $a['DRUG_PRICE'];
				echo "<tr>";
				echo "<td>{$name}</td>";
				echo "<td>{$need}</td>";
				echo "<td>{$price}</td>";
				echo "</tr>";
				//更新库存数量
				$remain = $a['DRUG_STORE'] - $a['DRUG_AMOUNT'];
				if($remain >= 0)
				{		
					$s2 = "update drug set DRUG_STORE = {$remain} where DRUG_NO = '{$drug_no}'";		
					$rst2 = mysqli_query($lnk, $s2);
				}
				else echo "药品 {$name} 数量不足，请补充";

				$a = mysqli_fetch_assoc($rst);	
			}while($a);
			echo "<table>";
		}

		$s = "update druglist set DL_STATE = 2, STF_NO = '{$stf_id}' where DL_NO = '{$list_no}'";
		$rst = mysqli_query($lnk, $s);
	}
	else{
		echo "<div class='middle'>";
		echo "患者 {$ptt_id} 不能领药，请先开药或缴费";
		echo "</div>";
	}

	echo "<div class='middle'>";
	echo "<form action='chemist.php?' method='post'>";
	echo "<input class='btn' type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>