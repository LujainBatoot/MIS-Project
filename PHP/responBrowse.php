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
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/css.css" media="screen">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
	<title>مسؤول الفعاليات</title>
	<meta charset="utf-8">
        <script>
        function myAlert(){
            alert("تم إضافة الفعالية");
            location.reload();
        }

        function myAlert1(){
            alert("تم إرسال الفزعة ");
            location.reload();
        }
            
        function myAlert2(){
            alert("تم إلغاء الطلب ");
            location.reload();
        }
            
        function myAlert3(){
            alert("تم حذف الفعالية ");
            location.reload();
        }
    </script>
</head>
<body>
    <a href="home.php"><img src="../images/logo1.png" class="logo" ></a>
	<div class="tab">
		<button class="tablinks" onclick="openCity(event, 'event')" ><i class="far fa-window-maximize icon"></i><br>ماذا يحدث الآن</button>
		<button class="tablinks" onclick="openCity(event, 'response')" id="defaultOpen"><i class="fas fa-hand-holding-heart icon"></i><br>طلبات تحتاج فزعتك</button>
    <button class="tablinks" onclick="openCity(event, 'add-event')"><i class="fas fa-file-upload icon"></i><br>إضافة فعالية</button>
		<button class="tablinks" onclick="openCity(event, 'request')"><i class="fas fa-hands-helping icon"></i><br>طلب فزعة</button>
    <button class="tablinks" onclick="openCity(event, 'missing')"><i class="fas fa-search icon"></i><br>استعلام مفقود</button>
    <button class="tablinks" onclick="openCity(event, 'pre-req')"><i class="fas fa-angle-left icon"></i><br>طلباتي السابقة</button>
    <button class="tablinks" onclick="openCity(event, 'pre-res')"><i class="fas fa-angle-double-left icon"></i><br>فزعاتي السابقة</button>
    <button class="tablinks" onclick="openCity(event, 'pre-evt')"><i class="far fa-calendar-alt icon"></i><br>فعالياتي السابقة</button>
    <button class="tablinks" onclick="openCity(event, 'setting')"><i class="fas fa-cog icon"></i><br>الاعدادات</button>
	</div>

	<!------ استعراض الدورات والفعاليات ------>

  <?php
    $queryevent = mysqli_query($conn,"SELECT * FROM `events` ORDER BY event_ID DESC");
    $numevent=mysqli_num_rows($queryevent);
    if($numevent == 0){
  ?>
  <p class="no">لا يوجد فعاليات أو دورات حاليًا</p>

 <?php
  }
  else{
  ?>
	<div id="event" class="tabcontent">
    <?php
    while ($event = mysqli_fetch_assoc($queryevent)){
    ?>
        <div class="box6">
                          <?php
            
           echo"<img class='images' src='".$event['image']."' alt=''>";
                ?>
            <h3><?php echo $event['title']; ?></h3>
            <p><?php echo $event['details']; ?></p>
        </div>
 <?php
    }
  }
 ?>
    </div>


<!------ استعراض طلبات الفزعة ------>
<div id="response" class="tabcontent">
        <center class="center-left0">
            <?php   
                    date_default_timezone_set('Asia/Riyadh');
                    $date = date('Y:m:d');
                    $last6hour = time() - 6*60*60 ;
                    $time = date('h:i:s', $last6hour);
                    $query = mysqli_query($conn,"SELECT * FROM fazaa WHERE `status`='ينتظر فزعتك' AND `date`='$date' AND `date`>='$time' ORDER BY fazaa_ID DESC");
                    $num=mysqli_num_rows($query);
                    if($num == 0){
            ?>
            <p class="no">لا يوجد طلبات فزعة حاليًا</p>
            <?php
                   }
                   else{
            ?>
            <table> 
                <tr> 
                    <th>الاسم</th>
                    <th>رقم الطلب</th>
                    <th>الغرض</th>
                    <th>نوع الغرض</th>
                    <th>المبنى</th>
                    <th>المدة</th> 
                    <th>حالة الطلب</th>
                    </tr> 
            </table> 

            <?php
                   while($result=mysqli_fetch_assoc($query)){
                   $namequery=mysqli_query($conn,"SELECT * FROM users WHERE user_ID = '$result[in_need_ID]'");
                   $name=mysqli_fetch_array($namequery);
                   $isDisabled=false;
                   if($id==$result['in_need_ID']){
                      $isDisabled = true;
                }
            ?>
            <div class="b">
            <table class = "gfg">
                <tr> 
                    <td class = "geeks"><?php echo $name['first_name']." ".$name['last_name'];?></td>
                    <td class = "geeks"><?php echo $result['fazaa_ID'];?></td>
              
                    <td><?php echo $result['title'];?></td>
                    <td><?php echo $result['type'];?></td>
                    <td><?php echo $result['building'];?></td>
                    <td><?php echo $result['period'];?></td>
                    <td>
                      <?php echo "<a href ='help.php?fazaaID=".$result['fazaa_ID']."&status=".$result['status']."&inNeedID=".$result['in_need_ID']." '>";?>
                    <button type ="submit" class="btn" name="give-btn" <?php if($isDisabled==true){?> disabled <?php } ?> >تلبية الطلب
                    </button>
                    <?php echo "</a>"; ?>
                    </td>
                </tr> 
            </table> 
            </div>
            <?php
                    }
                   }
                  
            ?>
        </center>
    </div>

    <!------ اضافة فعالية  ------>
    <div id="add-event" class="tabcontent">
            <div class="center" id="height">
                <form class="form-up" action="" method="POST" enctype="multipart/form-data">
                    <h1>إضافة فعالية</h1>
                    <p> اسم الفعالية   <br>
                        <input class="dropList" name="title" required>
                    </p>
                    </p>
                    <p> تفاصيل الفعالية    <br>
                        <textarea rows="8" cols="50" id="width" name="details" required></textarea>
                    </p>
                    <p><input type="file"  name="file" id="file"  onchange="loadFile(event)" style="display: none;" required></p>
                    <p><label for="file" style="cursor: pointer;">رفع صورة</label></p>
                    <br>
                    <button type="submit" class="add-btn" name="upload" onclick="myAlert()">إرسال</button>
                    
                    <?php
                      
                      date_default_timezone_set('Asia/Riyadh');
                      if(isset($_POST['upload'])){
                      $fileName = $_FILES['file']['name'];
                      $fileTmpName = $_FILES['file']['tmp_name'];
                      $fileSize = $_FILES['file']['size'];
                      $fileError = $_FILES['file']['error'];
                      $fileType = $_FILES['file']['type'];

                      $fileExt = explode('.',$fileName);
                      $fileActualExt = strtolower(end($fileExt));
                      $allowed = array('jpg','jpeg','png');
                      
                      if((in_array( $fileActualExt, $allowed)) || (empty($_POST['file'])) ){
                        if(($fileError===0) || (empty($_POST['file']))){
                          if($fileSize <100000000){
                          $title=$_POST['title'];
                          $details=$_POST['details'];
                          $fileNameNew = uniqid().date("Y-m-d-H-i-s").$fileName;
                          $fileDestination = $fileNameNew;
                          move_uploaded_file($fileTmpName,$fileDestination);
                          $sqlEvent =" INSERT INTO events (`event_ID`, `title`, `image`, `details`, `publisher_ID`) 
                                      VALUES (NULL,'$_POST[title]','$fileNameNew','$_POST[details]','$id') " ;
                          mysqli_query($conn,$sqlEvent);
 
                          }else
                          echo'';
                          }
                          else{
                            echo'حدث خطأ، حاول مجددًا';
                          }
                          
                        }
                      
                        else{
                          echo'jpg / jpeg / png يجب أن يكون نوع الملف ';
                          }
                    }
                      ?>
                </form>
            </div>
    </div>
</center>

	<!------ طلب الفزعة ------>
	<div id="request" class="tabcontent">
            <div class="center">
                <form acion="" method="POST">
                    <h1>طلب فزعة</h1>
                    <p> المبنى   <br>
                        <select class="dropList" name="building" required>
                        <option value="مبنى المكتبة">مبنى المكتبة</option>
                        <option value="مبنى التلفزيون">مبنى التلفزيون</option>
                        <option value="مبنى إدارة الأعمال">مبنى إدارة الأعمال</option>
                        </select>
                    </p>
                    <p> تصنيف الغرض   <br>
                        <select class="dropList" name="type" required>
                        <option value="أدوات قرطاسية">أدوات قرطاسية</option>
                        <option value="وصلة بروجكتر">وصلة بروجكتر</option>
                        <option value="ملف شفاف">ملف شفاف</option>
                        <option value="A4 ورقة">A4 ورقة</option>
                        <option value="شاحن">شاحن</option>
                        </select>
                    </p>
                    <p> مدة الاستعارة   <br>
                        <select class="dropList"  name="period" required>
                        <option value="نص ساعة">نص ساعة</option>
                        <option value="ساعة">ساعة</option>
                        <option value="ساعة ونص">ساعة ونص</option>
                        <option value="ساعتين">ساعتين</option>
                        <option value="ساعتين ونص">ساعتين ونص</option>
                        <option value="3 ساعات">3 ساعات</option>
                        </select>
                    </p>
                    <p> الغرض    <br>
                        <textarea rows="4" cols="50" name="title" required></textarea>
                    </p>
                    <button type="submit" class="req-btn" name="req-btn" onclick="myAlert1()">إرسال</button>
                    <br>
                    <?php

                        //اذا تم النقر على زر الإرسال
                        if ( (isset($_POST['req-btn']))){ 
                            date_default_timezone_set('Asia/Riyadh');
                            $building =$_POST["building"];
                            $type=$_POST["type"];
                            $period=$_POST["period"];
                            $date = date("Y-m-d");
                            $time = date("h:i:s");
                            $status = "ينتظر فزعتك";
                            $title = $_POST['title'];
                            $inNeedId = $id;

                            //استعلام إضافة الطلب للقاعدة                                      
                            //دالة تنفيذ أمر الاستعلام
                            mysqli_query($conn, "INSERT INTO `fazaa`(`fazaa_ID`,`title`,`type`, `building`, `period`, `date`, `time`, `status`, `in_need_ID`, `details`, `Collaborator_ID`)
                            VALUES (NULL, '$title', '$type', '$building', '$period', '$date', '$time', '$status', '$inNeedId',NULL,NULL)" );
                            }
                     ?>
                 </form>
             </div>
         </div>
    
     <div id="missing" class="tabcontent">
        <div class="center-bg">
                <form action="missingResult.php" method="GET">
                    <h1>استعلام مفقود</h1>
                    <p> إختر تصنيف الغرض المفقود   <br>
                        <select class="dropList" name="type" required>
                        <option value="بطاقات">بطاقات</option>
                        <option value="مجوهرات">مجوهرات</option>
                        <option value="سماعات">سماعات</option>
                        </select>
                    </p>
                    <p> إختر الفترة التي  فقدت فيها الغرض  <br>
                        <select class="dropList" name="date" required>
                        <option value="0"> اليوم</option>
                        <option value="0.1"> أمس</option>
                        <option value="1">قبل أسبوع</option>
                        <option value="2">قبل أسبوعين</option>
                        <option value="3">قبل 3 أسابيع</option>
                        <option value="4">قبل 4 أسابيع</option>
                        <option value="all">جميع الأوقات</option>
                        </select>
                    </p>
                    <button type="submit" name="search-btn" class="search-btn1">بحث</button>
        </form>
      </div>
    </div>
    
    <!------ طلباتي ------>
    <div id="pre-req" class="tabcontent">
        <center class="center-left">
          <?php
          $query = mysqli_query($conn,"SELECT * FROM fazaa WHERE `in_need_ID`='$id'");
          $num=mysqli_num_rows($query);
                    if($num == 0){
            ?>
            <p class="no">ليس لديك طلبات فزعة</p>
            <?php
                   }
                   else{
            ?>
            <table> 
                <tr> 
                    <th>الاسم</th>
                    <th>رقم الطلب</th>
                    <th>الغرض</th>
                    <th>نوع الغرض</th>
                    <th>المبنى</th>
                    <th>المدة</th> 
                    <th></th>
                    </tr> 
            </table> 
            <?php
                   while($result=mysqli_fetch_assoc($query)){
                   $namequery=mysqli_query($conn,"SELECT * FROM users WHERE user_ID = '$id'");
                   $name=mysqli_fetch_array($namequery);
                   $isDisabled=false;
                   if($result['status']!='ينتظر فزعتك'){
                      $isDisabled = true;
                }
            ?>
    <div class="b">
        <table class = "gfg">
          <form action ="" method="POST">
            <tr> 
            <td class = "geeks"><?php echo $name['first_name']." ".$name['last_name'];?></td>
            <td class = "geeks"><?php echo $result['fazaa_ID'];?></td>
            <td></td>
            <td><?php echo $result['type'];?></td>
            <td><?php echo $result['building'];?></td>
            <td><?php echo $result['period'];?></td>
              <?php if($result['status']=='ينتظر فزعتك'){?>

              <td>
              <button type="submit" class="cancel-btn"<?php if($isDisabled == true){?> disabled <?php } ?> value="<?php echo $result['fazaa_ID'];?>" name="cancel-btn" onclick="myAlert2()">إلغاء الطلب</button>
              </td>
              <?php 
              }else if($result['status']=='تم تلبية الطلب'){?>
               <td class = "geeks">تمت الفزعة</td>
              <?php
                }else{
                  ?>
               <td class = "geeks">ملغي</td> 
              <?php
                }
               ?>
            </tr>  
               </form>
        </table> 
        </div>
        <?php    
                     }
                    }
                   if(isset($_POST['cancel-btn'])){
                     $cancelID=$_POST['cancel-btn'];
                     mysqli_query($conn,"UPDATE fazaa SET `status`='ملغي' WHERE `fazaa_ID`='$cancelID'");
                    }
                 ?>
    
        </center>
    </div>
    
  <!------ فزعاتي ------>
  <div id="pre-res" class="tabcontent">
        <center class="center-left1">
        <?php
          $query1 = mysqli_query($conn,"SELECT * FROM fazaa WHERE `Collaborator_ID`='$id'");
          $num=mysqli_num_rows($query1);
                    if($num == 0){
            ?>
            <p class="no">ليس لديك فزعات سابقة</p>
            <?php
                   }
                   else{
            ?>
            <table> 
                <tr> 
                    <th class="th">صاحب الطلب</th>
                    <th  class="th">رقم العضو</th>
                    <th class="th">الغرض</th>
                    <th class="th">نوع الغرض</th>
                    <th class="th">المبنى</th>
                    <th class="th">المدة</th> 
                    </tr> 
            </table> 
            <?php
                   while( $result10 = mysqli_fetch_assoc($query1) ){
                   $namequery=mysqli_query($conn,"SELECT * FROM users WHERE 
                   user_ID = '$result10[in_need_ID]' ");
                   $name=mysqli_fetch_array($namequery);
            ?>
        <div class="b1">
            <table class = "gfg">
            <tr> 
            <td class = "geeks"><?php echo $name['first_name']." ".$name['last_name']; ?></td>
            <td class = "geeks"><?php echo $result10['in_need_ID']; ?></td>
             <td><?php echo $result10['title'];?></td>
            <td><?php echo $result10['type'];?></td>
            <td><?php echo $result10['building'];?></td>
            <td><?php echo $result10['period'];?></td>
              </tr> 
            </table> 
            </div>
        <?php    
             }
            } 
        ?>
        </center>
    </div>

    
    <!--- فعالياتي --->
    
    <?php

          $queryEvent = mysqli_query($conn,"SELECT * FROM `events` WHERE `publisher_ID`='$id' ORDER BY event_ID DESC");
 
          $num=mysqli_num_rows($queryEvent);
          if($num == 0){
            ?>

            <!-- <p class="no">لم تقم بإضافة فعالية </p> -->

            <?php
                   }
                   else{?>
                   <div id="pre-evt" class="tabcontent">
                   <?php
                   while($resultEvent=mysqli_fetch_assoc($queryEvent)){
            ?>
    <div class="box6">
          <form action="" method="POST">
              <?php
            
           echo"<img class='images1' src='".$resultEvent['image']."' alt=''>";
                ?>
            <h3><?php echo $resultEvent['title']; ?></h3>
            <p><?php echo $resultEvent['details']; ?></p>
            <button type= "submit" class="del-btn" name="del-btn" onclick="myAlert3()" value="<?php echo $resultEvent['event_ID'];?>">حذف</button> 
          </form>
    </div>
        <?php
                  }
                }
                if(isset($_POST['del-btn'])){
                  $delID=$_POST['del-btn'];
                  mysqli_query($conn,"DELETE FROM events WHERE `event_ID`='$delID'");
                }
        ?>
    </div>

    <div id="setting" class="tabcontent">
        <div class="up">
        <?php
           $queryPoint=mysqli_query($conn,"SELECT * FROM users WHERE user_ID='$id'");
           $resultPoint= mysqli_fetch_array($queryPoint);
          ?>
        <div class="score"><label><i class="fas fa-star pass-icon"></i> نقاطك هي : <?php echo $resultPoint['points']; ?> نقاط</label></div>
        <button onclick=" window.open('../php/resetPass.php','_blank')" type="button" class="setting-btn"><i class="fas fa-lock pass-icon"></i>تغيير كلمة المرور</button>
        <button onclick=" window.open('../php/contactUs.php','_blank')" type="button" class="setting-btn"><i class="fas fa-envelope pass-icon"></i>تواصل معنا</button>
        <button onclick=" window.open('../php/logout.php','_blank')" type="button" class="setting-btn"><i class="fas fa-sign-out-alt pass-icon"></i>تسجيل الخروج</button>

        </div>
    </div>
    

	<script>
		function openCity(evt, tabName) {
		    var i, tabcontent, tablinks;
		    tabcontent = document.getElementsByClassName("tabcontent");
		    for (i = 0; i < tabcontent.length; i++) {
		        tabcontent[i].style.display = "none";
		    }
		    tablinks = document.getElementsByClassName("tablinks");
		    for (i = 0; i < tablinks.length; i++) {
		        tablinks[i].className = tablinks[i].className.replace(" active", "");
		    }
		    document.getElementById(tabName).style.display = "block";
		    evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>

</body>
</html>

