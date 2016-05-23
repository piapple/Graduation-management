<?php
	require_once("islogin.php");
  require_once("../login/connmysql.php");
  //判断是否点击回复提交表单
  if (isset($_POST['replybtn'])) {
  	$wid = $_GET['wid'];
  	$uid = $_POST['uid'];
  	$text = $_POST['reply'];
    //查询该周记信息
  	$sql = "select * from weeknote where id=$wid";
  	$res = $db->query($sql);
  	$num = $res->num_rows;
  	if ($num == 1) {
      //修改周记回复
  		$resql = "update weeknote set w_reply='$text' where id=$wid";
  		$result = $db->query($resql);
  		if ($result) {
  			echo "<script>alert('提交成功!');window.location.href='weeknote.php?uid=".$uid."';</script>";
  		}else{
  			echo "<script>alert('提交失败，请重试!');history.go(-1);</script>";
  		}
  	}else{
  		echo "<script>alert('Error!');history.go(-1);</script>";
  	}
  }else{
  	require_once("../login/illegal.php");//非法操作跳转重新登录
  }
?>