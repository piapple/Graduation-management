<?php
	//1.连接数据库
 	require_once ("connmysql.php");
 	if (isset($_POST['login'])) {//是否提交登录表单
	 	//2.获取表单数据
		$username = $_POST['username'];
		$pwd = $_POST['password'];
		//是否输入用户名
		if (isset($username)&&$username!="") {
			//是否输入密码
			if (isset($pwd)&&$pwd!="") {
				//3.查询user表匹配表单信息
				$pwd = md5($pwd);//MD5加密
				$results = $db->query("select * from user where u_id='$username' and u_pwd='$pwd'");
				$rows = $results->num_rows;
				if($rows == 1){
					//4.用户信息匹配成功后查询用户的角色id
					$roleidres = $db->query("select u_role_id from user where u_id='$username'");
					if($rs=$roleidres->fetch_array()){
				        $roleid=$rs[0];
				    }else{
				        $roleid="";
				    }
				    //5.封装设置SESSION方法
					function start_session($expire = 0) 
					{ 
					    if ($expire == 0) { 
					    	//获取php.ini配置文件中默认过期时间（24min）
					        $expire = ini_get('session.gc_maxlifetime');
					    } else { 
					    	//设置session过期时间
					        ini_set('session.gc_maxlifetime', $expire); 
					    } 
					    if (empty($_COOKIE['PHPSESSID'])) { 
					        session_set_cookie_params($expire); 
					        session_start(); 
					    } else { 
					        session_start(); 
					        setcookie('PHPSESSID', session_id(), time() + $expire); 
					    } 
					} 
					//调用方法设置600秒以后过期
					start_session(600);
				  	$_SESSION['user_id'] = $username;
					setcookie("user_id","$username",time()+600);
					//6.更新最近一次登录时间
					$now = date('y-m-d H:i:s',time()+8*3600);//获取当前时间
					$db->query("update user set u_lasted_login='$now' where u_id='$username'");
					//7.根据角色id进入不同角色页面
					if ($roleid != "") {
						//设置角色id session值
						$_SESSION['role_id'] = $roleid;
						setcookie("role_id","$roleid",time()+600);
						if ($roleid === '00') {
								echo "<script>window.location.href='../manager/index.php';</script>";
					    }else if ($roleid === '0') {
					    	echo "<script>window.location.href='../manager/control.php';</script>";
					    }else if ($roleid === '1') {
					    	echo "<script>window.location.href='../teacher/teacher.php';</script>";
					    }else if($roleid === '2'){
					    	echo "<script>window.location.href='../instructor/instructor.php';</script>";
					    }else if($roleid === '3'){
					    	echo "<script>window.location.href='../student/student.php';</script>";
					    }else{
					    	echo "<script>alert('Error！');history.go(-1);</script>";
					    }
					}else{  
						echo "<script>alert('System Error！');history.go(-1);</script>";
					}
				}else{  
					echo "<script>alert('用户名或密码错误！');history.go(-1);</script>";
				}
			}else{
				echo "<script>alert('请输入密码！');history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('请输入您的账号密码！');history.go(-1);</script>";
		}
	}else{
		echo "<script>alert('非法操作！');window.location.href='../index.html';</script>";//非法操作跳转重新登录
	}
?>
