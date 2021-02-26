<?php
if(isset($_POST['email']))
{
	 $mail=$_POST['email'];
 require_once 'sql.php';
 $checkdata="SELECT email FROM login where email='$mail'";

 $query=mysqli_query($con,$checkdata);

 if(mysqli_num_rows($query)>0)
 {
  echo "ok";
 }
 else
 {
  echo "Email Doesnt exit"."<br>";
 }
 mysqli_close($con);
 exit();
}

?>