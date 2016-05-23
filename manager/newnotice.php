<?php
	require_once("../login/connmysql.php");
	session_start();
	if (isset($_POST['publish'])) {//判断是否点击了提交按钮
		if (isset($_POST['notice_title'])&&$_POST['notice_title']!="") {//是否输入标题
			if (isset($_POST['content'])&&$_POST['content']!="") {//是否输入内容
				$pubid = $_SESSION['user_id'];//获取用户id
				$pubname = $_POST['pubname']; //获取发布人用户名
				$object = $_POST['n_object'];//获取公告发布对象群体id
				$title = $_POST['notice_title'];//获取公告标题
				$content = $_POST['content'];//获取公告内容
				if (!empty($_FILES['n_attachment']['name'])) {//是否选择附件!empty($_FILES['file']['tmp_name'])
					if ($_FILES['n_attachment']['error'] == 0) {//是否有错误
			            $filename = iconv("utf-8", "gb2312//IGNORE", $_FILES['n_attachment']['name']);//文件名转码
			            if(move_uploaded_file($_FILES['n_attachment']['tmp_name'], "../attach/noticefile/".$filename)){
			                $upfile = $_FILES['n_attachment'];
			                $filenames = $upfile['name'];//获取文件名
			                $type = $upfile['type'];//获取文件类型
							switch ($type) {//文件类型判断
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
			                    	$fileurl = "noticefile/".$filenames;//设置上传后文件路径
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
				if ($isfile) {
					$sql = "insert into notice(n_id,n_pubname,n_object,n_title,n_content,n_attachment,n_pubtime) values('$pubid','$pubname','$object','$title','$content','$fileurl',now())";
					$res = $db->query($sql);
					if ($res) {
						echo "<script>alert('提交成功!');window.location.href='noticeshow.php?showid=1';</script>";
					}else{
						echo "<script>alert('对不起，数据写入失败!');history.go(-1);</script>";
					}
				}
			}else{
				echo "<script>alert('请输入文本！');history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('请输入标题！');history.go(-1);</script>";
		}
	}else{
		require_once("../login/illegal.php");//非法操作跳转重新登录
	}
?>