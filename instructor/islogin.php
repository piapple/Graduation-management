<?php
	session_start();
    if (isset($_SESSION['user_id'])) {
       $name = $_SESSION['user_id'];
    }else{
      echo "<script>alert('请先登录');window.location.href='../index.html';</script>";
    }
    if($_SESSION['role_id'] != '2'){
      require_once("../login/illegal.php");//非法操作跳转重新登录
      exit();
    }
    require_once("../login/connmysql.php");
    $sql = "select * from user where u_id='$name'";
    $res = $db->query($sql);
    if ($res) {
    	$rows = $res->fetch_assoc();
        $username = $rows['u_name'];//名字
        $roleid = $rows['u_role_id'];//获取部门id
	    $dept = $rows['u_dept_name'];//获取部门
	    $headpic = $rows['u_headpic'];//获取头像文件路径
	   	$status = $rows['u_status'];//获取管理员权限状态
        $email = $rows['u_email'];//获取管理员联系邮箱
        $phone = $rows['u_phone'];//获取管理员联系手机号
        $class = $rows['u_class_name'];//班级名称
        $renewtime = $rows['u_renew_time'];//最近的信息更新时间
        $lasted_login = $rows['u_lasted_login'];//最近一次登录时间
        $remark = $rows['u_remark'];//备注信息
    }else{
    	echo "<script>alert('Error!');history.go(-1);</script>";
    }
?>