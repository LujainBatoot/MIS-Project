<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تسجيل الخروج</title>
        
 </head>
 <body>
                <?php
                session_start();
                unset($_SESSION["user_ID"]); 
                error_reporting(0);

                ?>

                <img src="../images/logo1.png" class="logo">
                <div class="changePass-bg">
                <div class="changePass-img">
                <br>
                <h2 class="header2"></h2>
                <br>
                <h1 class="paragraph2" style="text-align: 'center'; margin-left:280px; font-size:20px;">تم تسجيل الخروج</h1>
                  <br>
                  <h1 class="paragraph2" style="text-align: 'center'; margin-left:210px; font-size:20px;"> نتمنى أن نراك في فزعات قادمة !</h1>

                <br><br><br><br><br><br><br><br><br><br><br><br><br>
                <a href="home.php"><button type="submit" class="submit-btn" name="send-btn">الرئيسية</button></a>
                <br><br>   
            </div>
            </div>
</body>
</html>