<?php
session_start();
include("config.php");
$id=null;
if( (isset($_SESSION['user_ID'])) && ($_SESSION['user_ID']!=null) ){
$id = $_SESSION['user_ID'];
$query10=mysqli_query($conn,"SELECT * FROM users WHERE user_ID = '$id' ");
$result = mysqli_fetch_array($query10);
}
error_reporting(0);

?>
<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <title>الرئيسية</title>
     <script>
            function myAlert() {
                alert("لم تسجل دخولك بعد!");
            }

            function myAlert2() {
                alert("لا يتاح لمدير التطبيق وموظف الأمن طلب الفزعة.");
            }

            function myAlert3() {
                alert("لا يتاح لمدير التطبيق وموظف الأمن تقديم الفزعة.");
            }

            function myAlert4() {
                alert("تم تعطيل عضويتك بسبب عدم التزامك بسياسة التطبيق");
            }

     </script>
        
 </head>
 <body>
     
    <a href="home.php"><img src="../images/logo1.png" class="logo3" ></a>
    <div class="home-bg">
            <h2>سواء تحتاج مساعدة او ضيعت غرض او حاب <br>تعرف فعاليات الجامعة </h2>
            <h3>🥇🌟 شارك الفزعة واكسب النقاط </h3>
            <a href="login.php"><button class="forward-btn1">تسجيل دخول</button></a>

        <!--حددي مكان الزر-->
        <a href="signUp.php"><button type="submit" class="forward-btn" >إنشاء حساب</button></a>

    </div>
        
     
     <div class="home-win">
         <img src="../images/win.png">
         <?php

         $query0=mysqli_query($conn,"SELECT * FROM `users` WHERE `points`=( SELECT MAX(points) FROM `users`) ");
         $result0=mysqli_fetch_array($query0);
         ?>
         <p><span style="color:red;">ملكة الفزعات</span> لهذا الأسبوع</p>
         <h1 class="dis"><?php if($result0['points'] != 0 ){echo $result0['first_name']." ".$result0['last_name'];}?></h1>
     </div>
     
     
     <br><br><br><br>
     <div class="tab">
		<button class="tablinks" onclick="openCity(event, 'event')"><i class="far fa-window-maximize icon"></i><br>ماذا يحدث الآن</button>
		<button class="tablinks" onclick="openCity(event, 'response')" id="defaultOpen"><i class="fas fa-user icon"></i><br>طلبات تحتاج فزعتك</button>
    </div>  
     
   <!------ استعراض الدورات والفعاليات ------>
   <?php
    $queryevent = mysqli_query($conn,"SELECT * FROM `events` ORDER BY event_ID DESC");
    $numevent=mysqli_num_rows($queryevent);
    if($numevent == 0){
  ?>
  <p class="">لا يوجد فعاليات أو دورات حاليًا</p>

 <?php
  }
  else{
  ?>
	<div id="event" class="tabcontent">
    <?php
    while ($event = mysqli_fetch_assoc($queryevent)){
    ?>
        <div class="box6">
            <?php
            
           echo"<img class='images' src='".$event['image']."' alt=''>";
                
            ?>
            <h3><?php echo $event['title']; ?></h3>
            <p><?php echo $event['details']; ?></p>
        </div>
 <?php
    }
  }
 ?>
    </div>
     
   
		 <!------ استعراض طلبات الفزعة ------>
	<div id="response" class="tabcontent">
        <center class="center-left-0">
            <?php   
                    date_default_timezone_set('Asia/Riyadh');
                    $date = date('Y:m:d');
                    $last6hour = time() - 6*60*60 ;
                    $time = date('h:i:s', $last6hour);
                    $query1 = mysqli_query($conn,"SELECT * FROM fazaa WHERE `status`='ينتظر فزعتك' AND `date`='$date' AND `date`>='$time' ORDER BY fazaa_ID DESC");
                    $num1=mysqli_num_rows($query1);
                    if($num1 == 0){
            ?>
            <p>لا يوجد طلبات فزعة حاليًا</p>
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
                   while($result1=mysqli_fetch_assoc($query1)){
                   $namequery=mysqli_query($conn,"SELECT * FROM users WHERE user_ID = '$result1[in_need_ID]'");
                   $name=mysqli_fetch_array($namequery);
                   if($id!=null){
                    $isDisabled=false;
                    if($id==$result1['in_need_ID']){
                    $isDisabled = true;
                 }
                }
            ?>
            <div class="b">
            <table class = "gfg">
                <tr> 
                    <td class = "geeks"><?php echo $name['first_name']." ".$name['last_name'];?></td>
                    <td class = "geeks"><?php echo $result1['fazaa_ID'];?></td>
                    <td><?php echo $result1['title'];?></td>
                    <td><?php echo $result1['type'];?></td>
                    <td><?php echo $result1['building'];?></td>
                    <td><?php echo $result1['period'];?></td>
                    <td>
                  <?php
                    if( (( $result['user_type']=='NormalUser') && ($result['user_status']=='فعال')) || (($result['user_type']=='Publisher') && ($result['user_status']=='فعال')) ){
                  ?>
                  <?php echo "<a href ='help.php?fazaaID=".$result1['fazaa_ID']."&status=".$result1['status']."&inNeedID=".$result1['in_need_ID']." '>";?>
                  <button type ="submit" class="btn" name="give-btn" <?php if($isDisabled==true){?> disabled <?php } ?> >تلبية الطلب</button>
                  </a>
                  <?php
                  }
                  else if( (( $result['user_type']=='NormalUser') && ($result['user_status']=='معطل')) || (($result['user_type']=='Publisher') && ($result['user_status']=='معطل')) ){
                    ?>
                    <button type ="submit" class="btn" name="give-btn" onclick="myAlert4()">تلبية الطلب</button>
                    <?php
                  }
                  else if(($result['user_type']=='Admin') || ($result['user_type']=='Employee')){
                  ?>
                   <button type ="submit" class="btn" name="give-btn" onclick="myAlert3()">تلبية الطلب</button>
                  <?php
                  }
                  else{
                  ?>
                   <button type ="submit" class="btn" name="give-btn" onclick="myAlert()">تلبية الطلب</button>
                  <?php
                  }
                  ?> 
                        </td>
                      </tr> 
                  </table> 
                  </div>
                  <?php
                   }  
                  }
                  ?>
        </center>
    </div>


     	<script>
		function openCity(evt, cityName) {
		    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }
		    document.getElementById(cityName).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
     
   
</body>
</html>