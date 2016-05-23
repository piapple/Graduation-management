<?php
	require_once("islogin.php");
	require_once("../login/connmysql.php");
	if (isset($_GET['nid'])) {
		$noticeid = $_GET['nid'];
		$del = "delete from notice where id=$noticeid";
		$delres = $db->query($del);
		if ($delres) {
			echo "<script>alert('删除成功');window.location.href='noticeshow.php?showid=1';</script>";
		}else{
			echo "<script>alert('删除失败');history.go(-1);</script>";
		}
	}else{
		require_once("../login/illegal.php");//非法操作跳转重新登录
	}
?>