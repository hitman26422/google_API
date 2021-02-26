<?php	
	function sendOTP($no,$otp) {
// Fetching data that is entered by the user
$username = "naveenusharma@gmail.com";
	$hash = "9c2347b6425dc2362a9fab7b93da4ffde5572fd3f0f68ea30d171cf63ce8dc90";	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.
	$numbers= "91".$no; // A single number or a comma-seperated list of numbers
	$message = "Verify your mobile OTP: ".$otp;
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result_co=curl_exec($ch);
	$character=json_decode($result_co);
	$result=0;
	if($character->status=="success")
	{
	$result=1; // This is the result from the API
	}
	curl_close($ch);
			return $result;
	}
?>