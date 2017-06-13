<?php
	include "header.php";
?>
<body>
	<!-- <h1 style="color:Black;"><img src = "myapp.ico" style=" margin-left: 2px; width: 50px; top = 0" />Welcome to Polar Hospital</h1> -->
	<form action="index_op.php" method="post">
		<div id="container" class="main">
			<div class="d2" style="background-color: #fb6969">
				<br><h2>工作人员登录</h2><br>
				<div class='row2'>
					<input type="radio" name="kind" value="doctor">医生
					<input type="radio" name="kind" value="chemist">药剂师
					<input type="radio" name="kind" value="clerk">收费员
					<input type="radio" name="kind" value="dean">管理员
				</div>
				<div class='row2'>
					编号: <input type="text" name="dct_id">
				</div>
				<div class='row2'>
					密码: <input type="password" name="dct_pwd">
				</div>
				<div class='row2'>
					<input class='btn'type="submit" name="option" value="工作人员登录">	
				</div>			
			</div>
			<div class="d2" style="background-color: #6999fb">
				<br><h2>患者登录/注册</h2><br>
				<div class='row2'>
					编号: <input type="text" name="ptt_id">
				</div>
				<div class='row2'>
					密码: <input type="password" name="ptt_pwd">
				</div>
				<div class='row2'>	
					<span class='row'>
						<input class='btn' type="submit" name="option" value="患者登录">
					</span>
					<span class='row'>
						<input class='btn' type="submit" name="option" value="患者注册">	
					</span>
				</div>		
			</div>
			<div style="clear:both;text-align:center; margin: 50px">
				Copyright © Hu Hanpeng in HUST
			</div>
		</div> 
	</form>
</body>
</html>