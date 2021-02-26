<?php
	require_once 'sql.php';
$result=mysqli_query($con,"select location from File_Output where created_by='m'");
   while($row = mysqli_fetch_assoc($result))
  {
    $file_loc=$row["location"];
  }
    mysqli_close($con);
	$file=$file_loc;
    $basename = basename($file);
    $length   = sprintf("%u", filesize($file));

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment;filename="'.basename($file).'"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $length);
	ob_clean();
    flush();
    set_time_limit(0);
    readfile($file);
	
	?>