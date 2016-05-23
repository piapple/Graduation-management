<?php
	require_once("islogin.php");
	if (isset($_GET['uid'])) {//删除管理员
		$uid = $_GET['uid'];
		$del = "delete from user where u_id='$uid'";
		$delres = $db->query($del);
		if ($delres) {
			echo "<script>alert('删除成功');window.location.href='system.php';</script>";
		}else{
			echo "<script>alert('删除失败');history.go(-1);</script>";
		}
	}else{
		require_once("../login/illegal.php");//非法操作跳转重新登录
	}
?>