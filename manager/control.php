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
    //1.查询教师信息
    $sql = "select * from user where u_superior_id=$name and u_role_id='1'";
    $res = $db->query($sql);
    $sum = $res->num_rows;
    for($i=0;$rs=$res->fetch_assoc();$i++){
      $u_teacher[$i] = $rs;
      $uid = $u_teacher[$i]['u_id'];
      //初始化周记数为0
      if (!isset($wsum[$i])) {
        $wsum[$i] = 0;
      }
      //初始化回复数为0
      if (!isset($replysum[$i])) {
        $replysum[$i] = 0;
      }
      //2.查询该教师的带教学生人数
      $sqlstu = "select * from user where u_superior_id='$uid'";
      $stures = $db->query($sqlstu);
      $stusum[$i] = $stures->num_rows;
      //3.查询某老师的所有学生周计数
      $sqls = "select * from weeknote where w_id in (select u_id from user where u_superior_id='$uid' and u_role_id='3')";
      $ress = $db->query($sqls);
      $sums = $ress->num_rows;
      $wsum[$i]+=$sums;//累加求该教师所有学生总周记数
      //4.查询某老师的所有学生周计已回复数
      $reply = "select * from weeknote where w_id in (select u_id from user where u_superior_id='$uid' and u_role_id='3') and w_isreply='1'";
      $resreply = $db->query($reply);
      $replys = $resreply->num_rows;
      $replysum[$i]+=$replys;//累加求该教师的学生周记总已回复数
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
        <li class="active"><a href="#">教师管理</a></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li><?= $fourthmenu?></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h2>指导教师管理<small class="pull-right">共<?= $sum?>个指导教师</small></h2>
      <table class="table table-hover" style="text-align:center;">
      <tbody>
        <tr class="h5">
          <td width="5%">序号</td>
          <td width="15%">教师姓名</td>
          <td width="10%">教师工号</td>
          <td width="10%">性别</td>
          <td width="15%">带教学生人数</td>
          <td width="15%">手机号</td>
          <td width="20%">邮箱</td>
          <td width="10%">周记数/回复</td>
        </tr>
        <?php
          for ($i=0; $i <$sum ; $i++) { 
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$u_teacher[$i]['u_name']."</td>";
            echo "<td>".$u_teacher[$i]['u_id']."</td>";
            echo "<td>".$u_teacher[$i]['u_sex']."</td>";
            echo "<td>".$stusum[$i]."</td>";
            echo "<td>".$u_teacher[$i]['u_phone']."</td>";
            echo "<td>".$u_teacher[$i]['u_email']."</td>";
            echo "<td>".$wsum[$i]."/".$replysum[$i]."</td>";
            echo "<tr/>";
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
