<?php
include('session.php');
if(isset($_POST['textto']))
{
	$file_name1=$_FILES["file"]["name"];
$finalname=(explode(".", $file_name1));
$ext = end($finalname);
move_uploaded_file($_FILES["file"]["tmp_name"],"output/{$login_session}.{$ext}");
	header("Location: index.php?stot={$ext}#t-to-speech");
}
?>