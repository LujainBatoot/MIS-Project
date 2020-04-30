<?php
session_start();

if( (isset($_SESSION['user_ID'])) && ($_SESSION['user_ID']!=null) )
$id = $_SESSION['user_ID'];

if($id==null){
  header("location:home.php");
}
?>

<html>
 <head>
        <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
        <title>تعديل عضوية</title>
        
 </head>
 <body>
                <?php
                include('config.php');
                error_reporting(0);

                $userEmail=$_GET["ID"];
                $userID=$_GET["ID"];
                $result=mysqli_query($conn,"SELECT * FROM users WHERE email= '$userEmail' OR user_ID ='$userID' ");
                $num=mysqli_num_rows($result);
                ?>

                <img src="../images/logo1.png" class="logo">
                 <br>
                 <center class="center-left7">
                  <?php
                  if($num == 0){
                  ?>
                  <p>لا يوجد عضوية مطابقة </p>
    

                  <?php
                    }
                    else{
                      $row=mysqli_fetch_array($result);
                  ?>
                  
            <table> 
                <tr class="header4"> 
                    <th>حالة العضوية</th>
                    <th>نوع المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>كلمة المرور</th>
                    <th>الاسم الأخير</th>
                    <th>الاسم الأول</th>
                    <th>رقم العضوية</th>
                    </tr> 
            </table> 
            <div class="b7">
            <form action="" method="POST">
            <table class = "gfg">
                <tr class="rows"> 
                    <td>                   
                        <select id="status" class="browse-dropList" name="status">
                            <option value=""></option>
                            <option value="فعال">مفعلة</option>
                            <option value="معطل">معطلة</option>
                        </select>
                    </td>
                    <td>                   
                        <select id="userType" class="browse-dropList" name="userType" > 
                            <option value=""></option>
                            <option value="NormalUser">مستخدم</option>
                            <option value="Publisher">مسؤول فعاليات</option>
                            <option value="Employee">موظف أمن</option>
                        </select>
                    </td>
                    <td><input type ="text" name="email" placeholder="<?php echo $row['email']; ?>"/> </td>
                    <td><input type="password" name="pass" placeholder=""/> </td>
                    <td><input type="text"  name="Lname" placeholder="<?php echo $row['last_name'];?>"/> </td>
                    <td class="geeks" ><input type="text" name="Fname" placeholder="<?php echo $row['first_name'];?>"/></td>
                    <td name="userID" class = "geeks"><label><?php echo $row['user_ID'];?></label></td>
                </tr> 
            </table>
                <br>
                   <button type="submit" class="update-btn" name="update-btn">تحديث</button>

            <?php
                        if( (isset($_POST['update-btn'])) ){

                          if(!empty($_POST['Fname'])){
                          mysqli_query($conn, "UPDATE `users` SET `first_name`='$_POST[Fname]' WHERE `user_ID`= '$row[user_ID]' ");
                          }
                          if(!empty($_POST['Lname'])){
                          $update2 = " UPDATE  `users` SET `last_name`='$_POST[Lname]'  WHERE `user_ID`='$row[user_ID]' "; 
                          mysqli_query($conn, $update2);
                          }
                          if(!empty($_POST['email'])){
                          $update3 = " UPDATE  `users` SET `email`='$_POST[email]'  WHERE `user_ID`='$row[user_ID]' ";
                          mysqli_query($conn, $update3); 
                          }
                          if(!empty($_POST['pass'])){
                          $update4 = " UPDATE  `users` SET `passwords`='$_POST[pass]'   WHERE `user_ID`='$row[user_ID]' ";
                          mysqli_query($conn, $update4); 
                          }
                          if(!empty($_POST['userType'])){
                          $update5 = " UPDATE  `users` SET `user_type`='$_POST[userType]' WHERE `user_ID`='$row[user_ID]' ";
                          mysqli_query($conn, $update5);
                          }
                          if(!empty($_POST['status'])){
                          $update6 = " UPDATE  `users` SET `user_status`='$_POST[status]'  WHERE `user_ID`='$row[user_ID]' ";
                          if($_POST['status']=='معطل'){
                            $updateFazaa = " UPDATE  `fazaa` SET `status`='ملغي'  WHERE `in_need_ID`='$row[user_ID]' ";
                            $delevent = " DELETE FROM `events` WHERE `publisher_ID`='$row[user_ID]' ";
                            mysqli_query($conn,$delevent );
                            mysqli_query($conn,$updateFazaa);
                          }
                          mysqli_query($conn, $update6); 
                          }     
                          ?>   
                                  </form>
                                </div>
                          <?php
                          if(!empty($_POST['Fname']) || !empty($_POST['Lname']) || !empty($_POST['pass']) || !empty($_POST['email']) || !empty($_POST['userType']) || !empty($_POST['status'])){
                          ?>
         
              <div class=""><label>تم تحديث البيانات بنجاح</label></div>
              <?php
                          }
              }
            } 
            ?>  

              
     </center>

        <br>
    
</body>
</html>