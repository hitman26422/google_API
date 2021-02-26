<?php
require 'PHPMailer_5.2.4/class.phpmailer.php';
if(isset($_POST['send-send']))
{
$name=$_POST['names'];
$no=$_POST['ms'];
$sub=$_POST['subject'];
$email = "Polymeet2019@gmail.com";
$password ="POLYmeet2k19";
$to_id ="naveenusharma@gmail.com";
$message = "Name:".$name."<br>"."Mobile:".$no."<br>".$sub;
$subject = "Forums-FAQ";
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $email;
$mail->Password = $password;
$mail->FromName = "SPEECH TO TEXT";;
// Email Sending Details
$mail->addAddress($to_id);
$mail->Subject = $subject;
$mail->msgHTML($message,$email);

 // Success or Failure
if (!$mail->send())
{
header("Location: home.php?send-error=1");
}
else
{
header("Location: home.php?send-sucess=1");
}

	
}
else
{
}
?>