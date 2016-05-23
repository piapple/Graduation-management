<?php
    header("Content-Type:text/html;charset=utf-8");
	session_start();		
	setcookie('PHPSESSID','',time()-600);
	setcookie("user_id",'',time()-600);	
	setcookie('role_id','',time()-600);
	session_unset(); 
	session_destroy();
    echo "<script>alert('注销成功');window.location.href='../index.html';</script>";
?>