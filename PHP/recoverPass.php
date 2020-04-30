<?php
   session_start();
   if( isset($_SESSION['email']) && $_SESSION['email']!=null )
      $email = $_SESSION['email'];
?>
<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>نسيت كلمة المرور</title>
        
 </head>
 <body>

            <form action ="" method="post">
                <img src="../images/logo1.png" class="logo">
                <div class="changePass-bg">
                <div class="changePass-img">
                <br>
                <h2 class="header2">نسيان كلمة المرور</h2>
                <p class="paragraph2">سوف تصل رسالة تذكير بكلمة مرورك على بريدك الالكتروني</p>
                <input type="email" class="input-box-c" name="email" placeholder="البريد الإلكتروني" 
                value= "<?php echo $email; ?>" required> 
                   
                <br><br>
                <button type="submit" class="submit-btn" name="send-btn">إرسال</button>
                <br><br>
            <?php
          
              //تضمين ملف الاتصال بالقاعدة
              include("config.php");
              error_reporting(0);
                 
              //اذا تم النقر على الإرسال-1
              if(isset($_POST['send-btn'])){
              $email = $_POST['email'];
              $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `email` ='$email' ");
              $num = mysqli_num_rows($query);

              //إذا كان البريد الإلكتروني ليس مسجل-2
              if($num == 0){
            ?>

            <label class="error-msg1-ch" >.حسابك غير مسجل</label>

            <?php
                }
                else {
                //تخزين كلمة مرور المستخدم الموجودة في القاعدة
                $result = mysqli_fetch_array($query);
                $password = $result['passwords']; 

                //إرسال كلمة المرور إلى البريد المدخل
                $to = $email;
                $subject = "recover your password";
                $message = "This is your password from Fazaa : ".$password." .";         
                $from = "teamfazaa@gmail.com";
                $headers = 'From: teamfazaa@gmail.com';
                $done = mail($to,$subject,$message,$headers);

                //اذا نجحت عملبة الإرسال-3
                if( $done == true ) {
              ?>

              <label class="input-box-d" >.تم إرسال كلمة المرور على بريدك الإلكتروني</label>

             <?php
                }
                else {
              ?>

              <label class="error-msg1-ch" >.عذرًا توجد مشكلة، حاول لاحقَا/label>

              <?php
                 }
                }
               }
              //إغلاق الاتصال
              mysqli_close($conn);
            ?>   
            </div>
            </div>
         </form>
</body>
</html>