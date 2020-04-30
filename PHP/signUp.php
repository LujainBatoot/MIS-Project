<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>إنشاء حساب</title>
        
 </head>
 <body>
     <a href="home.php"><img src="../images/logo1.png" class="logo" ></a>
     <div class="bg">
        <div class="container">
            <form  action ="" method="post">
            <h1>إنشاء حساب</h1>
                <input type="text" class="input-box1" name="Lname" placeholder="الاسم الأخير" required>
                <input type="text" class="input-box2" name="Fname" placeholder="الاسم الأول" required>
                <br>
                <input type="email" class="input-box" name="email" placeholder="البريد الإلكتروني" required>
                <br>
                <input type="password" class="input-box" name="pass" placeholder="كلمة المرور" required>
                <input type="password" class="input-box" name="pass-confirm" placeholder="تأكيد كلمة المرور" required>
                <p> أوافق على <a href="terms&conditions.php">الشروط والأحكام</a><span><input type="checkbox" required></span></p>
                <button type="submit" class="sign-btn" name="sign-btn">إنشاء حساب</button>
                <br>
                <?php
                  session_start();

                  //تضمين ملف الاتصال بالقاعدة
                  include('config.php');
                   error_reporting(0);

                  
                  //في حالة نقر زر التسجيل-1 
                  if((isset($_POST['sign-btn']))){ 
                    $password=$_POST['pass'];
                    $passConfirm=$_POST['pass-confirm'];
                    $Fname= $_POST['Fname'];
                    $Lname=$_POST['Lname'];
                    $email=$_POST['email'];

                    //الاستعلام عن وجود عضوية مسجلة
                    $query=mysqli_query($conn, "SELECT * FROM users WHERE email= '$email' ");
                    $num=mysqli_num_rows($query);

                    //2-اذا وجد بريد مطابق
                    if($num == 1){ 
                      $result=mysqli_fetch_array($query);

                      //3-اذا كانت عضوية المستخدم معطلة   
                      if ($result['user_status'] == 'معطل'){
                 ?>

                 <label class="error-msg1" >.تم إلغاء عضويتك بسبب مخالفتك لسياسة التطبيق</label>

                 <?php
                      }
                      //عضوية المستخدم ليست معطلة ولكن يوجد عضوية مسبقًا
                      else{
                  ?>

                 <label class="error-msg1">.أنت مسجل بالفعل</label>

                <?php
                      }
                    }

                    else{
                    $fNameAr=preg_match('/[اأإء-ي]/ui', $Fname);
                    $lNameAr=preg_match('/[اأإء-ي]/ui', $Lname);
                    // اذا كان الاسم الأول أو الأخير بغير الحروف العربية-4
                    if( !($fNameAr) || !($lNameAr) ){
                ?>

                <label class="error-msg1">الاسم الأول والأخير يجب أن يكون باللغة العربية</label>

                <?php
                    }
                    else {
                    //5-اذا لم تتطابق كلمة المرور المدخلة مع التأكيد  
                    if(!($password == $passConfirm)){
                ?>

                <label class="error-msg1">حقل كلمة المرور غير مطابق لحقل تأكيد  كلمة المرور</label>

                <?php
                    }
                    else{
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);
                    $spaces = (preg_match('/\s/', $password));

                    // اذا لم تحقق كلمة المرور الشروط المطلوبة-6
                    if(!$lowercase || !$number || !$specialChars || strlen($password) < 8 || $spaces){
                ?>

                <label class="error-msg1">.كلمة المرور يجب أن تكون  8 خانات فأكثر بدون مسافات وتحتوي على حروف إنجليزية، على الأقل : 1 رمز، 1 عدد  </label>

                <?php  
                    }
                    else{

                        //تخزين متغيرات الجلسة لاستخدامها باستعلام الصفحة التالية
                        $_SESSION['Fname']= $_POST['Fname'];
                        $_SESSION['Lname']=$_POST['Lname'];
                        $_SESSION['email']=$_POST['email'];
                        $_SESSION['pass']=$password;
                        $_SESSION['userType'] = 'NormalUser';
                        $_SESSION['user_status']='فعال';
                        $_SESSION['points']='0';
                        

                        //إرسال كود التحقق إلى البريد المدخل
                        $_SESSION['authcode'] = mt_rand(161584,932587);
                        $to = $_SESSION['email'];
                        $subject = "تأكيد البريد الإلكتروني";
                        $message = "كود التحقق  : ".$_SESSION['authcode'];         
                        $from = "teamfazaa@gmail.com";
                        $headers = 'From: teamfazaa@gmail.com';
                        mail($to,$subject,$message,$headers);
                        header("location:emailAuth.php");
                        }
                      }
                    }
                  } 
                }

                //إغلاق الاتصال
                mysqli_close($conn);
                ?>
                
            </form>
        </div>
    </div>
   

    
</body>
</html>