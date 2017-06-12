<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$option = isset($_POST['option']) ? $_POST['option'] : '';
	$kind = isset($_POST['kind']) ? $_POST['kind'] : '';
	$dct_id = isset($_POST['dct_id']) ? $_POST['dct_id'] : ''; 
	$ptt_id = isset($_POST['ptt_id']) ? $_POST['ptt_id'] : '';
	$dct_pwd = isset($_POST['dct_pwd']) ? $_POST['dct_pwd'] : '';
	$ptt_pwd = isset($_POST['ptt_pwd']) ? $_POST['ptt_pwd'] : '';

	$eq = '=';
	echo "<center>";

	// var_dump($_POST);
	
	if($option=='工作人员登录')
	{
		if($dct_pwd == '') 
		{
			$eq = 'is';
			$dct_pwd = 'null';
		}
		if($kind == 'doctor')
		{
			$s = "select * from doctor where DCT_NO = '{$dct_id}'";
			$rst = mysqli_query($lnk, $s);
			$array = mysqli_fetch_assoc($rst);
			if($array == null)
			{
				echo "您输入的用户不存在！";
			}
			else
			{
				if($dct_pwd == 'null')
				{
					$s2 = "select * from doctor where DCT_NO = {$dct_id} and DCT_PSW {$eq} {$dct_pwd}";//这里其实也可以用在查询结果中的子查询
				}
				else 
				{
					$s2 = "select * from doctor where DCT_NO = {$dct_id} and DCT_PSW {$eq} '{$dct_pwd}'";//这里其实也可以用在查询结果中的子查询
				}
				
				$rst2 = mysqli_query($lnk, $s2);
				$array2 = mysqli_fetch_assoc($rst2);
				if($array2 != NULL)
				{
					$s2 = "update doctor set DCT_ON = 1 where DCT_NO = {$dct_id}";//这里其实也可以用在查询结果中的子查询
					$rst2 = mysqli_query($lnk, $s2);
					setcookie('ck_dct_id', $array['DCT_NO']);
					setcookie('ck_dct_name', $array['DCT_NAME']);
					if($array2['DCT_TITLE'] == '检查医师')
					{
						header("Location: http://127.0.0.1:8000/check.php");
					}
					else if($array2['DCT_TITLE'] == '护士'){
						header("Location: http://127.0.0.1:8000/hospital.php");
					}
					else{   //专家，医生。。。
						header("Location: http://127.0.0.1:8000/doctor.php");
					}
				}
				else
				{
					echo "您的密码错误！";
				}
				
			}
		}
		
		else
		{
			$s = "select * from staff where STF_NO = '{$dct_id}'";
			$rst = mysqli_query($lnk, $s);
			$array = mysqli_fetch_assoc($rst);
			if($array == null)
			{
				echo "您输入的用户名不存在！";
			}
			else
			{
				if($dct_pwd == 'null')
				{
					$s2 = "select * from staff where STF_NO = '{$dct_id}' and STF_PWD {$eq} {$dct_pwd}";//这里其实也可以用在查询结果中的子查询
				}
				else
				{
					$s2 = "select * from staff where STF_NO = '{$dct_id}' and STF_PWD {$eq} '{$dct_pwd}'";//这里其实也可以用在查询结果中的子查询
				}
				
				echo $s2;
				$rst2 = mysqli_query($lnk, $s2);
				$array2 = mysqli_fetch_assoc($rst2);
				if($array2 != NULL)
				{
					$s2 = "update staff set STF_ON = 1 where STF_NO = {$dct_id}";//这里其实也可以用在查询结果中的子查询
					$rst2 = mysqli_query($lnk, $s2);
					setcookie('ck_stf_id', $array['STF_NO']);
					setcookie('ck_stf_name', $array['STF_NAME']);
					if($kind == 'chemist')
					{
						header("Location: http://127.0.0.1:8000/chemist.php");
					}
					else if($kind == 'clerk')
					{
						header("Location: http://127.0.0.1:8000/clerk.php");
					}
					// else if($kind == 'registrar')
					// {
					// 	header("Location: http://127.0.0.1:8000/registrar.php");
					// }
					else if($kind == 'dean')
					{
						header("Location: http://127.0.0.1:8000/dean.php");
					}
					else
					{
						echo "请选择用户类别！";
					}
				}
				else
				{
					echo "您的密码错误！";
				}			
			}
		}		
	}

	else if($option=='患者登录')
	{
		$s1 = "select * from patient where PTT_NO = '{$ptt_id}'";
		$rst = mysqli_query($lnk, $s1);
		if($rst) $rstarray = mysqli_fetch_assoc($rst);
		if($rstarray == null)
		{
			echo "您输入的用户名不存在！";
		}
		else
		{
			$s2 = "select * from patient where PTT_NO ='{$ptt_id}' and PTT_PWD = '{$ptt_pwd}'";//这里其实也可以用在查询结果中的子查询
			$rst2 = mysqli_query($lnk, $s2);
			if($rst2) $rstarray2 = mysqli_fetch_assoc($rst2);
			if($rstarray2 != null)
			{
				setcookie('x', $rstarray2['PTT_NO'], time()+3600*24,'/');
				setcookie('CK_PTT_NAME', $rstarray2['PTT_NAME'], time()+3600*24,'/');
				header("Location: http://127.0.0.1:8000/patient.php");
				exit;
			}
			else
			{
				echo "您的密码错误！";
			}
		}
	}
	else if($option == '患者注册')
	{
		echo "
		<body>
		<center>
		<div class='middle'>
		<br><h2>新用户注册</h2><br>
			<form action='register.php' method='post'>
				<div class='row'>身份证号:<input type='text' name='new_id'> </div>
				<div class='row'>密码:<input type='password' name='new_password'> </div>
				<div class='row'>确认密码:<input type='password' name='new_passeord1'> </div>
				<div class='row'>姓名:<input type='text' name='new_name'></div>
				<div class='row'>性别：<input type='radio' name='new_sex' value='男'>男
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='new_sex' value='女'>女</div>
				<div class='row'>联系方式:<input type='text' name='new_tel'> </div>
				<div class='row'>家庭住址:<input type='text' name='new_addr'> </div>
				<div class='row'>出生日期:<input type='date' name='new_birth'> </div>
				<div class='row2'><input type='submit' value='注册' class='btn'></div>
			</form>
		</div>
		";
	}

	echo "<div class='middle'>";
	echo "<form action='index.php?' method='post'>";
	echo "<input type='submit' value='退出' class='btn'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";

?>

