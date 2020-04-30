<?php
session_start();

if( isset($_SESSION['user_ID']) && $_SESSION['user_ID']!=null )
$id = $_SESSION['user_ID'];

if($id==null){
  header("location:home.php");
 }


//تضمين ملف الاتصال بالقاعدة
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
        <title>تسجيل الخروج</title>
        
 </head>
 <body>

                <img src="../images/logo1.png" class="logo">
     
                    <?php
                      date_default_timezone_set('Asia/Riyadh');
                      if($_GET['date']=='0')
                      $date = date('Y:m:d');
                      else if($_GET['date']=='0.1')
                      $date = date('Y:m:d',time()- 1*24*60*60);
                      else if($_GET['date']=='1')
                      $date = date('Y:m:d',time()- 1*7*24*60*60);
                      else if($_GET['date']=='2')
                      $date= date('Y:m:d',time()- 2*7*24*60*60 );
                      else if($_GET['date']=='3')
                      $date= date('Y:m:d',time() - 3*7*24*60*60) ;
                      else
                      $date= date('Y:m:d',time() - 4*7*24*60*60) ;
                        
                      if(($_GET['date']=='0') || ($_GET['date']=='0.1')){
                      $queryMissing = mysqli_query($conn,"SELECT * FROM missings WHERE `type`='$_GET[type]' AND `found_date`='$date' AND `status`='لم يتم الاستلام' ");
                      }
                      else if($_GET['date']=='all'){
                         $queryMissing = mysqli_query($conn,"SELECT * FROM missings WHERE `type`='$_GET[type]' AND `status`='لم يتم الاستلام' "); 
                      }
                        else{
                            $queryMissing = mysqli_query($conn,"SELECT * FROM missings WHERE `type`='$_GET[type]' AND `found_date`>='$date' AND `status`='لم يتم الاستلام' ");
                        }
                     
                      $numMissing=mysqli_num_rows($queryMissing);

                    if($numMissing == 0){
            ?>
            <p class="note">لا يوجد مفقود مطابق.</p>
            <?php
                   }
                   else{
           ?>
                   <br><br><br><br><br>
                   <div class="note"> يمكن أن تجده في :
                   <?php
                       
                       $branchA=0;
                       $branchB=0;
                       $branchC=0;
                       
                    while(($resultMissing=mysqli_fetch_assoc($queryMissing)) &&( ($branchA==0) ||($branchB==0) || ($branchC==0) ) ){
                        
                       if(($resultMissing['branch']=='أمن البوابة الشرقية') && ( $branchA==0)){
                         $branchA=1;
                         echo $resultMissing['branch']." - ";
                       }
                        
                        else if(( ($resultMissing['branch']=='أمن البوابة الشمالية') && ($branchB==0))
                                
                            ){
                         $branchB=1; 
                         echo $resultMissing['branch']." - ";

                       }
                        else if(  ( ($resultMissing['branch']=='أمن كلية الصيدلة') && ($branchC==0) )){
                         $branchC=1; 
                         echo $resultMissing['branch']." - ";
                        }
                        else{
                        echo".";
                       }
            
          
                   }
                          ?>
                          </div>
     <?php
                          }
                   
                          
                   ?>

                
               
</body>
</html>