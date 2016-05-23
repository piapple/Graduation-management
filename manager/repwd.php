<?php 
	require_once("islogin.php");
  //判断uid参数
  if (isset($_GET['uid'])) {
  	$uid = $_GET['uid'];
    //更新用户密码为初始密码
  	$reset = "update user set u_pwd='e10adc3949ba59abbe56e057f20f883e' where u_id='$uid'";
  	$res = $db->query($reset);
  	if ($res) {
  		echo "<script>alert('密码重置成功！');window.location.href='system.php';</script>";
  	}else{
  		echo "<script>alert('密码重置操作失败!请重试!');history.go(-1);</script>";
  	}
  }else{
  	require_once("../login/illegal.php");//非法操作跳转重新登录
  }
?>