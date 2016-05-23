<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <meta charset="utf-8">
    <title>毕业顶岗实习信息平台</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dropdown-min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
  <?php
    require_once("islogin.php");
    //1.判断是否有参数uid
    if (isset($_GET['uid'])) {
      $u_id = $_GET['uid'];
    }else{
      require_once("../login/illegal.php");//非法操作跳转重新登录
      exit();
    }
    //2.判断角色返回不同页面
    if ($roleid === '00') {
      $back = "<a href='index.php' class='glyphicon glyphicon-arrow-left' title='返回'></a>";
    }else if($roleid === '0') {
      $back = "<a href='student.php' class='glyphicon glyphicon-arrow-left' title='返回'></a>";
    }
    //3.获取学生信息
    $sqls = "select * from user where u_id='$u_id'";
    $ress = $db->query($sqls);
    for($i=0;$rs=$ress->fetch_assoc();$i++){
      $u_student[$i] = $rs;
    }
    //4.获取学生周记信息
    $sql = "select * from weeknote where w_id='$u_id'";
    $res = $db->query($sql);
    $sum = $res->num_rows;
    for($j=0;$rs=$res->fetch_assoc();$j++){
      $u_weeknote[$j] = $rs;
      $attach[$j] = "";//默认无附件
      if ($u_weeknote[$j]['w_attachments'] != "") {
        $attach[$j] = "<a href='../attach/downattach.php?w_url=".$u_weeknote[$j]['w_attachments']."' class='pull-right'>附件:".$u_weeknote[$j]['w_attachments']."</a>";
      }
      if ($u_weeknote[$j]['w_reply'] != ''&&$roleid === '0') {
        //指导教师已做回复
        $reply[$j] = "<p><span class='text-success'>我的回复：</span>".$u_weeknote[$j]['w_reply']."</p>";
      }else if ($u_weeknote[$j]['w_reply'] != ''&&$roleid === '00') {
        //系统管理员查看指导教师已做回复的内容
        $reply[$j] = "<p><span class='text-success'>指导教师回复：</span>".$u_weeknote[$j]['w_reply']."</p>";
      }else if($u_weeknote[$j]['w_reply'] == ''&&$roleid !== '00'){
        //普通管理员可对所指导学生周记进行回复
        $reply[$j] = "<textarea rows='3' maxlength='100' name='reply' class='form-control' style='resize:none;' required='required' placeholder='100字以内...'></textarea>";
        $reply[$j] .= "<input type='hidden' name='uid' value='$u_id' class='form-control btn btn-info'>";
        $reply[$j] .="<br/><input type='submit' name='replybtn' value='回复' class='form-control btn btn-info'>";
      }else if($roleid === '00'){
        //系统管理员查看指导教师未做回复显示
        $reply[$j] = "<p class='text-info'>指导教师未做回复!</p>";
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
        <li><?= $firstmenu?></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li><?= $fourthmenu?></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h3><?= $back?>学生周记信息 <small><?= $u_student[0]['u_name']?></small></h3>
      <?php
        for ($i=0; $i <$sum ; $i++) {
          echo "<table class='table table-hover' style='text-align:center;'><tbody><tr>";
          echo "<td>".($i+1)."</td>";
          echo "<td>截止时间：".$u_weeknote[0]['w_endtime']."</td>";
          echo "<td>提交时间：".$u_weeknote[0]['w_time']."</td>";
          echo "</tr></tbody></table>";
          echo "<p class='w_content'>".$u_weeknote[$i]['w_content']."</p>";
          echo $attach[$i];//附件
          echo "<form action='reply.php?wid=".$u_weeknote[$i]['id']."' method='post'>";
          echo $reply[$i];//回复
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
