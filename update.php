<?php
include('session.php');
function deleteDir($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
     if (!$dir_handle)
          return false;
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                else
                     delete_directory($dirname.'/'.$file);
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
     return true;
}
if(isset($_POST['submit']))
{
	require_once 'sql.php';
		$password=$_POST['psw-1'];
	 $result=mysqli_query($con,"UPDATE login SET `password`='$password' WHERE username='$login_session'");
$result2=mysqli_query($con,"insert into notification  VALUES('$login_session',NULL,'Password Changed',NOW(),0)");
if ($result) 
{
    header("Location: edit_profile.php?success=1");
} 	
else
			{
header("Location: edit_profile.php?error=1");
			}
}
if(isset($_POST['udad']))
{
	require_once 'sql.php';
		$name=$_POST['username'];
$result1=mysqli_query($con,"UPDATE event SET  created_by='$name' WHERE created_by='$login_session'");	
					
$result2=mysqli_query($con,"insert into notification  VALUES('$name','NULL','Username Changed',NOW(),0)");
 
	 $result3=mysqli_query($con,"UPDATE `notification` SET for_name='$name' WHERE for_name='$login_session'");
   	
	$result=mysqli_query($con,"UPDATE `login` SET `username` = '$name' WHERE `login`.`username` = '$login_session'");
if ($result) 
{
	deleteDir('Audio/'.$login_session.''); 
		deleteDir('profilepic/'.$login_session.''); 
	
	mkdir('Audio/'.$name.''); 
		mkdir('profilepic/'.$name.''); 
		copy('profilepic/default.jpg', 'profilepic/'.$name.'/'.$name.'.jpg');
	?>
	<html>
	<script>
	alert("username changed please login again");
	</script>
	</html>
	<?php
     header( "refresh:1; url=logout.php" ); 
} 	
else
			{
header("Location: edit_profile.php?error=1");
			}
}


	?>