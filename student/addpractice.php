<?php
	require_once("islogin.php");
    require_once("../login/connmysql.php");
    if (isset($_POST['addpractice'])) {
        //获取表单数据
    	$company = $_POST['pcompany'];
        $job = $_POST['pjob'];
        $tname = $_POST['ptname'];
        $tphone = $_POST['ptphone'];
        $temail = $_POST['ptemail'];
        $start = $_POST['pstart'];
        //插入数据
    	$sql = "insert into practice(p_id,p_company,p_job,p_tname,p_temail,p_tphone,p_startdate,p_writedate) values('$name','$company','$job','$tname','$temail','$tphone','$start',now())";
    	$res = $db->query($sql);
    	if ($res) {
    		echo "<script>alert('提交成功!');window.location.href='student.php';</script>";
    	}else{
    		echo "<script>alert('提交失败，请重试!');history.go(-1);</script>";
    	}
    }
?>
