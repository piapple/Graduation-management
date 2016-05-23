<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="HandheldFriendly" content="true">
    <meta content="telephone=no" name="format-detection" />
    <meta content="email=no" name="format-detection" />
    <title>毕业顶岗实习信息平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dropdown-min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
  <?php
    require_once("islogin.php");
    if (isset($_POST['searchbtn'])) {
      //1.获取要显示的用户id
      $id = $_POST['search'];
      //在数据库中查询该用户u_id
      $sql = "select * from user where u_id='$id'";
      $res = $db->query($sql);
      $row = $res->num_rows;
      if ($row == 1) {
        $info = $res->fetch_assoc();
        $uid = $info['u_id'];
        $urole = $info['u_role_id'];
        $uname = $info['u_name'];
        $uemail = $info['u_email'];
        $uphone = $info['u_phone'];
        $udept = $info['u_dept_id'];
        $usuperiorid = $info['u_superior_id'];
        $uheadpic = $info['u_headpic'];
        $ustatus = $info['u_status'];
        $udeptname = $info['u_dept_name'];
        $uclassname = $info['u_class_name'];
        //初始化默认数据
        $roleflag = "工号";
        $weeknote = "";
        $status = "";//用户状态
        $pflag = false;//实习标志
        //判断角色并显示
        if ($urole == 0) {
          $role = "管理员";
        }else if ($urole == 1) {
          $role = "指导教师";
        }else if ($urole == 2) {
          $role = "辅导员";
        }else if($urole == 3){
          $role = "实习学生";
          $roleflag = "学号";
          $weeknote = "<span><a href='weeknote.php?uid=$uid'>查看周记</a></span>";
        }
        //判断用户状态
        if ($ustatus == 1) {
          $status = "有效";//描述暂定
        }else if($ustatus == 0){
          $status = "无效";//描述暂定
        }
        //如果为学生角色显示实习信息
        if ($urole == 3) {
          $practice = "select * from practice where p_id=$uid";
          $resp = $db->query($practice);
          $psum = $resp->num_rows;
          for ($i=0; $p=$resp->fetch_assoc(); $i++) { 
            $pcontent[$i] = $p;
            if ($pcontent[$i]['p_status'] == 1) {
              $u_pstatus[$i] = "实习";
            }else if($pcontent[$i]['p_status'] == 0){
              $u_pstatus[$i] = "过期";
            }
          }
          $pflag = true;
        }        
      }else if($row == 0){
        echo "<script>alert('您所查询的用户不存在，请确认后再试!');history.go(-1);</script>";
        exit();
      }
    }else{
      require_once("../login/illegal.php");//非法操作跳转重新登录
    }
  ?>
  <!-- 侧边导航-->
  <div role="navigation" id="foo" class="nav-collapse">
    <p class="title">毕业顶岗实习信息平台</p>
    <div class="user-panel">
      <!--侧边头像 -->
      <div class="image">
        <img src="<?= $headpic?>" class="img-circle headpic" alt="User Image">
      </div>
      <div class="info">
      <!-- 职位和姓名 -->
        <p><i class="glyphicon glyphicon-user"><?= $username?></i></p>
        <p><?= $name?></p>
        <p><a href="../login/logout.php">注销</a></p>
      </div>
    </div>
    <!-- 侧边导航 -->
    <ul>
      <li class="active"><a href="index.php">数据中心</a></li>
      <li><a href="noticeshow.php?showid=1">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li><?= $fourthmenu?></li>
    </ul>
  </div>
  <div role="main" class="main">
    <a href="#nav" class="nav-toggle">Menu</a>
    <!-- 内容头部 -->
    <h3 class="pull-left"><a href='javascript:history.go(-1)' class="glyphicon glyphicon-arrow-left" title="返回"></a>用户查询结果页:</h3>
    <p></p>
    <div class="infoall row">
      <div class="col-md-4">
        <div>
          <img src="<?= @$uheadpic?>" class="img-circle">
        </div>
      </div>
      <div class="col-md-6">
        <table class="table table-hover">
          <tbody>
            <tr class="row">
                <td><span class="">姓名:</span> <?= @$uname?></td>
                <td></td>
            </tr>
            <tr class="row">
                <td><span class="">身份:</span> <?= @$role?></td>
                <td></td>
            </tr>
            <tr class="row">
                <td><span class=""><?= $roleflag?>:</span> <?= @$uid?></td>
                <td></td>
            </tr>
            <tr class="row">
                <td class="col-md-5"><span class="">系别:</span> <?= @$udeptname?></td>
                <td class="col-md-5"><span class="">班级:</span> <?= @$uclassname?></td>
            </tr>
            <tr class="row">
                <td class="col-md-5"><span class="">状态:</span> <?= @$status?></td>
                <td class="col-md-5"><?= $weeknote?></td>
            </tr>
            <tr class="row">
                <td class="col-md-5"><span class="">邮箱:</span> <?= @$uemail?></td>
                <td class="col-md-5"><span class="">手机:</span> <?= @$uphone?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <table class="table table-hover">
        <tbody>
          <?php
          if ($pflag) {
            echo "<tr class='row'>";
            echo "<th width='5%'>状态</th>";
            echo "<th width='10%'>企业名称</th>";
            echo "<th width='10%'>我的岗位</th>";
            echo "<th width='10%'>企业联系人</th>";
            echo "<th width='10%'>联系手机号</th>";
            echo "<th width='10%'>联系邮箱</th>";
            echo "<th width='10%'>开始日期</th>";
            echo "<th width='15%'>填写时间</th>";
            echo "</tr>";
            for ($i=0; $i < $psum; $i++) { 
              echo "<tr class='row'>";
              echo "<td>".$u_pstatus[$i]."</td>";
              echo "<td>".$pcontent[$i]['p_company']."</td>";
              echo "<td>".$pcontent[$i]['p_job']."</td>";
              echo "<td>".$pcontent[$i]['p_tname']."</td>";
              echo "<td>".$pcontent[$i]['p_tphone']."</td>";
              echo "<td>".$pcontent[$i]['p_temail']."</td>";
              echo "<td>".$pcontent[$i]['p_startdate']."</td>";
              echo "<td>".$pcontent[$i]['p_writedate']."</td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <!-- script -->
    <script src="../js/jquery-1.12.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/responsive-nav.min.js"></script>
    <script src="../js/bootstrap-wysiwyg.js"></script>
    <script>
      var navigation = responsiveNav("foo", {customToggle: ".nav-toggle"});
    </script>
  </body>
</html>
