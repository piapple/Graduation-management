<?php
	require_once("islogin.php");
  require_once("../login/connmysql.php");
  if (isset($_POST['replybtn'])) {
  	$wid = $_GET['wid'];
  	$uid = $_POST['uid'];
  	$text = $_POST['reply'];
  	$sql = "select * from weeknote where id=$wid";
  	$res = $db->query($sql);
  	$num = $res->num_rows;
  	if ($num == 1) {
  		$resql = "update weeknote set w_reply='$text',w_isreply='1' where id=$wid";
  		$result = $db->query($resql);
  		if ($result) {
  			echo "<script>alert('回复成功!');window.location.href='weeknote.php?uid=".$uid."';</script>";
  		}else{
  			echo "<script>alert('回复失败，请重试!');history.go(-1);</script>";
  		}
  	}else{
  		echo "<script>alert('回复成功!');history.go(-1);</script>";
  	}
  }else{
  	require_once("../login/illegal.php");//非法操作跳转重新登录
  }
?>