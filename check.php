<?php

if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];
require_once 'sql.php';
 $checkdata=" SELECT username FROM login WHERE username='$name' ";

 $query=mysqli_query($con,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "User Name Already Exist"."<br>";
 }
 else
 {
  echo "OK"."<br>";
 }
 exit();
}

if(isset($_POST['pho_no']))
{
 $mob=$_POST['pho_no'];
require_once 'sql.php';
 $checkdata=" SELECT mobile FROM login WHERE mobile='$mob' ";

 $query=mysqli_query($con,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "Mobile Already Exist";
 }
 else
 {
  echo "OK";
 }
 exit();
}



if(isset($_POST['e_name']))
{
 $emailId=$_POST['e_name'];
require_once 'sql.php';

 $checkdata=" SELECT email FROM login WHERE email='$emailId' ";

 $query=mysqli_query($con,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "Email Already Exist";
 }
 else
 {
  echo "OK";
 }
 exit();
}
?>