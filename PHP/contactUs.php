<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تواصل معنا</title>
        
 </head>
 <body>
     <a href="home.php"><img src="../images/logo1.png" class="logo" ></a>
        <div class="contain-bg">
            <div class="contain">
                <form method ="POST">
                    <h1>تواصل معنا</h1>
                    <br>
                    <p> الاسم   <br>
                        <input type="text" class="con-data" name="name">
                    </p>
                    <p> البريد الإلكتروني   <br>
                        <input class="con-data" type="text" name="email">
                    </p>
                    <p> الرسالة    <br>
                        <textarea rows="7" cols="50" class="con-data" name="message"></textarea>
                    </p>
                    <button type="submit" class="contact-btn" name="send-btn">إرسال</button>
                    
        <?php

                //إذا تم النقر على زر الإرسال-1
                 if (isset($_POST['send-btn'])){ 
                 error_reporting(0);
                 $to = "teamfazaa@gmail.com";
                 $subject = " من ".$_POST['email'];
                 $message = "
                 <html>
                 <body>
                 <div dir='rtl'>
                 <p> من:".$_POST['name']." </p>
                 <p>".$_POST['message']."</p>
                 </div>
                 </body>
                 </html>";
                 $from = "teamfazaa@gmail.com";
                 $headers = "From: teamfazaa@gmail.com";
                 $headers.= "MIME-Version: 1.0" . "\r\n";
                 $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
                 $done = mail($to,$subject,$message,$headers);
                //اذا نجحت عملبة الإرسال-2
                if( $done == true ) {
          ?>

                  <label class="label-d" ><br>   .تم إرسال الرسالة بنجاح </label>

          <?php
                    }
                    else {
           ?>

                  <label class="error-msg2" ><br>.عذرًا توجد مشكلة، حاول لاحقَا</label>

           <?php
                    }
                  }

          ?>   
                    
                    
                </form>
            </div>
        </div>
   
</body>
</html>