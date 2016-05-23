<?php
	require_once("islogin.php");
    //1.判断是否点击提交表单
    if (isset($_POST['adduser'])) {
        //2.获取表单数据
    	$u_name = $_POST['uname'];
    	$u_id = $_POST['uid'];
    	$u_sex = $_POST['usex'];
    	$u_class_name = $_POST['classname'];
    	$u_role_id = $_POST['urole'];
        //如果添加用户角色为学生或辅导员提示要输入班级名称
        if ($u_role_id == '2'||$u_role_id == '3') {
            if ($u_class_name == "") {
                echo "<script>alert('请输入该用户的班级名称!');history.go(-1);</script>";
                exit();
            }
        }
    	$u_superior_id = $_POST['superiorid'];
    	$u_dept_id = $_POST['dept_id'];
        //通过部门id查询部门名称
        $sqlname = "select u_dept_name from user where u_dept_id=$u_dept_id";
        $resname = $db->query($sqlname);
        if($rs=$resname->fetch_array()){
            $u_dept_name=$rs[0];
        }else{
            $u_dept_name="Error Code";
        }
        //3.插入数据
    	$sql = "insert into user(u_id,u_role_id,u_name,u_sex,u_dept_id,u_dept_name,u_superior_id,u_class_name,u_renew_time) VALUES ('$u_id','$u_role_id','$u_name','$u_sex','$u_dept_id','$u_dept_name','$u_superior_id','$u_class_name',now())";
    	$res = $db->query($sql);
    	if ($res) {
    		echo "<script>alert('提交成功!');window.location.href='system.php';</script>";
    	}else{
    		echo "<script>alert('该用户ID已存在!提交失败!');history.go(-1);</script>";
    	}
    }else{
        require_once("../login/illegal.php");//非法操作跳转重新登录
    }
?>
