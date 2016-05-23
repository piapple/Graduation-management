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
    //查询系部管理员人数
    $a_res = $db->query("select * from user where u_role_id='0'");
    $sum = $a_res->num_rows;
    for($i=0;$rs=$a_res->fetch_assoc();$i++){
        $u_rows[$i]=$rs;
    }
    //通过系部名称查询所有不重复系部名称
    $sqldept = "select distinct* from user where u_role_id='0' group by u_dept_name";
    $resdept = $db->query($sqldept);
    $deptsum = $resdept->num_rows;
    for($j=0;$dept=$resdept->fetch_assoc();$j++){
        $deptlist[$j]=$dept;
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
        <li><a href="index.php">数据中心</a></li>
        <li><a href="noticeshow.php?showid=1">公告栏</a></li>
        <li><a href="info.php">我的信息</a></li>
        <li class="active"><?= $fourthmenu?></li>
      </ul>
    </div>
    <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h2>系统管理</h2>
      <h4>管理员管理<small class="pull-right">共<?= $sum?>个管理员</small></h4>
      <table class="table table-hover">
      <tbody>
        <tr>
          <th width="5%">序号</th>
          <th width="15%">管理员部门</th>
          <th width="15%">姓名</th>
          <th width="6%">性别</th>
          <th width="10%">ID</th>
          <th width="12%">手机号码</th>
          <th width="17%">联系邮箱</th>
          <th width="10%">密码重置</th>
          <th width="10%">删除</th>
        </tr>
          <?php
            for ($i=0; $i < $sum; $i++) { 
                echo "<tr>";
                echo "<td>".($i+1)."</td>";
                echo "<td>".$u_rows[$i]['u_dept_name']."</td>";
                echo "<td>".$u_rows[$i]['u_name']."</td>";
                echo "<td>".$u_rows[$i]['u_sex']."</td>";
                echo "<td>".$u_rows[$i]['u_id']."</td>";
                echo "<td>".$u_rows[$i]['u_phone']."</td>";
                echo "<td>".$u_rows[$i]['u_email']."</td>";
                echo "<td><a href='repwd.php?uid=".$u_rows[$i]['u_id']."'>重置密码</a></td>";
                echo "<td><a href='deladmin.php?uid=".$u_rows[$i]['u_id']."'>删除</a></td>";
                echo "</tr>";
            }
          ?>
      </tbody>
      </table>
        <div class="row">
          <form method="post" action="adduser.php" onsubmit="return chk(this)">
          <div class="col-md-2">
            <input type="text" name="uname" class="form-control" placeholder="用户姓名" required="required">
          </div>
          <div class="col-md-2">
            <select  class="form-control" name="usex">
              <option value="男">男</option>
              <option value="女">女</option>
            </select>
          </div>
          <div class="col-md-2">
            <input type="text" name="uid" class="form-control" placeholder="ID" required="required" onkeyup="value=value.replace(/[\W]/g,'')">
          </div>
          <div class="col-md-2">
            <input type="text" name="superiorid" class="form-control" placeholder="上级ID" required="required" onkeyup="value=value.replace(/[\W]/g,'')">
          </div>
          <div class="col-md-2">
            <select  class="form-control" name="urole">
              <option value="0">管理员</option>
              <option value="1">指导教师</option>
              <option value="2">辅导员</option>
              <option value="3">实习学生</option>
            </select>
          </div>
          <div class="col-md-2">
            <select  class="form-control" name="dept_id">
              <?php
              for ($i=0; $i < $deptsum; $i++) { 
                echo "<option value='".$deptlist[$i]['u_dept_id']."'>".$deptlist[$i]['u_dept_name']."</option>";
              }
              ?>
            </select>
          </div>
        </div><br/>
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="classname" class="form-control" placeholder="班级名称(管理员和指导教师不填)">
          </div>
          <div class="col-md-2">
            <input type="submit" name="adduser" class="form-control btn btn-info" value="添加一个用户">
          </div>
          </form>
          <form method="post" action="../testExcel/upload.php" enctype="multipart/form-data">
            <div class="col-md-4">
              <input type="file" name="inputExcel" class="form-control" id="inputExcel" value="" accept=".xls,.xlsx" required="required">
            </div>
            <div class="col-md-2">
              <input type="submit" name="addusers" class="form-control btn btn-info" value="EXCEL批量添加">
            </div>
          </form>
        </div><br/>
        <table class="table table-hover">
          <tbody style="text-align:center;">
            <tr>
              <td>批量EXCEL表表格规范:</td>
              <td>学/工号</td>
              <td>角色ID</td>
              <td>姓名</td>
              <td>性别</td>
              <td>部门ID</td>
              <td>院系名称</td>
              <td>上级工号</td>
              <td>班级名称</td>
            </tr>
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
      function chk(x){
        if (!x.uid.value.match(/^[a-zA-Z0-9]+$/)) {
          alert("ID需为数字或字母");
          x.uid.focus();
          return false;
        }else if(!x.superiorid.value.match(/^[a-zA-Z0-9]+$/)){
          alert("上级ID需为数字或字母");
          x.superiorid.focus();
          return false;
        }
      }
    </script>
  </body>
</html>
