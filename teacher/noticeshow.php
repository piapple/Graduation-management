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
    if (isset($_GET['showid'])) {
      $nowid = $_GET['showid'];//获取要显示的数据的分页数
      $sql = "select * from notice where n_object='1' or n_object='3'";
      $res = $db->query($sql);
      $sum = $res->num_rows;
      $idnum = ceil($sum/12);
      if ($idnum == 0) {
        $idnum == 1;
      }
      $pre = "";
      $next = "";
      if ($nowid<=0) {
        require_once("../login/illegal.php");//非法操作跳转重新登录
        exit();
      }else if ($nowid > 1&&$nowid>$idnum) {
        require_once("../login/illegal.php");//非法操作跳转重新登录
        exit();
      }else{
        if ($nowid == 1&&$idnum >= 2) {//当前页为1且总页数大于等于2
          $next = "<a href='noticeshow.php?showid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid < $idnum){//当前页大于1且小于总页数
          $pre = "<a href='noticeshow.php?showid=".($nowid-1)."' title='上一页' class='btn glyphicon glyphicon-chevron-left'></a>";
          $next = "<a href='noticeshow.php?showid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid == $idnum){//当前页为最后一页
          $pre = "<a href='noticeshow.php?showid=".($nowid-1)."' title='上一页' class='btn glyphicon glyphicon-chevron-left'></a>";
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
      <li><a href="teacher.php">学生管理</a></li>
      <li class="active"><a href="#">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li><a href="student.php">周记管理</a></li>
    </ul>
  </div>
  <div role="main" class="main">
    <a href="#nav" class="nav-toggle">Menu</a>
    <!-- 内容头部 -->
    <span class="pull-left h2">公告栏</span>
    <ul class="pull-right pagebar">
      <li><?= $pre?></li>
      <li><?= $next?></li>
    </ul>
    <table class="table table-hover">
      <tbody>
        <tr>
          <th width="55%" class="ifsee">标题</th>
          <th width="15%">发布人</th>
          <th width="20%">时间</th>
          <th width="10%"></th>
        </tr>
        <?php
          $showid = $_GET['showid'];
          $show = 12;
          $showstart = $show*($showid-1);
          $nsql = "select * from notice where n_object='1' or n_object='3' order by id desc limit $showstart,12";
          $nres = $db->query($nsql);
          $notice = null; 
          for ($i=0; $rows = $nres->fetch_assoc(); $i++) { 
              $notice[$i] = $rows;
              echo "<tr>";
              echo "<td class='ifsee'>".$notice[$i]['n_title']."</td>";
              echo "<td>".$notice[$i]['n_pubname']."</td>";
              echo "<td>".$notice[$i]['n_pubtime']."</td>";
              echo "<td><a href='shownotice.php?id=".$notice[$i]['id']."' title='查看公告'>查看</a></td>";
              echo "</tr>";
            }
        ?>
      </tbody>
    </table>
    <h4 class="pull-right">当前第<?= $nowid?>/<?= $idnum?>页,共<?= $sum?>条公告</h4>
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
