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
        <li class="active"><a href="#">我的信息</a></li>
        <li><a href="student.php">周记管理</a></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h2>我的信息</h2>
      <div class="container" id="registered" style="margin-top: 60px;">
        <div class="row">
          <div class="col-md-3 avatar" style="text-align: center;">
            <p></p>
            <img src="<?= $headpic?>" alt="" width="200px" height="200px" class="img-circle">
            <p></p>
            <p>编号:<?= $name?><p>
            <p>最近一次登录时间:</p>
            <p><?= $lasted_login?></p>
          </div>
          <div class="col-md-1" style="">
          </div>
          <div class="col-md-6" style="">
             <h3>信息更新:<small>(输入框内默认的显示为上一次保存的信息)</small></h3>
            <form action="renew.php?renewid=<?= $name?>" method="post" onsubmit="return chk(this)">
              <div class="form-group">
                <label for="Email">邮箱</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="<?= $email?>">
              </div>
              <div class="form-group">
                <label for="Password1">密码</label>
                <input type="text" class="form-control" name="password" id="password" maxlength="16" placeholder="键入新密码(8-16位字母、数字或下划线)" onkeyup="value=value.replace(/[\W]/g,'')">
              </div>
               <div class="form-group">
                <label for="tel">手机号</label>
                <input type="tel" class="form-control" name="phone" id="phone" placeholder="<?= $phone?>" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="11">
              </div>
              <div class="form-group">
                <label for="remarks">备注</label>
                <textarea class="form-control" id="remarks" name="remark" rows="6"  placeholder="上海电子信息职业技术学院毕业顶岗实习系统" style="resize: none;" maxlength="200"><?= $remark?></textarea>
              </div>
              <div class="row" id="editor_info" style="margin-top:30px;">
                <div class="col-md-6">
                  <span class="glyphicon glyphicon-calendar">更新时间:<?= $renewtime?></span>
                </div>
                <div class="col-md-6" style="text-align: right;"><p></p>
                  <input type="submit" name="renew" class="btn btn-primary" value="修改信息">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- script -->
    <script src="../js/jquery-1.12.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/responsive-nav.min.js"></script>
    <script src="../js/bootstrap-wysiwyg.js"></script>
    <script>
      var navigation = responsiveNav("foo", {customToggle: ".nav-toggle"});
      function chk(x){
        if (x.password.value.length>0){
          if (x.password.value.length<6) {
            alert("密码需为8位以上");
            x.password.focus();
            return false;
          }else if(!x.password.value.match(/^[a-zA-Z0-9]+$/)){
            alert("密码需为数字或字母");
            x.password.focus();
            return false;
          }
        }
        if (x.phone.value.length>0&&x.phone.value.length!=11) {
          alert("请输入11位手机号");
          x.phone.focus();
          return false;
        }
      }
    </script>
  </body>
</html>
