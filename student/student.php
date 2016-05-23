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
    $sqlp = "select * from practice where p_id='$name'";
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
        <li class="active"><a href="#">我的实习</a></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li><a href="mynote.php?noteid=1">我的周记</a></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h3>我的实习信息<small class="pull-right">共<?= $row?>条数据</small></h3>
      <table class="table table-hover" style="text-align:center;">
      <tbody>
        <tr class="h5">
          <td width="5%">状态</td>
          <td width="10%">企业名称</td>
          <td width="10%">我的岗位</td>
          <td width="10%">企业联系人</td>
          <td width="10%">联系手机号</td>
          <td width="10%">联系邮箱</td>
          <td width="10%">开始日期</td>
          <td width="15%">填写时间</td>
        </tr>
        <?php
          for ($j=0; $j < $row; $j++) { 
            echo "<tr>";
            echo "<td>".$u_pstatus."</td>";
            echo "<td>".$u_practice[$j]['p_company']."</td>";
            echo "<td>".$u_practice[$j]['p_job']."</td>";
            echo "<td>".$u_practice[$j]['p_tname']."</td>";
            echo "<td>".$u_practice[$j]['p_tphone']."</td>";
            echo "<td>".$u_practice[$j]['p_temail']."</td>";
            echo "<td>".$u_practice[$j]['p_startdate']."</td>";
            echo "<td>".$u_practice[$j]['p_writedate']."</td>";
            echo "</tr>";
          }
        ?>
      </tbody>
      </table>
      <div class="addpractice">
        <form action="addpractice.php" method="post" onsubmit="return chk(this)">
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="pcompany" class="form-control" placeholder="企业名称" required="required" maxlength="20">
          </div>
          <div class="col-md-4">
            <input type="text" name="pjob" class="form-control" placeholder="实习岗位" required="required" maxlength="15">
          </div>
          <div class="col-md-4">
            <input type="text" name="ptname" class="form-control" placeholder="企业联系人" required="required" maxlength="10">
          </div>
        </div><br/>
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="ptphone" class="form-control" placeholder="联系号码" required="required"  onkeyup="value=value.replace(/[\D]/g,'')" maxlength="11">
          </div>
          <div class="col-md-4">
            <input type="email" name="ptemail" class="form-control" placeholder="联系邮箱" required="required" maxlength="25">
          </div>
          <div class="col-md-4">
            <input type="date" name="pstart" class="form-control" placeholder="开始时间格式:年-月-日" required="required">
          </div>
        </div><br/>
        <div>
          <input type="submit" name="addpractice" class="form-control btn btn-info" value="添加">
        </div>
        </form>
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
        if (x.ptphone.value.length>0&&x.ptphone.value.length!=11) {
          alert("请输入11位手机号");
          x.ptphone.focus();
          return false;
        }
      }
    </script>
  </body>
</html>
