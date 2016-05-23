<?php
	require_once("islogin.php");
  require_once("../login/connmysql.php");
  if (isset($_POST['addnote'])) {
    //获取表单数据
    $notetext = $_POST['notetext'];
    //是否选择附件!empty($_FILES['file']['tmp_name'])
    if (!empty($_FILES['noteattach']['name'])) {
      if($_FILES['noteattach']['error'] == 0) {//是否有错误
        $filename = iconv("utf-8", "gb2312//IGNORE", $_FILES['noteattach']['name']);//文件名转码
        if(move_uploaded_file($_FILES['noteattach']['tmp_name'], "../attach/notefile/".$filename)){
          $upfile = $_FILES['noteattach'];
          $filenames = $upfile['name'];//获取文件名
          $type = $upfile['type'];//获取文件类型
          switch ($type) {
            case 'application/x-zip-compressed':$fileType=true;//zip文件
              break;
            case 'application/octet-stream':$fileType=true;//rar文件  
                break;
            case 'application/msexcel':$fileType=true;//excel文件
                break;
            case 'application/mspowerpoint':$fileType=true;//ppt文件
                break;
            case 'application/msword':$fileType=true;//word文件
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':$fileType=true;//excel文件x
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':$fileType=true;//ppt文件x
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':$fileType=true;//word文件x
                break;
            case 'application/pdf':$fileType=true;//pdf文件
                break;
            case 'image/png':$fileType=true;//png图片
                break;
            case 'image/jpeg':$fileType=true;//jpg图片
                break;
            case 'text/plain':$fileType=true;//txt文件
                break;
            default :$fileType=false;//返回文件类型错误
                break;
          }
          $size = $upfile['size'];//获取文件大小
          if ($fileType==true) {//文件类型是否正确
              if ($size<=1024*1024) {//文件大小是否小于1M
                $isfile = true;//可用文件
                $fileurl = $filenames;//设置上传后文件路径"noticefile/"
              }else{
                $isfile = false;//文件大小错误
                echo "<script>alert('您选择的文件太大了');history.go(-1);</script>";
              }
          }else{
            $isfile = false;//文件类型错误
            echo "<script>alert('请上传ZIP,rar,PDf,txt,Office,png或jpg图片');history.go(-1);</script>";
          }
        }else{
          $isfile = false;//临时文件移动错误信息
          echo "<script>alert('Error move!');history.go(-1);</script>";
        }
      }else{
        $isfile = false;//文件错误信息
        echo "<script>alert('Error file');history.go(-1);</script>";
      }
    }else{
      $isfile = true;//不使用附件
      $fileurl = "";//未选择附件时文件路径为空
    }
    if($isfile) {
    	$sql = "insert into weeknote(w_id,w_content,w_attachments,w_time) values('$name','$notetext','$fileurl',now())";
    	$res = $db->query($sql);
    	if ($res) {
    		echo "<script>alert('提交成功!');window.location.href='mynote.php?noteid=1';</script>";
    	}else{
    		echo "<script>alert('提交失败，请重试!');history.go(-1);</script>";
    	}
    }
  }else{
    echo "<script>alert('Error Handel！');history.go(-1);</script>";
  }
?>
