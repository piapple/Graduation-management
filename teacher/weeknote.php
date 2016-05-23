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
    if (isset($_GET['uid'])) {
      $u_id = $_GET['uid'];
    }else{
      require_once("../login/illegal.php");//非法操作跳转重新登录
      exit();
    }
    $sqls = "select * from user where u_id='$u_id'";
    $ress = $db->query($sqls);
    for($i=0;$rs=$ress->fetch_assoc();$i++){
      $u_student[$i] = $rs;
    }
    $sql = "select * from weeknote where w_id='$u_id'";
    $res = $db->query($sql);
    $sum = $res->num_rows;
    for($j=0;$rs=$res->fetch_assoc();$j++){
      $u_weeknote[$j] = $rs;
      if ($u_weeknote[$j]['w_attachments'] != "") {
        $attach[$j] = "<a href='../attach/downattach.php?w_url=".$u_weeknote[$j]['w_attachments']."' class='pull-right'>附件:".$u_weeknote[$j]['w_attachments']."</a>";
      }else{
        $attach[$j] = "";
      }
      if ($u_weeknote[$j]['w_reply'] != ''&&$roleid === '1') {
        $reply[$j] = "<p><span class='text-success'>我的回复：</span>".$u_weeknote[$j]['w_reply']."</p>";
      }else if($u_weeknote[$j]['w_reply'] == ''&&$roleid == '1'){
        $reply[$j] = "<textarea rows='3' maxlength='100' name='reply' class='form-control' style='resize:none;' required='required' placeholder='100字以内...'></textarea>";
        $reply[$j] .= "<input type='hidden' name='uid' value='$u_id' class='form-control btn btn-info'>";
        $reply[$j] .="<br/><input type='submit' name='replybtn' value='回复' class='form-control btn btn-info'>";
      }
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
        <li><a href="teacher.php">学生管理</a></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li class="active"><a href="student.php">周记管理</a></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h3><a href='javascript:history.go(-1)' class="glyphicon glyphicon-arrow-left" title="返回"></a>学生周记信息 <small><?= $u_student[0]['u_name']?></h3>
      <?php
        for ($i=0; $i <$sum ; $i++) { 
          echo "<table class='table table-hover' style='text-align:center;'><tbody><tr>";
          echo "<td>".($i+1)."</td>";
          echo "<td>截止时间:".$u_weeknote[0]['w_endtime']."</td>";
          echo "<td>填写时间:".$u_weeknote[0]['w_time']."</td>";
          echo "</tr></tbody></table>";
          echo "<p class='w_content'>".$u_weeknote[$i]['w_content']."</p>";
          echo $attach[$i];
          echo "<form action='reply.php?wid=".$u_weeknote[$i]['id']."' method='post'>";
          echo $reply[$i];
          echo "</form>";
        }
      ?>
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
