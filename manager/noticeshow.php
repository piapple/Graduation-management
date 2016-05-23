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
    //1.判断地址栏是否设置参数showid
    if (isset($_GET['showid'])) {
      $nowid = $_GET['showid'];//获取当前页要显示的数据的分页数
      $res = $db->query("select * from notice");
      $sum = $res->num_rows;//获取公告总条数
      $idnum = ceil($sum/4);//设置每页显示4条数据并计算得到公告总页数
      //如果公告页数为0，设置为1使页面无公告信息时仍旧可以显示页面
      if ($idnum == 0) {
        $idnum == 1;
      }
      //当前页为1，初始化前进后退按钮为空，不显示
      $pre = $next = "";
      //2.判断获取的showid的有效性
      if ($nowid<=0) {
        require_once("../login/illegal.php");//无效，非法操作跳转重新登录
        exit();
      }else if ($nowid > 1&&$nowid>$idnum) {
        require_once("../login/illegal.php");//无效，非法操作跳转重新登录
        exit();
      }else{
        //当前页为1且总页数大于等于2
        if ($nowid == 1&&$idnum >= 2) {
          $next = "<a href='noticeshow.php?showid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid < $idnum){
          //当前页大于1且小于总页数
          $pre = "<a href='noticeshow.php?showid=".($nowid-1)."' title='上一页' class='btn glyphicon glyphicon-chevron-left'></a>";
          $next = "<a href='noticeshow.php?showid=".($nowid+1)."' title='下一页' class='btn glyphicon glyphicon-chevron-right'></a>";
        }else if($nowid > 1&&$nowid == $idnum){
          //当前页为最后一页
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
      <li><?= $firstmenu?></li>
      <li class="active"><a href="#">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li><?= $fourthmenu?></li>
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
          <th width="20%">发布时间</th>
          <th width="10%">内容</th>
        </tr>
        <?php
          require_once("notice.php");//公告
        ?>
      </tbody>
    </table>
    <h6 class="pull-right">当前第<?= $nowid?>/<?= $idnum?>页,共<?= $sum?>条公告</h6>
    <!-- 公告编辑器 -->
    <div class="box box-info">
      <div class="box-header ui-sortable-handle" style="">
        <i class="glyphicon glyphicon-edit"></i>
        <h3 class="box-title" style="display: inline-block;margin-left: 10px;">新公告</h3>
      <div>
    </div>
    <div>
    <form role="form" action="newnotice.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input type="text" name="notice_title" class="form-control" placeholder="请输入公告标题" maxlength="20" required>
      </div>
      <div class="form-group">
        <textarea name="content" class="form-control" rows="9" placeholder="请输入内容,可在底部选择添加附件" maxlength="500" required></textarea>
      </div>
      <div class="form-group row">
        <div class="col-md-3">
          <!-- 附件为可选项 -->
          <label for="noticefile" style="height:35px;line-height:35px;">请选择附件:小于1M</label>
        </div>
        <div class="col-md-4">
          <input type="file" id="noticefile" class="form-control btn" name="n_attachment" value="" accept=".zip,.rar,.txt,.doc,.docx,.xls,.xlsx,ppt,.pptx,.pdf,.png,.jpg"><!--multiple="multiple"-->
        </div>
        <div class="col-md-3">
          <!-- 输出公告对象 -->
          <?= $noticeObjOption ?>
        </div>
        <input type="hidden" name="pubname" value="<?= $username?>">
        <div class="col-md-2">
          <input type="submit" class="btn btn-primary pull-right" name="publish" value="发布"/>   
        </div>
      </div>
    </form>
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
