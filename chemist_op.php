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

	// var_dump($_COOKIE);

	echo "<center>";
	echo "<body>";
	echo "<h1>药房管理</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您本次登录时间为：$datenow <br><br>";

	if($option=='入药')
	{
		echo "<div class='middle'>";
		echo "<div class='row2'>请输入药品信息</div>";
		echo "<form action='drug_in.php?time=$datenow' method='post'>";

		echo "<div class='row'>药品名:<input type='text' name='name'></div>";
		echo "<div class='row'>生产时间:<input type='date' name='pro_time'></div>";
		echo "<div class='row'>失效时间:<input type='date' name='exp_time'></div>";
		echo "<div class='row'>进价:<input type='number' name='inprice'></div>";
		echo "<div class='row'>售价:<input type='number' name='price'></div>";
		echo "<div class='row'>数量:<input type='number' name='amount'></div>";

		echo "<div class='row2'><input class='btn' type='submit' value='保存'></div>";
		echo "</form>";
		echo "</div>";
	}

	if($option=='出药')
	{
		echo "<div class='middle'>";
		echo "<div class='row2'>请输入患者身份证号和姓名</div>";
		echo "<form action='drug_out.php?time=$datenow' method='post'>";

		echo "<div class='row'>身份证号:<input type='text' name='ptt_id'></div>";
		echo "<div class='row'>患者姓名:<input type='text' name='ptt_name'></div>";

		echo "<div class='row2'><input class='btn' type='submit' value='确认'></div>";
		echo "</form>";		
		echo "</div>";
	}

	if($option=='查看药品')
	{
		$s = "select * from drug order by DRUG_NAME";
		$rst = mysqli_query($lnk, $s);
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='8'>药品信息</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>药品编号</th>";
		echo "<th>药品名称</th>";
		echo "<th>生产日期</th>";
		echo "<th>失效日期</th>";
		echo "<th>药品进价</th>";
		echo "<th>药品售价</th>";
		echo "<th>药品库存</th>";
		echo "<th>入库时间</th>";
		echo "</tr>";
		while($a = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$a['DRUG_NO']}</td>";
			echo "<td>{$a['DRUG_NAME']}</td>";
			echo "<td>{$a['DRUG_PRO_DATE']}</td>";
			echo "<td>{$a['DRUG_EXP_DATE']}</td>";
			echo "<td>{$a['DRUG_INPRICE']}</td>";
			echo "<td>{$a['DRUG_PRICE']}</td>";
			echo "<td>{$a['DRUG_STORE']}</td>";
			echo "<td>{$a['DRUG_INTIME']}</td>";
			echo "</tr>";
		}
		echo "</table> ";
	}

	if($option == '更新药品')
	{
		$s = "select * from drug where TO_DAYS(DRUG_EXP_DATE) - TO_DAYS(NOW()) <= 30 and DRUG_STORE <> 0 order by DRUG_NAME, DRUG_EXP_DATE";
		// echo $s;
		$rst = mysqli_query($lnk, $s);
		$a = mysqli_fetch_assoc($rst);
		if($a)
		{
			echo "<form action='drug_delete.php?time=$datenow' method='post'>";
			echo "<table>";
			echo "<tr>";
			echo "<th colspan='5'>一个月内即将失效药品</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<th>药品编号</th>";
			echo "<th>药品名称</th>";
			echo "<th>药品价格</th>";
			echo "<th>药品库存</th>";
			echo "<th>删除</th>";
			echo "</tr>";
			do{
				echo "<tr>";
				echo "<td>{$a['DRUG_NO']}</td>";
				echo "<td>{$a['DRUG_NAME']}</td>";
				echo "<td>{$a['DRUG_PRICE']}</td>";
				echo "<td>{$a['DRUG_STORE']}</td>";

				echo "<td><input type='checkbox' name='delete[]' value={$a['DRUG_NO']}></td>";
				echo "</tr>";

				$a = mysqli_fetch_assoc($rst);
			}while($a);
			echo "</table>";
			echo "<div class='middle'>";
			echo "<input class='btn' type='submit' name='option' value='确认'>";
			echo "</div>";
			echo "</form>";
		}
		else
		{
			echo "<div class='middle'>";
			echo "近期没有即将失效的药品";
			echo "</div>";
		}
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