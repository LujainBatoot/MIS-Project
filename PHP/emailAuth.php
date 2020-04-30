<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>التحقق من البريد الإلكتروني </title>
        
 </head>
 <body>

            <form action="" method="post">
                <img src="../images/logo1.png" class="logo">
                <div class="changePass-bg">
                    <div class="changePass-img">
                      <br>
                        <h2 class="header3">التأكد من البريد الالكتروني</h2>
                        <p class="paragraph3">أدخل رمز التحقق المرسل إلى بريدك </p>
                        <input type="text" class="input-box-check" name="code" placeholder="رمز التحقق" required>
                        <br><br>
                        <button type="submit" class="submit-btn" name="auth-btn">إرسال</button>
                        <br>
                        <?php

                          session_start();

                          //استقبال متغيرات الجلسة من صفحة إنشاء عضوية
                          if(isset($_SESSION['Fname']) && $_SESSION['Fname']!=null &&
                                isset($_SESSION['Lname']) && $_SESSION['Lname']!=null &&
                                isset($_SESSION['email']) && $_SESSION['email']!=null &&
                                isset($_SESSION['pass']) && $_SESSION['pass']!=null &&
                                isset($_SESSION['userType']) && $_SESSION['userType']!=null &&
                                isset($_SESSION['user_status']) && $_SESSION['user_status']!=null &&
                                isset($_SESSION['authcode']) && $_SESSION['authcode']!=null){
                                $_SESSION['Fname'];
                                $_SESSION['Lname'];
                                $_SESSION['email'];
                                $_SESSION['pass'];
                                $_SESSION['userType'];
                                $_SESSION['user_status'];
                                $_SESSION['authcode'];
                                $_SESSION['points']='0';
                                }     
                          // تضمين ملف الاتصال بالقاعدة
                          include('config.php');
                          error_reporting(0);
                    

                          //اذا تم النقر على زر التحقق-1
                          if((isset($_POST['auth-btn']))){ 

                            //اذا كان كود التحقق المدخل لا يطابق المرسل على البريد-2
                            if($_SESSION['authcode'] !=$_POST['code']){
                        ?>
                              <div class="error-msg1-ch"><label>.كود التحقق غير صحيح </label></div>
                        <?php
                                }
                                else{

                                  //استعلام إضافة عضوية المستفيد الجديد
                                  $add =" INSERT INTO `users` (`user_ID`, `first_name`, `last_name`, `email`, `passwords`, `user_type`,`user_status`,`points`) 
                                          VALUES (NULL, '$_SESSION[Fname]', '$_SESSION[Lname]','$_SESSION[email]' ,'$_SESSION[pass]' , '$_SESSION[userType]', '$_SESSION[user_status]',
                                          '$_SESSION[points]') ";

                                  //دالة تنفيذ الاستعلام
                                  mysqli_query($conn, $add);
                                    $_SESSION['newMail']=$_SESSION['email'];

                                  header("location:login.php");
                                } 
                            }
                            //اغلاق الاتصال بالقاعدة
                            mysqli_close($conn);
                        ?>
        
                    </div>
                 </div>
           </form>    
</body>
</html>