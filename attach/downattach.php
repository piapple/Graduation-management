<?php
	session_start();
  if (isset($_SESSION['user_id'])) {
     $name = $_SESSION['user_id'];
  }else{
    require_once("../login/illegal.php");//非法操作跳转重新登录
    exit();
  }
	if (!empty($_GET['n_url'])) {
		$attach = $_GET['n_url'];//获取连接中传来的下载url
		$filename = substr($attach, 11);//字符串截断，第11位到最后
	}else if (!empty($_GET['w_url'])) {
		$filename = $_GET['w_url'];//获取连接中传来的下载url
		$attach = "notefile/".$filename;
	}else{
		require_once("../login/illegal.php");//非法操作跳转重新登录
    exit();
	}
	$fileurl = iconv("utf-8", "gb2312", $attach);//转码
	header("Content-Disposition:attachment;filename='".$filename."'");//下载弹窗中文件名
	header("Content-Length:".filesize($fileurl));//获取文件大小
	readfile($fileurl);//下载
?>