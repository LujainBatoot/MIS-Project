<?php
session_start();

//تضمين ملف الاتصال بالقاعدة
include('config.php');

if( isset($_SESSION['user_ID']) && $_SESSION['user_ID']!=null ){
   $id = $_SESSION['user_ID'];
    
  date_default_timezone_set('Asia/Riyadh');
  $date = date('Y:m:d');
  $timeMissing = mysqli_query($conn,"SELECT * FROM `missings` WHERE `missing_ID`=( SELECT MAX(missing_ID) FROM `missings`)");

    
  $num =mysqli_num_rows($timeMissing);
    
if($num!=0){
$result=mysqli_fetch_array($timeMissing); 
$theR=$result['missing_ID'];
mysqli_query($conn,"INSERT INTO `missings_management`(`emp_ID`, `missing_ID`, `edit_date`,`edit_type`) 
             VALUES ('$id','$theR','$date','إضافة')");
    
}
}


if($id==null){
  header("location:home.php");
 }




error_reporting(0);

if($id!= null){
  $query=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_ID`='$id' ");
  $result=mysqli_fetch_array($query);
  if($result['user_status']!= 'فعال'){
  header("location:home.php");
}
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
	<title>موظف الأمن</title>
	<meta charset="utf-8">
        <script>
        function myAlert(){
            alert("تم إضافة المفقود ");
        }
    </script>
</head>
<body>
    <a href="home.php"><img src="../images/logo1.png" class="logo" ></a>
	<div class="tab">

        <button class="tablinks" onclick="openCity(event, 'add')" id="defaultOpen"><i class="fas fa-folder-plus icon"></i><br>إضافة مفقود</button>
        <button class="tablinks" onclick="openCity(event, 'edit')"><i class="far fa-edit icon" ></i><br>تعديل مفقود</button>
        <button class="tablinks" onclick="openCity(event, 'setting')"><i class="fas fa-cog icon"></i><br>الاعدادات</button>
	</div>


    
    	<div id="add" class="tabcontent">
            <div class="center-height">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h1>إضافة مفقود</h1>
                    <p> إختر تصنيف الغرض المفقود   <br>
                        <select class="dropList" name="type" required>
                        <option value="بطاقات">بطاقات</option>
                        <option value="مجوهرات">مجوهرات</option>
                        <option value="سماعات">سماعات</option>
                        </select>
                    </p>
                    
                    <p> تاريخ العثور   <br>
                        <select class="dropList" name="date" required>
                            <option value="today">اليوم</option>
                            <option value="yesterday">أمس</option>
                        </select>
                    </p>
                    
                    <p> فرع الأمن   <br>
                        <select class="dropList" name="branch" required>
                        <option value="أمن البوابة الشرقية">أمن البوابة الشرقية</option>
                        <option value="أمن البوابة الشمالية">أمن البوابة الشمالية</option>
                        <option value="أمن كلية الصيدلة">أمن كلية الصيدلة</option>
                        </select>
                    </p>
                    
                    
                    <p> الوصف    <br>
                        <textarea rows="6" cols="50" name="Description" required></textarea>
                    </p>
                    <p><input type="file"  name="file" id="file"  onchange="loadFile(event)" style="display: none;" required></p>
                    <p><label for="file" style="cursor: pointer;">رفع صورة</label></p>
                    <br>
                    
                    <button type="submit" class="req-btn" name="upload" onclick="myAlert()">إرسال</button>
                    <?php
                    
                     date_default_timezone_set('Asia/Riyadh');
                   
                      if(isset($_POST['upload'])){
                        if($_POST['date']=='today'){
                          $date = date("Y-m-d");
                          $time = date("h:i:s");
                         }
                         else if($_POST['date']=='yesterday'){
                          $date = date('Y-m-d',strtotime("-1 days"));
                          $time = date("h:i:s");
                         }
                         else{
                           
                         }
                      $fileName = $_FILES['file']['name'];
                      $fileTmpName = $_FILES['file']['tmp_name'];
                      $fileSize = $_FILES['file']['size'];
                      $fileError = $_FILES['file']['error'];
                      $fileType = $_FILES['file']['type'];

                      $fileExt = explode('.',$fileName);
                      $fileActualExt = strtolower(end($fileExt));
                      $allowed = array('jpg','jpeg','png');
                      
                      if((in_array( $fileActualExt, $allowed)) || (empty($_POST['file'])) ){
                        if(($fileError===0) || (empty($_POST['file']))){
                          if($fileSize <100000000000){
                          $fileNameNew = uniqid().date("Y-m-d-H-i-s").$fileName;
                          $fileDestination = "uploaded/".$fileNameNew;
                          move_uploaded_file($fileTmpName,$fileDestination);
                          $sqlMissing ="INSERT INTO `missings`(`missing_ID`, `type`, `found_date`, `found_time`,`Description`, `image`, `status`, `branch`) 
                                        VALUES (NULL,'$_POST[type]','$date', '$time',
                                        '$_POST[Description]', '$fileNameNew', 'لم يتم الاستلام', '$_POST[branch]')";
                          mysqli_query($conn,$sqlMissing);
                          ?>
                                                    <?php
                          }else
                          ?>

                         
 
                          <?php
                          }
                          else{
                          ?>
                          <div class="check-msg"><label> حدث خطأ، حاول مجددا </label></div>
                          <?php
                          }
                          
                        }
                      
                        else{
                          ?>
                          <div class="check-msg"><label> JPEG-PNG-JPGيجب أن يكون نوع الصورة  </label></div>
                          <?php
                          }
                    }
                      ?>
                </form>
            </div>
    </div>
    
    <div id="edit" class="tabcontent">
        
        
          <form action="editMissingResult.php" method="POST">
            <p class="floatRight"> الفترة   <br>
                    <select class="browse-dropList" name="date">
                         <option value="..">..</option>
                        <option value="0">اليوم</option>
                        <option value="0.1">أمس</option>
                        <option value="1">أسبوع</option>
                        <option value="2">أسبوعين</option>
                        <option value="4">شهر</option>
                        <option value="all">جميع الأوقات</option>
                    </select>  
             </p>
            <p class="floatRight"> النوع   <br>
                    <select class="browse-dropList" name="type">
                        <option value="..">..</option>
                        <option value="بطاقات">بطاقات</option>
                        <option value="مجوهرات">مجوهرات</option>
                        <option value="سماعات">سماعات</option>
                    </select>
             </p>
        <center class="center-left6">
            <input type="text" class="bottom" name="enter" placeholder=" أدخل رقم المفقود">
            <button class="search-btn" name="search-btn">بحث</button> 
         </form>
        </center>
    </div>
    
    <div id="setting" class="tabcontent">
        <div class="up">
        <button onclick=" window.open('../php/resetPass.php','_blank')" type="button" class="setting-btn"><i class="fas fa-lock pass-icon"></i>تغيير كلمة المرور</button>
        <button onclick=" window.open('../php/contactUs.php','_blank')" type="button" class="setting-btn"><i class="fas fa-envelope pass-icon"></i>تواصل معنا</button>
        <button onclick=" window.open('../php/logout.php','_blank')" type="button" class="setting-btn"><i class="fas fa-sign-out-alt pass-icon"></i>تسجيل الخروج</button>    
        </div>
    </div>

	<script>
		function openCity(evt, tabName) {
		    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }
		    document.getElementById(tabName).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
    
</body>
</html>