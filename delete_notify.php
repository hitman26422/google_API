<?php
if(isset($_POST['session']))
{
$name=$_POST['session'];
require_once 'sql.php';
$res=mysqli_query($con,"delete from notification where for_name='$name'");
if($res)
{
	echo "success";
}
else
{
	
}
}
?>