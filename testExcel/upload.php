<?php
require_once("../manager/islogin.php");
if(isset($_POST['addusers'])){
    if (!empty($_FILES['inputExcel']['name'])) {
        $filename = iconv("utf-8", "gb2312//IGNORE", $_FILES['inputExcel']['name']);//文件名转码
        $tmp_name = $_FILES['inputExcel']['tmp_name'];
        uploadFile($filename,$tmp_name);//调用uploadFile方法
    }
}else{
    require_once("../login/illegal.php");//非法操作跳转重新登录
    exit();
}
//导入Excel文件
function uploadFile($file,$filetempname){
    // 自己设置的上传文件存放路径
    $filePath = 'excelfile/';
    $str = "";   
    //下面的路径按照你PHPExcel的路径来修改
    require_once 'Classes/PHPExcel.php';
    //require_once '../PHPExcel/PHPExcel/IOFactory.php';
    require_once 'Classes/PHPExcel/Reader/Excel5.php';
    //注意设置时区
    $time=date("y-m-d-H-i-s");//去当前上传的时间 
    //上传后的文件名
    $name=$time.$file;
    //上传后的文件名地址 
    $uploadfile=$filePath.$name;
    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
    $result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
    if($result) //如果上传文件成功，就执行导入excel操作
    {
       include "../login/connmysql.php";
       // $objReader = new PHPExcel_Reader_Excel5();
        $objReader = new PHPExcel_Reader_Excel2007();
        $upfile = $_FILES['inputExcel'];//获取到文件
        $type = $upfile['type'];//获取文件类型
        switch ($type) {//文件类型判断
            case 'application/msexcel':$fileType=true;//excel文件
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':$fileType=true;//excel文件x
                break;
            default :$fileType=false;//返回文件类型错误
                break;
            }
        if (!$fileType) {
            echo "<script>alert('请上传excel文件');history.go(-1);";
            exit();
        }
        //$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format 
        // $uploadfile='test.xlsx';
    	$objPHPExcel = $objReader->load($uploadfile); 
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow();           //取得总行数 
        $highestColumn = $sheet->getHighestColumn(); //取得总列数
        
        /* 第二种方法*/
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); 
        // echo 'highestRow='.$highestRow;
        // echo "<br>";
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        // echo 'highestColumnIndex='.$highestColumnIndex;
        // echo "<br>";
        $headtitle=array(); 
        for ($row = 2;$row <= $highestRow;$row++)
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }    
            $headpicurl = "../userimg/".$strs[0].".png";
            $sql = "INSERT INTO user(u_id,u_role_id,u_name,u_sex,u_dept_id,u_dept_name,u_superior_id,u_class_name,u_headpic) VALUES (
            '{$strs[0]}',
            '{$strs[1]}',
            '{$strs[2]}',
            '{$strs[3]}',
            '{$strs[4]}',
            '{$strs[5]}',
            '{$strs[6]}',
            '{$strs[7]}',
            '{$headpicurl}'
            )";
            if($db->query($sql)){
                echo "<script>alert('导入成功!');window.location.href='../manager/system.php';</script>";
            }
        }
    }else{
      echo "<script>alert('导入失败！');history.go(-1);</script>";
    } 
}
?>