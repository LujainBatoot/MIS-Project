<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تغيير كلمة المرور</title>
        
 </head>
 <body>

            <form action="" method="POST">
                <img src="../images/logo1.png" class="logo">
                <div class="changePass-bg">
                <div class="changePass-img">
                <br>
                <h2 class="header2">تغيير كلمة المرور</h2>
                <input type="password" class="input-box-ch" name="old" placeholder="كلمة المرور القديمة" required>
                <input type="password" class="input-box-f" name="new" placeholder="كلمة المرور الجديدة" required>
                <input type="password" class="input-box-f" name="confirm" placeholder="تأكيد كلمة المرور الجديدة" required>
                <br>
                <button type="submit" class="submit-btn1" name="reset-btn">إرسال</button>
                <br>
                

                <?php
                   session_start();

                   if( isset($_SESSION['user_ID']) && $_SESSION['user_ID']!=null )
                       $id = $_SESSION['user_ID'];

                   // تضمين ملف الاتصال بالقاعدة
                   include('config.php');
                   error_reporting(0);


                   //اذا تم النقر على على زر التغيير-1
                   if(isset($_POST['reset-btn'])){ 
                       $old=$_POST["old"];
                       $new=$_POST["new"];
                       $confirm=$_POST["confirm"];
                       $query=mysqli_query($conn, "SELECT * FROM users WHERE user_ID='$id'");
                       $result=mysqli_fetch_array($query);

                       //اذا لم يتطابق حقل كلمة المرور القديمة مع كلمة المرور المخزنة-2
                       if($result["passwords"]!= $old){
                  ?>

                  <label class="error-msg1-ch" >.كلمة المرور الحالية ليست صحيحة</label>  

                  <?php
                       }
                       //اذا تطابق حقل كلمة المرور القديمة مع كلمة المرور المخزنة ولكن التأكيد لم يتطابق-3
                       else if (($result["passwords"] == $old) && ($new != $confirm)){
                  ?>

                  <label class="error-msg1-ch" >.حقل كلمة المرور الجديدة غير مطابق لحقل تأكيد كلمة المرور</label>

                  <?php
                       }
                       //اذا تطابق حقل كلمة المرور القديمة مع كلمة المرور القديمة و التأكيد مطابق -4
                       //ولكن المستخدم لم يقم بأي تغيير فعلي على كلمة المرور
                       else if(($result["passwords"] == $old) && ($new == $confirm) && ($old == $new)){
                  ?>

                  <label class="error-msg1-ch" >.يجب أن تختلف كلمة المرور الجديدة عن كلمة المرور القديمة</label>

                  <?php
                       }
                       else{

                           // التحقق من قوة كلمة المرور
                           $lowercase = preg_match('@[a-z]@',  $new);
                           $number    = preg_match('@[0-9]@',  $new);
                           $specialChars = preg_match('@[^\w]@',  $new);
                           $spaces = (preg_match('/\s/', $new));

                           //اذا لم تحقق كلمة المرور الشروط
                           if(!$lowercase || !$number || !$specialChars || (strlen($new) < 8 )|| $spaces) {
                   ?>
                   <label class="error-msg1-ch" >.كلمة المرور يجب أن تكون 8 خانات فأكثر بدون مسافات وتحتوي على حروف إنجليزية، على الأقل : 1 رمز، 1 عدد</label>
                   <?php       
                           }
                           else{
                           mysqli_query($conn, "UPDATE `users` SET `passwords`='$new' WHERE `user_ID` ='$id' ");
                   ?>
                   <label class="label-d" >.تم تغيير كلمة المرور بنجاح</label>
                   <?php
                           }
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