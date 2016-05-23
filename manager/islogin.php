<?php
    //1.启动session
	session_start();
    if (isset($_SESSION['user_id'])) {
       $name = $_SESSION['user_id'];
    }else{
      echo "<script>alert('请先登录');window.location.href='../index.html';</script>";
    }
    //2.查询session中角色id是否匹配
    if($_SESSION['role_id'] != '0'||$_SESSION['role_id'] != '00'){
      require_once("../login/illegal.php");//非法操作跳转重新登录
      exit();
    }
    //3.连接数据库操作
    require_once("../login/connmysql.php");
    $res = $db->query("select * from user where u_id='$name'");
    if ($res) {
    	$rows = $res->fetch_assoc();
        $username = $rows['u_name'];//名字
        $roleid = $rows['u_role_id'];//获取部门id
	    $dept = $rows['u_dept_name'];//获取部门名称
	    $headpic = $rows['u_headpic'];//获取头像文件路径
	   	$status = $rows['u_status'];//获取管理员权限状态
        $email = $rows['u_email'];//获取管理员联系邮箱
        $phone = $rows['u_phone'];//获取管理员联系手机号
        $renewtime = $rows['u_renew_time'];//最近的信息更新时间
        $lasted_login = $rows['u_lasted_login'];//最近一次登录时间
        $remark = $rows['u_remark'];//获取备注信息
    }else{
    	echo "<script>alert('Error!');history.go(-1);</script>";
    }
    //4.匹配管理员信息
    if ($name == '111300'&&$roleid == '00'&&$dept == '图文信息中心'&&$status == 1) {
        $firstmenu = "<a href='index.php'>数据中心</a>";//左侧导航栏第一条导航
    	$fourthmenu = "<a href='system.php'>系统管理</a>";//左侧导航栏第四条导航
        //公告对象选择
        $noticeObjOption = "<select  class='form-control' name='n_object'>";
    	$noticeObjOption.= "<option value='0'>管理员</option>";
        $noticeObjOption.= "<option value='1'>指导教师</option>";
        $noticeObjOption.= "<option value='2'>辅导员</option>";
        $noticeObjOption.= "<option value='3'>全院</option>";
        $noticeObjOption.= "</select>";
    }else if($roleid == '0'){
        $firstmenu = "<a href='control.php'>教师管理</a>";//左侧导航栏第一条导航
        $fourthmenu = "<a href='student.php'>学生管理</a>";//左侧导航栏第四条导航
        //公告对象
    	$noticeObjOption = "<input type='hidden' name='n_object' value='3'/>$dept";
    }else{
        echo "<script>alert('Error!');history.go(-1);</script>";
    }
?>