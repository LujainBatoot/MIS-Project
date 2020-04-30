<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fazaa";

$conn = mysqli_connect($servername,$username,$password);
if(!$conn)
  die("Error in connect");

  $select = mysqli_select_db($conn,$dbname);
  if(!$select)
    die("please select the database.");
    
  mysqli_set_charset($conn,"utf8");

?>