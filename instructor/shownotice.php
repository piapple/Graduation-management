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
    require_once("../login/connmysql.php");
    $id = $_GET['id'];//获取要显示的公告的id
    $sql = "select * from notice where id='$id'";//在数据库中查询该公告id
    $res = $db->query($sql);
    $row = $res->num_rows;
    if ($row == 1&&$id>0) {//存在
      $content = $res->fetch_assoc();//获得关联数组
      $status = $content['n_status'];//获取该公告的有效性状态
      if ($status == 1) {
        $title = $content['n_title'];//获取公告标题
        $pubid = $content['n_id'];//获取发布公告的管理员id
        $text = $content['n_content'];//公告内容
        $time = $content['n_pubtime'];//发布时间
        $attach = $content['n_attachment'];//公告附件地址路径
        if ($attach != "") {//附件
          $link = "下载公告附件";//显示
        }else{
          $link = "";//不显示下载附件连接
        }
      }else{//无效
        echo "<script>alert('该公告已失效');history.go(-1);</script>";
      }
    }else{//不存在
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
      <li><a href="instructor.php">学生管理</a></li>
      <li class="active"><a href="noticeshow.php?showid=1">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li><a href="student.php">周记管理</a></li>
    </ul>
  </div>
  <div role="main" class="main">
    <a href="#nav" class="nav-toggle">Menu</a>
    <!-- 内容头部 -->
    <h3 class="pull-left"><a href='javascript:history.go(-1)' class="glyphicon glyphicon-arrow-left" title="返回"></a> <?= $title?></h3>
    <div class="notice">
      <p><span class='glyphicon glyphicon-calendar'><?= $time?></span></p>
      <p class="noticetext"><?= $text?></p>
      <p><a href="../attach/downattach.php?n_url=<?= $attach?>"><?= $link?></a></p>
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
