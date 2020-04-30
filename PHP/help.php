<?php
session_start();

if( isset($_SESSION['user_ID']) && $_SESSION['user_ID']!=null )
    $id = $_SESSION['user_ID'];

// تضمين ملف الاتصال بالقاعدة
include('config.php');
error_reporting(0);


if($id!= null){
  $query=mysqli_query($conn,"SELECT * FROM `users` WHERE `user_ID`='$id' ");
  $result=mysqli_fetch_array($query);
  if($result['user_status']!= 'فعال'){
  header("location:home.php");
}
}
?>
<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تقديم فزعة</title>
        
 </head>
 <body>

            <img src="../images/logo1.png" class='logo2'>
            <div class="right-box1">
     <img src="../images/logo3.png" class="logo1">
     <div class="bg1">
        <div class="container1">
            <form action="" method="post">
            <h2>تقديم فزعة</h2>
                <img src="../images/give.png">
                <p>مساحة لوصف مكانك أو علامة تميزك وكم بتنتظر صاحب الطلب عشان يجيك  <br>
                    <textarea type="text" class="input" cols="5" rows="5" name="details" required></textarea>
                    </p>
                <button type="submit" class="approve-btn" name="help-btn">يلا نفزع</button><br>

               <?php

                //اذا تم النقر على على زر التغيير-1
                if(isset($_POST['help-btn'])){ 
                       
                  $fazaaID = $_GET['fazaaID'];
                  $inNeedID = $_GET['inNeedID'];

                  $sql = "UPDATE `fazaa` SET `details` = '$_POST[details]', `Collaborator_ID`='$id' WHERE  `fazaa_ID`='$fazaaID' ";
                  mysqli_query($conn, $sql);

                  mysqli_query($conn, "UPDATE `fazaa` SET `status`='تم تلبية الطلب' WHERE `fazaa_ID` ='$fazaaID' ");

                  $queryEmail=mysqli_query($conn, "SELECT * FROM `users` WHERE `user_ID` = '$_GET[inNeedID]' ");
                  $resultEmail = mysqli_fetch_array($queryEmail);

                  $queryCollab=mysqli_query($conn,"SELECT * FROM users WHERE user_ID='$id'");
                  $resultCollab= mysqli_fetch_array($queryCollab);
                  $pointNow=(int)$resultCollab['points']+1;
                  mysqli_query($conn, "UPDATE `users` SET `points`='$pointNow' WHERE user_ID='$id' ");


                  $to = $resultEmail['email'];
                  $subject = " تم تلبية طلبك رقم ".$fazaaID;
                  $message ="
                  <html dir='rtl'>
                  <body>
                  <p> : المتعاون </p> ".$resultCollab['first_name']." ".$resultCollab['last_name']." 
                  <p> : التفاصيل </p>". $_POST['details'] ."
                  </body>
                  </html>";
                  $from ="teamfazaa@gmail.com";
                  $headers = "From:teamfazaa@gmail.com";
                  $headers.= "MIME-Version: 1.0" . "\r\n";
                  $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
                  $done = mail($to,$subject,$message,$headers);

                  //اذا نجحت عملبة الإرسال-3

                  if( $done == true ) {
                ?>
  
                <label class="input-box-d"><?php echo $resultCollab['first_name'];?> يعطيك العافية </label>
                <br>
                <label class="input-box-d"> تم إرسال إشعار لبريد طالبة الفزعة </label>
                <br>
                <label class="input-box-d">!وتم إضافة نقطة إلى حسابك </label>
  
               <?php
                  }
                  else {
                ?>
  
                <label class="error-msg2">.عذرًا توجد مشكلة، حاول لاحقَا</label>
  
                <?php
                  }
                }
                
                //إغلاق الاتصال
                mysqli_close($conn);
              ?>   
            </form>
        </div>
    </div>
  </div>

        
        <div class="left-box">
            <img src="../images/help1.jpg" alt="" class="help-img">
            <p class="caption">قال رسول الله صلى الله عليه وسلم:<br> المسلم أخو المسلم لا يظلمه ولا يسلمه، <br>ومن كان في حاجة أخيه كان الله في حاجته، ومن فرج عن<br> مسلم كربة فرج الله عنه كربة من كربات يوم القيامة. </p>
        </div>
    
   
</body>
</html>