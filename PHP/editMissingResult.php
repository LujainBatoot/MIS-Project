<?php
session_start();
include('config.php');
error_reporting(0);

if( isset($_SESSION['user_ID']) && $_SESSION['user_ID']!=null )
$id = $_SESSION['user_ID'];

if($id==null){
  header("location:home.php");
}
?>
<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تعديل مفقود</title>
        
 </head>
 <body>

                <img src="../images/logo1.png" class="logo">
     <br>
        <center class="center-left5">

           <table> 
             <p>أدخل البيانات المراد تحديثها هنا - يجب عليك إدخال رقم المفقود<p><br>
                <tr class="header4">     
                    <th>حالة المفقود</th>
                    <th>الصورة</th>
                    <th>الوصف</th> 
                    <th>فرع الأمن</th>
                    <th>تاريخ العثور</th>
                    <th>النوع</th>
                    <th>رقم المفقود <span style="color: red">*</span></th>
                    </tr> 
            </table> 

        <div class="b7"> 
        <form action="" method="POST" enctype="multipart/form-data">
            <table class = "gfg">
                <tr class="rows"> 
                    <td>                   
                        <select class="browse-dropList" name="status">
                            <option value="">...</option>
                            <option value="لم يتم الاستلام">لم يتم الاستلام</option>
                            <option value="تم الاستلام">تم الاستلام</option>
                            <option value="تم نقله إلى الأحوال المدينة">تم نقله إلى الأحوال المدينة</option>
                            <option value="تم نقله إلى القبول والتسجيل">تم نقله إلى القبول والتسجيل</option>
                        </select>
                    </td>
                    <td>                   
                    <input type="file"  name="file"  id="file" class="file-input">
                    </td>
                    <td><input type="text" name="Description" class="browse-dropList"/></td>
                    <td>                        
                        <select class="browse-dropList" name="branch">
                            <option value="">...</option>
                            <option value="أمن البوابة الشرقية">أمن البوابة الشرقية</option>
                            <option value="أمن البوابة الشمالية">أمن البوابة الشمالية</option>
                            <option value="أمن كلية الصيدلة">أمن كلية الصيدلة</option>
                        </select>
                    </td>
                    <td>                        
                        <select class="browse-dropList" name="date">
                            <option value="">...</option>
                            <option value="today">اليوم</option>
                            <option value="yesterday">أمس</option>
                        </select></td>
                    <td class = "geeks">
                        <select class="browse-dropList" name="type">
                            <option value="">...</option>
                            <option value="بطاقات">بطاقات</option>
                            <option value="مجوهرات">مجوهرات</option>
                            <option value="سماعات">سماعات</option>
                        </select></td>
                    <td class = "geeks"><input class="browse-dropList" type="text" name="missingID" placeholder="أدخل الرقم" required></td>
                </tr> 
            </table>
            <br>
            <button type="submit" class="update-btn" name="save-btn">حفظ</button>
            </center>
            

            <?php

                   
            if( (isset($_POST['save-btn'])) ){
              date_default_timezone_set('Asia/Riyadh');
              $today=date('Y-m-d');

              if($_POST['date']=='today'){
                $date = date("Y-m-d");
               }
               else if(($_POST['date']=='yesterday')){
                $date = date('Y-m-d',strtotime("-1 days"));
               }
               else{

               }

              if(!empty($_POST['missingID']) && !empty($_POST['type'])){
              mysqli_query($conn, "UPDATE `missings` SET `type`='$_POST[type]' WHERE `missing_ID`= '$_POST[missingID]' ");
              mysqli_query($conn, "INSERT INTO missings_management (`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
                           VALUES ('$id','$_POST[missingID]','$today','تعديل')");
                    
              }

              if(!empty($_POST['missingID']) && !empty($_POST['date'])){
              $update2 = " UPDATE  `missings` SET `found_date`='$_POST[date]'  WHERE `missing_ID`= '$_POST[missingID]' "; 
              mysqli_query($conn, $update2);
               
             mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
              VALUES ('$id','$_POST[missingID]','$today','تعديل')");
              }


              if(!empty($_POST['missingID']) &&  !empty($_POST['branch'])){
              $update3 = " UPDATE  `missings` SET `branch`='$_POST[branch]'  WHERE `missing_ID`= '$_POST[missingID]' ";
              mysqli_query($conn, $update3); 
  
              mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
                                  VALUES ('$id','$_POST[missingID]','$today','تعديل')");
              }

              if( !(empty($_POST['missingID'])) &&  !(empty($_POST['file'])) ){

                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type'];

                $fileExt = explode('.',$fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                
                if(in_array( $fileActualExt, $allowed)){
                  if($fileError===0){
                    if($fileSize <100000000000){
                    $fileNameNew = uniqid().date("Y-m-d-H-i-s").$fileName;
                    $fileDestination = "uploaded/".$fileNameNew;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    mysqli_query($conn," UPDATE  `missings` SET `image` = '$fileNameNew' WHERE `missing_ID` = '$_POST[missingID]' "); 
                    mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
                                        VALUES ('$id','$_POST[missingID]','$today','تعديل')");
                    ?>
                    <?php
                    }else{
                    ?>


                    <?php
                    }
                    }
                    else{
                    ?>
                    <label> حدث خطأ، حاول مجددا </label>
                    <?php
                    }
                    
                  }
                
                  else{
                    ?>
                    <label> JPEG-PNG-JPGيجب أن يكون نوع الصورة  </label>
                    <?php
                    }
          
              }

              if(!empty($_POST['missingID']) &&  !empty($_POST['Description'])){
                $update5 = " UPDATE  `missings` SET `Description`='$_POST[Description]' WHERE `missing_ID`= '$_POST[missingID]' ";
                mysqli_query($conn, $update5);
                 
                mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
                VALUES ('$id','$_POST[missingID]','$today','تعديل')");
                }

              if(!empty($_POST['missingID']) &&  !empty($_POST['status'])){
              $update6 = " UPDATE  `missings` SET `status`='$_POST[status]' WHERE `missing_ID`= '$_POST[missingID]' ";
              mysqli_query($conn, $update6);
             
              mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
              VALUES ('$id','$_POST[missingID]','$today','تعديل')");
              }   

              ?>   
              <?php
                          if(!empty($_POST['type']) || !empty($_POST['date']) ||  !empty($_POST['branch']) || !empty($_POST['file']) || !empty($_POST['Description']) || !empty($_POST['status'])){
                ?>
         
             <div class="result1"><label>تم تحديث البيانات بنجاح</label></div>
            
              <?php
                          }
                             }
            ?>
                    </form>

        </div>
        
        <br>

          <?php
             if((isset($_POST['search-btn']))){ 
              $missingID=$_POST["enter"];
              $type=$_POST['type'];

              date_default_timezone_set('Asia/Riyadh');
              $date=null;
              
              if($_POST['date']=='0'){
              $date = date('Y-m-d');
              $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR `type` ='$type' OR `found_date`='$date' ORDER BY missing_ID DESC ");
              }
              else if($_POST['date']=='0.1'){
              $date = date('Y-m-d',strtotime("-1 days"));
              $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' OR `found_date`='$date' ORDER BY missing_ID DESC ");
              }
              else if($_POST['date']=='1'){
              $date = date('Y-m-d',strtotime("-7 days"));
              $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' OR `found_date`>='$date' ORDER BY missing_ID DESC ");
              }
              else if($_POST['date']=='2'){
              $date= date('Y-m-d',strtotime("-14 days") );
              $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' OR `found_date`>='$date' ORDER BY missing_ID DESC ");
              }
              else if($_POST['date']=='4'){
              $date = date('Y-m-d',strtotime("-30 days"));
              $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' OR `found_date`>='$date' ORDER BY missing_ID DESC ");
              }
              else if($_POST['date']=='all'){
               $date = date('Y-m-d');
               $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' OR `found_date`<='$date' ORDER BY missing_ID DESC ");
              }
              else{
               $result=mysqli_query($conn,"SELECT * FROM  `missings` WHERE `missing_ID`= '$missingID' OR  `type` ='$type' ORDER BY missing_ID DESC ");
              }            
   

              $num=mysqli_num_rows($result);
              if($num != 0){
                ?>
                <p class="result">نتائج البحث :</p>

                <?php
                while($resultmissing=mysqli_fetch_array($result)){
                
          ?>
    <div class="down">
        <div class="b5">
          <form action="" method="POST">
            <table class = "gfg">

                <tr class="rows"> 
                    <td><label><?php echo $resultmissing['status'];?></label>
                    <td><img class="image" width="50" height="50" src="uploaded/<?php echo $resultmissing['image']; ?>" alt=""></td>
                    <td><?php echo $resultmissing['Description'];?></td>
                    <td><label><?php echo $resultmissing['branch'];?></label></td>
                    <td><label><?php echo $resultmissing['found_date'];?></label></td>
                    <td><label><?php echo $resultmissing['type'];?></label></td>
                    <td><label><?php echo $resultmissing['missing_ID'];?></label></td>
                    
                </tr> 
            </table> 
        </div>
    </div>
            </form>
            <?php
              }
            }
            else echo'<div class="result"><label>لا توجد نتيجة </label></div>';
          }
            ?>
            

        </center>

        
</body>
</html>