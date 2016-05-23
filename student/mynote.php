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
    require_once("../login/connmysql.php");
    if (isset($_GET['noteid'])) {
      $nowid = $_GET['noteid'];//获取要显示的数据的分页数
      $sql = "select * from weeknote where w_id='$name'";
      $res = $db->query($sql);
      $sum = $res->num_rows;
      $idnum = ceil($sum/3);
      if ($idnum == 0) {
        $idnum == 1;
      }
      $pre = $next = "";
      if ($nowid<=0) {
        require_once("../login/illegal.php");//非法操作跳转重新登录
        exit();
      }else if ($nowid > 1&&$nowid>$idnum) {
        require_once("../login/illegal.php");//非法操作跳转重新登录
        exit();
      }else{
        if ($nowid == 1&&$idnum >= 2) {//当前页为1且总页数大于等于2
          $next = "<a href='mynote.php?noteid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid < $idnum){//当前页大于1且小于总页数
          $pre = "<a href='mynote.php?noteid=".($nowid-1)."' title='上一页' class='btn glyphicon glyphicon-chevron-left'></a>";
          $next = "<a href='mynote.php?noteid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid == $idnum){//当前页为最后一页
          $pre = "<a href='mynote.php?noteid=".($nowid-1)."' title='上一页' class='btn glyphicon glyphicon-chevron-left'></a>";
        }
      }
      $show = 3;
      $showstart = $show*($nowid-1);
      $wsql = "select * from weeknote where w_id='$name' order by id desc limit $showstart,3";
      $wres = $db->query($wsql);
      $wrow = $wres->num_rows;
      for($j=0;$wrs=$wres->fetch_assoc();$j++){
        $u_weeknote[$j] = $wrs;
        if ($u_weeknote[$j]['w_attachments'] != "") {
          $attach[$j] = "<a href='../attach/downattach.php?w_url=".$u_weeknote[$j]['w_attachments']."' class='pull-right'>下载附件: ".$u_weeknote[$j]['w_attachments']."</a>";
        }else{
          $attach[$j] = "";
        }
        if ($u_weeknote[$j]['w_reply'] != ''&&$roleid === '3') {
          $reply[$j] = "<p><span class='text-success'>指导教师回复：</span>".$u_weeknote[$j]['w_reply']."</p>";
        }else if($roleid === '3'){
          $reply[$j] = "<p class='text-info'>指导教师未做回复!</p>";
        }
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
      <li><a href="student.php">我的实习</a></li>
      <li><a href="noticeshow.php?showid=1">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li class="active"><a href="mynote.php?noteid=1">我的周记</a></li>
    </ul>
  </div>
  <div role="main" class="main">
    <a href="#nav" class="nav-toggle">Menu</a>
    <!-- 内容头部 -->
    <span class="h2 pull-left">我的周记</span>
    <ul class="pull-right pagebar">
      <li>第<?= $nowid?>/<?= $idnum?>页 共<?= $sum?>篇</li>
      <li><?= $pre?></li>
      <li><?= $next?></li>
    </ul>
    <?php
      for ($i=0; $i <$wrow ; $i++) { 
        echo "<table class='table table-hover' style='text-align:center;'><tbody><tr>";
        echo "<td>".($i+1)."</td>";
        echo "<td>学号:".$u_weeknote[0]['w_id']."</td>";
        echo "<td>截止时间:".$u_weeknote[0]['w_endtime']."</td>";
        echo "<td>填写时间:".$u_weeknote[0]['w_time']."</td>";
        echo "</tr></tbody></table>";
        echo "<p class='w_content'>".$u_weeknote[$i]['w_content']."</p>";
        echo $attach[$i];
        echo $reply[$i]; 
      }
    ?><br/><br/>
    <h4>新建周记</h4>
    <form action="addnote.php" method="post" enctype="multipart/form-data">
      <div>
        <textarea name="notetext" class="form-control" rows="10" required="required"></textarea>
      </div><br/>
      <div class="row">
        <div class="col-md-2">
          <h5>可选择附件：</h5>
        </div>
        <div class="col-md-4">
          <input type="file" name="noteattach" class="form-control"  accept=".xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt,.png,.jpg,.pdf">
        </div>
        <div class="col-md-2 col-md-offset-4">
          <input type="submit" name="addnote" class="form-control btn btn-info" value="新建">
        </div>
      </div>
    </form><br/>
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
