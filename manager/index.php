<!DOCTYPE html>
<html lang="zh_CN">
  <head>
    <meta charset="utf-8">
    <title>毕业顶岗实习信息平台</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="毕业顶岗实习信息平台Root组Demo">
    <meta name="keywords" content="毕业顶岗实习信息平台">
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="bookmark" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dropdown-min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
  <?php
    //1.引入用户是否登录
    require_once("islogin.php");
    //2.查询统计数据 查询系部管理员人数
    $a_res = $db->query("select count(*) from user where u_role_id='0'");
    if($rs=$a_res->fetch_array()){
        $a_rows=$rs[0];
    }
    // 查询指导教师人数
    $t_res = $db->query("select count(*) from user where u_role_id='1'");
    if($rs=$t_res->fetch_array()){
        $t_rows=$rs[0];
    }
    // 查询辅导员人数
    $i_res = $db->query("select count(*) from user where u_role_id='2'");
    if($rs=$i_res->fetch_array()){
        $i_rows=$rs[0];
    }
    // 查询实习学生人数
    $s_res = $db->query("select count(*) from user where u_role_id='3'");
    if($rs=$s_res->fetch_array()){
        $s_rows=$rs[0];
    }
    //2.查询系部数据
     //2.1系别名称(不重复)
    $a_sql = "select distinct* from user where u_role_id='0' group by u_dept_name";
    $a_res = $db->query($a_sql);
    $sum = $a_res->num_rows;
    for($i=0;$rs=$a_res->fetch_assoc();$i++){
      $u_rows[$i]=$rs;
      //2.2指导教师
      $t_res = $db->query("select * from user where u_dept_id='".$u_rows[$i]['u_dept_id']."' and u_role_id='1'");
      $t_rows[$i] = $t_res->num_rows;
      //2.3辅导员
      $i_res = $db->query("select * from user where u_dept_id='".$u_rows[$i]['u_dept_id']."' and u_role_id='2'");
      $i_row[$i] = $i_res->num_rows;
      //2.4学生
      $s_res = $db->query("select * from user where u_dept_id='".$u_rows[$i]['u_dept_id']."' and u_role_id='3'");
      $s_rows[$i] = $s_res->num_rows;
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
        <p><i class="glyphicon glyphicon-user"><?= $username?></i></p><!--用户名-->
        <p><?= $name?></p><p><a href="../login/logout.php">注销</a></p><!--注销-->
      </div>
    </div>
    <!-- 侧边导航 -->
    <ul>
      <li class="active"><a href="#">数据中心</a></li>
      <li><a href="noticeshow.php?showid=1">公告栏</a></li>
      <li><a href="info.php">我的信息</a></li>
      <li><?= $fourthmenu?></li>
    </ul>
  </div>
  <div role="main" class="main">
      <a href="#nav" class="nav-toggle">Menu</a>
      <!-- 内容头部 -->
      <h2>数据中心</h2>
      <!-- 表格显示 -->
      <table class="table table-hover text-center">
      <tbody>
        <tr>
          <th width="20%" class="text-center">用户类别</th>
          <th width="20%" class="text-center">系部管理员</th>
          <th width="20%" class="text-center">指导教师</th>
          <th width="20%" class="text-center">辅导员</th>
          <th width="20%" class="text-center">实习学生</th>
        </tr>
        <tr>
          <td>总人数</td>
          <td><?= $a_rows?></td>
          <td><?= $t_rows?></td>
          <td><?= $i_rows?></td>
          <td><?= $s_rows?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-hover text-center">
      <tbody>
        <tr>
          <th width="20%" class="text-center">系部名称</th>
          <th width="20%" class="text-center">指导教师人数</th>
          <th width="20%" class="text-center">辅导员人数</th>
          <th width="20%" class="text-center">学生人数</th>
          <th width="20%" class="text-center"></th><!-- 备用区 -->
        </tr>
        <?php
          for ($i=0; $i <$sum ; $i++) { 
            echo "<tr>";
            echo "<td>".$u_rows[$i]['u_dept_name']."</td>";//系部名称
            echo "<td>".$t_rows[$i]."</td>";//指导教师人数
            echo "<td>".$i_row[$i]."</td>";//辅导员人数
            echo "<td>".$s_rows[$i]."</td>";//学生人数
            echo "<td></td>";//备用区
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
    <!-- 查询某一用户的信息入口 -->
    <form action="searchres.php" method="post" class="form-horizontal" onsubmit="return chks(this)">
    <div class="row">
      <label for="search" class="col-md-2">用户信息查询入口:</label>
      <div class="col-md-4">
        <input type="text" name="search" id="search" class="form-control" placeholder="请输入学号/工号" required="required" onkeyup="value=value.replace(/[\W]/g,'')">
      </div>
      <div class="col-md-2">
        <input type="submit" name="searchbtn" class="btn btn-info form-control" value="查询">
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
      function chks(x){
        if (x.search.value.length==0) {
          alert("请输入数字或字母");
          x.search.focus();
          return false;
        };
        if (!x.search.value.match(/^[A-Za-z0-9]+$/)) {
          alert("含有非法字符:下划线");
          x.search.focus();
          return false;
        };
      }
    </script>
  </body>
</html>
