<?php
	require_once("islogin.php");
	require_once("../login/connmysql.php");
	if (isset($_POST['renew'])) {
		$userid = $_GET['renewid'];// 获取用户id
		$sqls = "select * from user where u_id='$userid'";
		$results = $db->query($sqls);
		$row = $results->num_rows;
		if($row == 1){
			$flag = false;//初始化数据是否有修改
			if (!empty($_POST['email'])) {//修改邮件数据
				$useremail = $_POST['email'];
				$sql = "update user set u_email='$useremail' where u_id='$userid'";
				$res = $db->query($sql);
				$flag = true;
			}
			if (!empty($_POST['password'])) {//修改密码数据
				$userpwd = md5($_POST['password']);
				$sql = "update user set u_pwd='$userpwd' where u_id='$userid'";
				$res = $db->query($sql);
				$flag = true;
			}
			if (!empty($_POST['phone'])) {//修改手机号数据
				$userphone = $_POST['phone'];
				$sql = "update user set u_phone='$userphone' where u_id='$userid'";
				$res = $db->query($sql);
				$flag = true;
			}
			if (!empty($_POST['remark'])) {//修改备注信息数据
				$userremark = $_POST['remark'];
				$sql = "update user set u_remark='$userremark' where u_id='$userid'";
				$res = $db->query($sql);
				$flag = true;
			}
			if ($flag) {//修改成功
				$now = date('y-m-d H:i:s',time()+8*3600);//获取当前时间
				$sql = "update user set u_renew_time='$now' where u_id='$userid'";
				$db->query($sql);
				echo "<script>alert('数据修改成功!');window.location.href='info.php';</script>";
			}else{
				echo "<script>alert('请填入数据再点击修改,此次操作数据未发生变化!');history.go(-1);</script>";
			}
		}else{
			//错误
			echo "<script>alert('错误操作！');history.go(-1);</script>";
		}
	}else{
		require_once("../login/illegal.php");//非法操作跳转重新登录
	}
?>