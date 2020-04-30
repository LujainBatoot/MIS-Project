<html>
  <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تسجيل الدخول</title>
        
  </head>
  <body>

    <img src="../images/logo1.png" class='logo2'>
    <div class="right-box1">
    <form action="" method="POST">
      <h1>تسجيل الدخول</h1>
      <input type="text" name="email" class="input1-box" placeholder="البريد الإلكتروني">
      <input type="password" name="pass" class="input1-box" placeholder="كلمة المرور">
                    
      <br>
      <button type="submit" name="login-btn" class="login-btn">تسجيل الدخول</button>
      <br>
      <a href="recoverPass.php">نسيت كلمة المرور</a>
      <br><br>

      <?php 
        
        session_start();
        
        //تضمين ملف الاتصال بالقاعدة
        include('config.php');
        error_reporting(0);


        if(isset($_POST['login-btn'])){ 

        //التحقق من تطابق البيانات المدخلة
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email ='$_POST[email]' AND passwords='$_POST[pass]' ");
        if(mysqli_num_rows($query) == 0){
            $_SESSION['email']=$_POST[email];
      ?>
            
      <div class="error-msg"><label> خطأ في اسم المستخدم/كلمة المرور، أو سجل كعضو جديد</label></div> 
                   
      <?php   
       }
        else{
         $result=mysqli_fetch_array($query);
         if ($result['user_status'] == 'معطل'){
      ?>

      <div class="error-msg"><label> تم إلغاء عضويتك بسبب عدم التزامك بسياسة التطبيق </label></div> 
                   
      <?php
        }
          else{

              //التوجيه للصفحة المخصصة حسب نوع المستخدم  
              $_SESSION['user_ID'] = $result['user_ID']; 
              if($result['user_type']=='Admin' )
                header("location:AdminBrowse.php");
              elseif($result['user_type']=='Publisher' )
                header("location:responBrowse.php");
              elseif($result['user_type']=='Employee' )
                header("location:employeeBrowse.php");
              else 
                header("location:userBrowse.php");
            } 
          } 
         }  
      ?>

    </form>
    </div>
        
    <div class="left-box">
       <img src="../images/help1.jpg" alt="" class=login-img>
       <h2>لست مسجل بعد ؟</h2>
       <p>سجل الان واطلب المساعدة واحصل <br>على فرصة لمساعدة غيرك وكسب النقاط </p>
       <a href="signUp.php"><button type="button" class="sign-btn1">التسجيل</button></a>
    </div>
   
  </body>
</html>