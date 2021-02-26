<?php
	if(isset($_POST['mobile_no']))
	{
		$mobile=$_POST['mobile_no'];
	$otp=rand(100000,999999); 
	require_once("Checkotp.php");
		$mail_status = sendOTP($mobile,$otp);
		if($mail_status == 1) 
		{
		echo "true";
	require_once'sql.php';	
			$result = mysqli_query($con,"INSERT INTO otp_expiry(otp,is_expired,created_at) VALUES ('" . $otp . "', 0, NOW())");
			$current_id = mysqli_insert_id($con);
			if(!empty($current_id)) 
			{
			 echo 1;
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo 0;
		}
	}
	?>	