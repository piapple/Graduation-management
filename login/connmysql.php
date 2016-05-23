<?php
	/*
	1.连接数据库
	2.设置字符编码
	3.如果数据库连接失败提示报错并显示错误信息
	*/
    header("Content-Type:text/html;charset=utf-8");
	$db = new mysqli('localhost','root','','stiei');
	$db->query("set names utf8"); 
	if (mysqli_connect_errno()) {
	    printf("数据库连接失败: %s\n", mysqli_connect_error());
	    exit();
	}
?>