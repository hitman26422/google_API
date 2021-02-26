<?php
if(isset($_POST['submit']))
{
	require_once 'sql.php';
	$name=$_POST['fname'];
		$username=$_POST['uname'];
		$password=$_POST['psw'];
		$email=$_POST['email'];
		$mobile=$_POST['mobile'];
  $result=mysqli_query($con,"INSERT INTO login(`full_name`, `username`, `password`, `email`, `mobile`) VALUES ('$name','$username','$password','$email','$mobile')");
							if($result) 
			{		
		mkdir('Audio/'.$username.''); 
		mkdir('profilepic/'.$username.''); 
		copy('profilepic/default.jpg', 'profilepic/'.$username.'/'.$username.'.jpg');
		require_once 'sql.php';
$result1=mysqli_query($con,"insert into notification  VALUES('$username','NULL','Created  Account on',NOW(),0)");
	$result2=mysqli_query($con,"insert into notification  VALUES('$username','NULL','Verify Your Mobile',NOW(),0)");
	header("Location: home.php?success=1");	
			}
			else
			{
			header("Location: home.php?error=1");
			}
}
	?>