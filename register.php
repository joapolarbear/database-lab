<?php
	include 'header.php';
	header("content-type:text/html;charset=utf-8");
	//通过PHP连接服务器,选择数据库
	$lnk = mysqli_connect('localhost', 'root', '', 'hospital');
	//设置客户端和连接字符串
	mysqli_query($lnk, 'set names utf8');

	$new_id = isset($_POST['new_id']) ? $_POST['new_id'] : '';
	$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
	$new_passeord1 = isset($_POST['new_passeord1']) ? $_POST['new_passeord1'] : '';
	$new_name = isset($_POST['new_name']) ? $_POST['new_name'] : '';
	$new_sex = isset($_POST['new_sex']) ? $_POST['new_sex'] : '';
	$new_tel = isset($_POST['new_tel']) ? $_POST['new_tel'] : '';
	$new_addr = isset($_POST['new_addr']) ? $_POST['new_addr'] : '';
	$new_birth = isset($_POST['new_birth']) ? $_POST['new_birth'] : '';

	$sentence = "select * from patient where PTT_NO = '{$new_id}'";
	$result = mysqli_query($lnk, $sentence);
	if($result) $resultarray = mysqli_fetch_assoc($result);

	echo "<body><center>";
	echo "<div class='middle'>";

	if($new_id == '' || $new_password == '' || $new_passeord1=='' || 
		$new_name=='' || $new_sex=='' || $new_tel=='' || $new_addr == '' || $new_birth == '')
 	{
		echo "您的信息填写不全，请重新修改！<br>";
	}
	else
	{
		if($new_passeord1 != $new_password)
		{
			echo "您两次输入密码不一致，请重新输入！<br>";
		}
		else
		{
			if($resultarray != null)
			{
				echo "您的身份证号已注册过，不能重复注册！<br>";
			}
			else
			{
				$sentence="insert into patient values('{$new_id}', '{$new_name}', '{$new_addr}', '{$new_tel}', '{$new_sex}', '{$new_password}', '{$new_birth}')";
				$result = mysqli_query($lnk, $sentence);
				if($result == null) echo "error";
				else
				{					
					echo "注册成功！";
				}
			}		
		}
	}
	echo "</div>";
	echo "<div class='middle'>";
	echo "<form action='index.php?' method='post'>";
	echo "<input type='submit' value='退出'>";
	echo "</form>";
	echo "</div>";

	echo "</center>";
	echo "</body>";
	echo "</html>";
?>