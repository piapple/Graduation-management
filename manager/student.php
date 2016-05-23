<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <meta charset="utf-8">
    <title>毕业顶岗实习信息平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!--[if lte IE 8]><link rel="stylesheet" href="../../responsive-nav.css"><![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dropdown-min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!--<![endif]-->
  </head>
  <body>
  <?php
    require_once("islogin.php");
    //查询学生信息
    $sql = "select * from user where u_superior_id=$name and u_role_id='3'";
    $res = $db->query($sql);
    $sum = $res->num_rows;
    for($i=0;$rs=$res->fetch_assoc();$i++){
      $u_student[$i] = $rs;
      $uid = $u_student[$i]['u_id'];
      //查询学生周记信息
      $sqlw = "select * from weeknote where w_id='$uid'";
      $resw = $db->query($sqlw);
      $row[$i] = $resw->num_rows;
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
        <li><?= $firstmenu?></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li class="active"><?= $fourthmenu?></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h2>实习学生管理<small class="pull-right">共<?= $sum?>个实习学生</small></h2>
      <table class="table table-hover" style="text-align:center;">
      <tbody>
        <tr class="h5">
          <td width="5%">序号</td>
          <td width="15%">姓名</td>
          <td width="10%">性别</td>
          <td width="10%">学号</td>
          <td width="20%">手机号</td>
          <td width="20%">邮箱</td>
          <td width="10%">班级</td>
          <td width="10%">完成周记数</td>
        </tr>
        <?php
          for ($i=0; $i <$sum ; $i++) { 
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$u_student[$i]['u_name']."</td>";
            echo "<td>".$u_student[$i]['u_sex']."</td>";
            echo "<td>".$u_student[$i]['u_id']."</td>";
            echo "<td>".$u_student[$i]['u_phone']."</td>";
            echo "<td>".$u_student[$i]['u_email']."</td>";
            echo "<td>".$u_student[$i]['u_class_name']."</td>";
            echo "<td><a href='weeknote.php?uid=".$u_student[$i]['u_id']."'>".$row[$i]."</a></td>";
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
