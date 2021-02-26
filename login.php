<?php
session_start(); // Starting Session
if(isset($_POST['submit_login']))
{
if (empty($_POST['uname']) || empty($_POST['psw']))
{
header("location: home.php?error-login=1"); 
}
else
{
// Define $username and $password
$username=$_POST['uname'];
$password=$_POST['psw'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
require_once 'sql.php';
// SQL query to fetch information of registerd users and finds user match.
$query = mysqli_query( $con,"select username,password,last_login from login where password='$password' AND username='$username'");
$rows = mysqli_num_rows($query);
while($row=mysqli_fetch_array($query))//while look to fetch the result and store in a array $row.  
        {  
			$last_login=$row[2];  
		}
if ($rows == 1) 
{
$_SESSION['login_user']=$username;
$_SESSION['last_login']=$last_login;
require_once 'sql.php';
	$query = mysqli_query( $con,"update login set last_login=NOW() where username='$username'");
 // Initializing Session
header("location: index.php"); // Redirecting To Other Page
} 
else 
{
header("location: home.php?error-login=1"); // Redirecting To Other Page
}
a:mysqli_close($con); // Closing Connection
}
}
?>