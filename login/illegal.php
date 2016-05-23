<?php
	/* 用户非法操作
	1.连接数据库
	2.删除cookie值，释放session
	3.提示报错
	*/
    header("Content-Type:text/html;charset=utf-8");
	session_start();		
	setcookie('PHPSESSID','',time()-600);
	setcookie("user_id",'',time()-600);	
	setcookie('role_id','',time()-600);
	session_unset(); 
	session_destroy();
    echo "<script>alert('非法操作,请重新登录!');window.location.href='../index.html';</script>";
?>