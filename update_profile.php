<?php
include('session.php');
/* Getting file name */

/* Location */
$location = "profilepic/".$login_session."/".$login_session.".jpg";
echo $location;
$uploadOk = 1;
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location))
   {
	   echo "true";
   }
   else{
      echo 0;
   }
?>