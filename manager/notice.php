<?php
    require_once("islogin.php");
	$res = $db->query("select * from notice");
	$sum = $res->num_rows;//获取公告总条数
	$showid = $_GET['showid'];//获取当前页要显示的数据的分页数
	$show = 4;//设置每页显示4条数据
	$showstart = $show*($showid-1);//计算显示数据的开始位置
    //通过id逆序输出从开始位置的4条数据
	$nsql = "select * from notice order by id desc limit $showstart,4";
    $nres = $db->query($nsql);
    //显示公告详情
	for ($i=0; $rows = $nres->fetch_assoc(); $i++) { 
    	$notice[$i] = $rows;
        echo "<tr>";
        echo "<td>".$notice[$i]['n_title']."</td>";
        echo "<td>".$notice[$i]['n_pubname']."</td>";
        echo "<td>".$notice[$i]['n_pubtime']."</td>";
        echo "<td><a href='shownotice.php?id=".$notice[$i]['id']."' title='查看公告'>查看</a></td>";
        echo "</tr>";
    }
?>
