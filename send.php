<?php
require 'PHPMailer_5.2.4/class.phpmailer.php';
if(isset($_POST['email']))
{
	$token=uniqid(rand(),true) ;
$email = "Polymeet2019@gmail.com";
$password ="POLYmeet2k19";
$to_id =$_POST['email'];
$message = "Reset your speech to text password:use-http://localhost/google/passwordchange.php?token=".$token;
$subject = "Reset password";
require_once 'sql.php';
 $result=mysqli_query($con,"UPDATE login SET `token`='$token',created_token=NOW() WHERE email='$to_id'");
 mysqli_close($con);
// Configuring SMTP server settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $email;
$mail->Password = $password;
$mail->FromName = "Reset Password";;
// Email Sending Details
$mail->addAddress($to_id);
$mail->Subject = $subject;
$mail->msgHTML($message,$email);

 // Success or Failure
if (!$mail->send())
{
echo "failure";
}
else
{
echo "success";
}
}
?>