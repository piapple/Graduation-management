<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <meta charset="utf-8">
    <title>毕业顶岗实习信息平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dropdown-min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
  <?php
    require_once("islogin.php");
    if (isset($_GET['uid'])) {
      $u_pid = $_GET['uid'];
      $sql = "select * from user where u_id=$u_pid";
      $res = $db->query($sql);
      $sum = $res->num_rows;
      for($i=0;$rs=$res->fetch_assoc();$i++){
        $u_student[$i] = $rs;
        $u_pname = $u_student[$i]['u_name'];
      }
      $sqlp = "select * from practice where p_id='$u_pid'";
      $resp = $db->query($sqlp);
      $row = $resp->num_rows;
      for($j=0;$rsp=$resp->fetch_assoc();$j++){
        $u_practice[$j] = $rsp;
        if ($u_practice[$j]['p_status'] == 1) {
          $u_pstatus = "实习";
        }else if($u_practice[$j]['p_status'] == 0){
          $u_pstatus = "过期";
        }
      }
    }else{
      require_once("../login/illegal.php");//非法操作跳转重新登录
    }
  ?>
  <!-- 侧边导航-->
  <div role="navigation" id="foo" class="nav-collapse">
    <!--侧边头像 -->
    <p class="title">毕业顶岗实习信息平台</p>
      <div class="user-panel">
        <div class="image">
          <img src="<?= $headpic?>" class="img-circle headpic" alt="User Image">
        </div>
        <div class="info">
          <p><i class="glyphicon glyphicon-user"><?= $username?></i></p>
          <p><?= $name?></p><p><a href="../login/logout.php">注销</a></p>
        </div>
      </div>
      <!-- 侧边导航 -->
      <ul>
        <li class="active"><a href="teacher.php">学生管理</a></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li><a href="student.php">周记管理</a></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h3><a href='javascript:history.go(-1)' class="glyphicon glyphicon-arrow-left" title="返回"></a> 学生实习信息<small class="pull-right">共<?= $row?>条实习信息</small></h3>
      <table class="table table-hover" style="text-align:center;">
      <tbody>
        <tr class="h5">
          <td width="5%">序号</td>
          <td width="10%">学生姓名</td>
          <td width="10%">学生学号</td>
          <td width="10%">企业名称</td>
          <td width="10%">学生岗位</td>
          <td width="10%">企业联系人</td>
          <td width="10%">联系手机号</td>
          <td width="10%">联系邮箱</td>
          <td width="10%">开始日期</td>
          <td width="10%">填写日期</td>
          <td width="5%">状态</td>
        </tr>
        <?php
          for ($j=0; $j < $row; $j++) { 
            echo "<tr>";
            echo "<td>".($j+1)."</td>";
            echo "<td>".$u_pname."</td>";
            echo "<td>".$u_pid."</td>";
            echo "<td>".$u_practice[$j]['p_company']."</td>";
            echo "<td>".$u_practice[$j]['p_job']."</td>";
            echo "<td>".$u_practice[$j]['p_tname']."</td>";
            echo "<td>".$u_practice[$j]['p_tphone']."</td>";
            echo "<td>".$u_practice[$j]['p_temail']."</td>";
            echo "<td>".$u_practice[$j]['p_startdate']."</td>";
            echo "<td>".$u_practice[$j]['p_writedate']."</td>";
            echo "<td>".$u_pstatus."</td>";
            echo "</tr>";
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
