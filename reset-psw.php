<?php
if(isset($_POST['recover-submit']))
{
	require_once 'sql.php';
$ticket=$_POST['token'];
	$result=mysqli_query($con,"select token,username from login where token='$ticket' AND NOW() <= DATE_ADD(created_token, INTERVAL 5 MINUTE) ");
	if (mysqli_num_rows($result)==0) 
	{ 
	
		?>
	<h1 align="center">Session Expired</h1>
<?php
	}
	else
	{
 while ($row = $result->fetch_assoc()) {
        $uname = $row['username'];
      }

	$pass=$_POST['Password'];
	$token=$_POST['token'];
	require_once 'sql.php';
	 $result=mysqli_query($con,"UPDATE login SET `password`='$pass',created_token=DATE_SUB(created_token, INTERVAL 5 MINUTE) WHERE token='$token'");
if($result)
{	
$result1=mysqli_query($con,"insert into notification  VALUES('$uname',NULL,'Password  Reseted',NOW(),0)");

	?>
	<h1 align="center">UPDATED SUCCESSFULLY</h1>
<?php
$result=mysqli_query($con,"select email from  login  WHERE token='$token'");

while($row=mysqli_fetch_array($result))//while look to fetch the result and store in a array $row.  
        {  
			$to=$row[0];  
		}
require 'PHPMailer_5.2.4/class.phpmailer.php';
$email = "Polymeet2019@gmail.com";
$password ="POLYmeet2k19";
$to_id =$to;
$message = "Your Password has been reseted <br> if you have not changed please reset the password";
$subject = "Password Reset";
// Configuring SMTP server settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $email;
$mail->Password = $password;
$mail->FromName = "Password -SPEECH TO TEXT";;
// Email Sending Details
$mail->addAddress($to_id);
$mail->Subject = $subject;
$mail->msgHTML($message,$email);

 // Success or Failure
if (!$mail->send())
{
}
else
{

}

header( "refresh:3; url=home.php" ); 
}
else
{
?>
<h1 align="center">Session Expired</h1>
<?php
}
mysqli_close($con);	 
}
}
else
{
?>
<h1 align="center">Session Expired</h1>
<?php
header("location: home.php"); 
}
?>