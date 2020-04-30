<?php
session_start();

if( (isset($_SESSION['user_ID'])) && ($_SESSION['user_ID']!=null) )
$id = $_SESSION['user_ID'];

if($id==null){
 header("location:home.php");  
}


//تضمين ملف الاتصال بالقاعدة
include('config.php');
error_reporting(0);


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
  <a href="home.php"><img src="../images/logo1.png" class="logo" ></a>
	<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'add')" ><i class="fas fa-user-plus icon" id="defaultOpen"></i><br>إضافة عضوية</button>
    <button class="tablinks" onclick="openCity(event, 'edit')"><i class="far fa-edit icon"></i><br>تعديل عضوية</button>
    <button class="tablinks" onclick="openCity(event, 'event')" ><i class="far fa-window-maximize icon"></i><br>ماذا يحدث الآن</button>
    <button class="tablinks" onclick="openCity(event, 'response')" ><i class="fas fa-hand-holding-heart icon"></i><br>طلبات الفزعة</button> 
    <button class="tablinks" onclick="openCity(event, 'setting')"><i class="fas fa-cog icon"></i><br>الاعدادات</button>
	</div>

	<div id="add" class="tabcontent">
            <div class="container-add">
            <form action= "" method="post">
            <h1>إضافة عضوية</h1>
                <input type="text" class="input-box1-add" name="Fname" placeholder="الاسم الأول" required>
                <input type="text" class="input-box2-add" name="Lname" placeholder="الاسم الأخير" required>
                <br>
                <input type="email" class="input-box" name="email" placeholder="البريد الإلكتروني" required>
                <br>
                <input type="password" class="input-box" name="pass" placeholder="كلمة المرور" required>
                <select id="mySelect" name="userType" class="input-box-add">
                        <option value="">نوع المستخدم</option>
                        <option value="Employee">مستفيد</option>
                        <option value="Employee">موظفة أمن</option>
                        <option value="Publisher">مسؤولة فعاليات</option>
                </select>
                <br>
                <button type="submit" class="add-btn1" name="sign-btn">إنشاء حساب</button>
                <?php
                 include('config.php');
         if ( (isset($_POST['sign-btn']))){ 
              $Fname=$_POST["Fname"];
              $Lname=$_POST["Lname"];
              $email=$_POST["email"];
              $pass=$_POST["pass"];
              $userType =$_POST["userType"];
              $mailCheck="SELECT email FROM users WHERE email= '$email' ";
              $resultCheck=mysqli_query($conn, $mailCheck);
              $num=mysqli_num_rows($resultCheck);
              if($num == 1)
              {
              ?>
              <div class="error-msg1-ma"><label>هذا الحساب مسجل بالفعل </label></div>
              <?php
              }
              else{
              $fNameAr=preg_match('/[اأإء-ي]/ui', $Fname);
              $lNameAr=preg_match('/[اأإء-ي]/ui', $Lname);
              // اذا كان الاسم الأول أو الأخير بغير الحروف العربية-4
              if( !($fNameAr) || !($lNameAr) ){
              ?>
               
               <label class="error-msg1">الاسم الأول والأخير يجب أن يكون باللغة العربية</label>
              <?php
              }else{
                  
              $newAcc =" INSERT INTO `users` (`user_ID`, `first_name`, `last_name`, `email`, `passwords`, `user_type`,`points`)
                         VALUES (NULL, '$Fname', '$Lname','$email' ,'$pass' , '$userType','0')";
              mysqli_query($conn, $newAcc); 
              echo "<br>.تم إنشاء الحساب بنجاح";
              }
              }
            }
                ?>
            </form>
        </div>
    </div>


    <div id="edit" class="tabcontent">
        <center class="center-left6">
        <form action="editMemberResult.php" method="GET">
        <input type="text" class="bottom" name="ID" placeholder="أدخل رقم العضوية أو البريد الإلكتروني" required>
        <button type='submit' class='search-btn'>بحث</button>
        </form>
        </center>
    </div>
    
     <!------ استعراض الدورات والفعاليات ------>
  <?php
    $queryevent = mysqli_query($conn,"SELECT * FROM `events` ORDER BY event_ID DESC");
    $numevent=mysqli_num_rows($queryevent);
    if($numevent == 0){
  ?>
  <p class="no">لا يوجد فعاليات أو دورات حاليًا</p>

 <?php
  }
  else{
  ?>
	<div id="event" class="tabcontent">
    <?php
    while ($event = mysqli_fetch_assoc($queryevent)){
    ?>
        <div class="box0">
                          <?php
            
           echo"<img class='images' src='".$event['image']."' alt=''>";
                ?>
            <h3><?php echo $event['title']; ?></h3>
            <p><?php echo $event['details'] .", الناشر:" .$event['publisher_ID']; ?></p>

        </div>
 <?php
    }
  }
 ?>
    </div>

 <!------ استعراض طلبات الفزعة ------>
	<div id="response" class="tabcontent">
        <center class="center-left00">
            <?php   
                    date_default_timezone_set('Asia/Riyadh');
                    $date = date('Y:m:d');
                    $last6hour = time() - 6*60*60 ;
                    $time = date('h:i:s', $last6hour);
                    $query = mysqli_query($conn,"SELECT * FROM fazaa  ORDER BY fazaa_ID DESC");
                    $num=mysqli_num_rows($query);
                    if($num == 0){
            ?>
            <p class="no">لا يوجد طلبات فزعة حاليًا</p>
            <?php
                   }
                   else{
            ?>
            <table> 
                <tr> 
                    <th>الاسم</th>
                    <th>رقم الطلب</th>
                    <th>الغرض</th>
                    <th>نوع الغرض</th>
                    <th>المبنى</th>
                    <th>المدة</th> 
                    <th>حالة الطلب</th>
                    </tr> 
            </table> 

            <?php
                   while($result=mysqli_fetch_assoc($query)){
                   $namequery=mysqli_query($conn,"SELECT * FROM users WHERE user_ID = '$result[in_need_ID]'");
                   $name=mysqli_fetch_array($namequery);
                   $isDisabled=false;
                   if($id==$result['in_need_ID']){
                      $isDisabled = true;
                }
            ?>
            <div class="b">
            <table class = "gfg">
                <tr> 
                    <td class = "geeks"><?php echo $name['first_name']." ".$name['last_name'];?></td>
                    <td class = "geeks"><?php echo $result['fazaa_ID'];?></td>
                    <td><?php echo $result['title'];?></td>
                    <td><?php echo $result['type'];?></td>
                    <td><?php echo $result['building'];?></td>
                    <td><?php echo $result['period'];?></td>
                    <td><?php echo $result['status'];?></td>
                </tr> 
            </table> 
            </div>
            <?php
                    }
                   }
                  
            ?>
        </center>
    </div>
    
    <div id="setting" class="tabcontent">
        <div class="up1">
        <button onclick=" window.open('../php/resetPass.php','_blank')" type="button" class="setting-btn1"><i class="fas fa-lock pass-icon"></i>تغيير كلمة المرور</button>
        <button onclick=" window.open('../php/logout.php','_blank')" type="button" class="setting-btn1"><i class="fas fa-sign-out-alt pass-icon"></i>تسجيل الخروج</button>
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

		document.getElementById("defaultOpen").click();
  </script>
    
    <script>
    function saveText(){
      var xr = new XMLHttpRequest();
      var url = 'edit.php';
      var text1= "userID="+document.getElementById('userID').innerHTML;
      var text2= "Fname="+document.getElementById('Fname').innerHTML;
      var text3= "Lname="+document.getElementById('Lname').innerHTML;
      var text4= "pass="+document.getElementById('pass').innerHTML;
      var text5= "email="+document.getElementById('email').innerHTML;
      var text6= "userType="+document.getElementById('userType').innerHTML;
      var text7= "status="+document.getElementById('status').innerHTML;
      xr.open('POST',url,true);
      xr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
      xr.send(text1&text2&text3&text4&text5&text6&text7);
    }
  </script>
<script>
var current_index = $("#tabs").tabs("option","active");
$("#tabs").tabs('load',current_index);
    </script>
</body>
</html>