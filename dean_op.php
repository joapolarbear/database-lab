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
	echo "<h1>管理员</h1>";
	echo "<h2>亲爱的 $stf_name ，您好</h2>";
	echo "您是管理员，您拥有系统最高权限<br>";
	echo "您本次登录时间为：$datenow <br><br>";

	if($option=='添加人员')
	{
		echo "<div class='middle'>";

		echo "<div class='row2'>请输入待添加人员信息</div>";

		echo "<form action='dean_add.php?time=$datenow' method='post'>";

		echo "<div class='row2'>";
			echo "<input type='radio' name='kind' value='doctor'>医生";
			echo "<input type='radio' name='kind' value='chemist'>药剂师";
			echo "<input type='radio' name='kind' value='clerk'>收费员";
			echo "<input type='radio' name='kind' value='dean'>管理";
		echo "</div>";
		echo "<div class='row'>身份证号: <input type='text' name='id'></div>";
		echo "<div class='row'>姓名:<input type='text' name='name'></div>";
		echo "<div class='row2'>";
			echo "<span class='row'><input type='radio' name='sex' value='男'>男</span>";
			echo "<span class='row'><input type='radio' name='sex' value='女'>女</span>";
		echo "</div>";
		echo "<div class='row'>出生时间:<input type='date' name='birth'></div>";
		echo "<div class='row'>职称:<input type='text' name='title'></div>";
		echo "<div class='row'>电话:<input type='text' name='tel'></div>";
		echo "<div class='row'>科室:<input type='text' name='dept'></div>";

		echo "<div class='row2'><input class='btn' type='submit' value='保存'></div>";
		echo "</form>";
		echo "</div>";
	}

	if($option=='删除人员')
	{
		echo "<div class='middle'>";
		echo "<div class='row2'>请输入删除人员信息</div>";

		echo "<form action='dean_delete.php?time=$datenow' method='post'>";
		echo "<div class='row2'>";
			echo "<input type='radio' name='kind' value='doctor'>医生";
			echo "<input type='radio' name='kind' value='chemist'>药剂师";
			echo "<input type='radio' name='kind' value='clerk'>收费员";
			echo "<input type='radio' name='kind' value='dean'>管理";
		echo "</div>";

		echo "<div class='row'>身份证号: <input type='text' name='id'></div>";
		echo "<div class='row'>姓名:<input type='text' name='name'></div>";

		echo "<div class='row2'>";
			echo "<span class='row'><input class='btn' type='submit' name='option' value='确认'></span>";
			echo "<span class='row'><input class='btn' type='submit' name='option' value='取消'></span>";
		echo "</div>";

		echo "</form>";
		echo "</div>";
	}

	if($option=='查看人员')
	{
		$s = "select * from doctor order by DEPT_NAME, DCT_NAME";
		$rst = mysqli_query($lnk, $s);
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='7'>医生信息</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>医生编号</th>";
		echo "<th>医生姓名</th>";
		echo "<th>医生性别</th>";
		echo "<th>医生职称</th>";
		echo "<th>医生科室</th>";
		echo "<th>医生电话</th>";
		echo "<th>医生出生日期</th>";
		echo "</tr>";
		while($array = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$array['DCT_NO']}</td>";
			echo "<td>{$array['DCT_NAME']}</td>";
			echo "<td>{$array['DCT_SEX']}</td>";
			echo "<td>{$array['DCT_TITLE']}</td>";
			echo "<td>{$array['DEPT_NAME']}</td>";
			echo "<td>{$array['DCT_TEL']}</td>";
			echo "<td>{$array['DCT_BIRTH']}</td>";
			echo "</tr>";
		}
		echo "</table> ";

		echo "<br><br>";
		$s = "select * from staff order by DEPT_NAME, STF_NAME";
		$rst = mysqli_query($lnk, $s);
		echo "<table>";
		echo "<tr>";
		echo "<th colspan='7'>职工信息</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>职工编号</th>";
		echo "<th>职工姓名</th>";
		echo "<th>职工性别</th>";
		echo "<th>职工职称</th>";
		echo "<th>职工科室</th>";
		echo "<th>职工电话</th>";
		echo "<th>职工出生日期</th>";
		echo "</tr>";
		while($array = mysqli_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$array['STF_NO']}</td>";
			echo "<td>{$array['STF_NAME']}</td>";
			echo "<td>{$array['STF_SEX']}</td>";
			echo "<td>{$array['STF_TITLE']}</td>";
			echo "<td>{$array['DEPT_NAME']}</td>";
			echo "<td>{$array['STF_TEL']}</td>";
			echo "<td>{$array['STF_BIRTH']}</td>";
			echo "</tr>";
		}
		echo "</table> ";
	}

	if($option=='财务统计')
	{

		$drug_in = 0;
		$s = "select * from drugmanage, drug where drugmanage.DRUG_NO = drug.DRUG_NO and IS_IN = 1 and date_format(TIME, '%Y%m') = date_format(curdate(), '%Y%m')";
		$rst = mysqli_query($lnk, $s);

		echo "<div class='middle'>";
		while($a = mysqli_fetch_assoc($rst))
		{
			$drug_in += ($a['AMOUNT']*$a['DRUG_INPRICE']);
		}
		echo "<div class='row3'>本月药品购入支出: - {$drug_in} 元</div>";

		$pay = 0;
		$s = "select * from payment where date_format(PAY_DATE, '%Y%m') = date_format(curdate(), '%Y%m')";
		$rst = mysqli_query($lnk, $s);
		while($a = mysqli_fetch_assoc($rst))
		{
			$pay += $a['PAY_PRICE'];
		}
		echo "<div class='row3'>本月药品售出和项目检查: + {$pay} 元</div>";

		$reg = 0;
		$s = "select * from appointment where (APT_STATE = 1 or APT_STATE = 2 or APT_STATE = 3) and date_format(APT_DATE, '%Y%m') = date_format(curdate(), '%Y%m')";
		$rst = mysqli_query($lnk, $s);
		while($a = mysqli_fetch_assoc($rst))
		{
			$pay += 5;
		}
		echo "<div class='row3'>本月挂号费用收入: + {$pay} 元</div>";

		$ward = 0;
		$s = "select * from hospitallist where date_format(OUT_TIME, '%Y%m') = date_format(curdate(), '%Y%m') and HL_STATE = 3";
		$rst = mysqli_query($lnk, $s);
		while($a = mysqli_fetch_assoc($rst))
		{
			$out_time = strtotime($a['OUT_TIME']);
			$in_time = strtotime($a['IN_TIME']);
			$days = round(($out_time-$in_time)/3600/24);
			//假设100元每天
			$ward += $days*100;
		}
		echo "<div class='row3'>本月住院收入: + {$ward} 元</div>";

		echo "</div>";
	}

	// if($option == '退出登录')
	// {
	// 	//应该有对cookie的删除操作  huhanpeng		
	// 	$s2 = "update staff set STF_ON = 0 where STF_NO = {$stf_id}";//这里其实也可以用在查询结果中的子查询
	// 	$rst2 = mysqli_query($lnk, $s2);
	// 	header("Location: http://127.0.0.1:8000/index.php");
	// }
	echo "<div class='middle'>";
	echo "<form action='dean.php?' method='post'>";
	echo "<input class='btn' type='submit' value='确认'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>