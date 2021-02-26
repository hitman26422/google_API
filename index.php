<?php
include('session.php'); // Includes Login Script
require 'vendor/autoload.php';
# Imports the Google Cloud client library
use Google\Cloud\Speech\SpeechClient;
if(isset($_POST['submit']))
{
	if (($_FILES["file"]["type"] == "audio/flac")
					&& ($_FILES["file"]["size"] <50000000000))
						{
							if ($_FILES["file"]["error"] > 0)
							{
									echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
							}
							else
							{
							$language=$_POST["lang"];
							$output_format=$_POST["output"];
								# Your Google Cloud Platform project ID
$projectId = 'hopeful-host-231109';
# Instantiates a client
$speech = new SpeechClient([
    'projectId' => $projectId,
    'languageCode' => $language,
 'keyFile' => json_decode(file_get_contents('elango-211007-55b68546e0a9.json'), true)
]);
	

$file_name1=$_FILES["file"]["name"];
$finalname=(explode(".", $file_name1));
$ext = end($finalname);
move_uploaded_file($_FILES["file"]["tmp_name"],"audio/{$login_session}/name.{$ext}");
# The name of the audio file to transcribe
$fileName = 'audio/name.'.$ext;

# The audio file's encoding and sample rate
$options = [
    'encoding' => 'FLAC',
    //'sampleRateHertz' => 16000,
];

# Detects speech in the audio file
$results = $speech->recognize(fopen($fileName, 'r'), $options);

foreach ($results as $result) 
{
    $transcription=$result->alternatives()[0]['transcript'] . PHP_EOL;
}
									if($output_format=='note')
									{
									$file = fopen("output/notepad/test.txt","w");
									fwrite($file,$transcription);
									fclose($file);
									$file_loc="output/notepad/test.txt";
									header("Refresh:5;url=notepad_download.php?file=".$file_loc);
?>	
	<div class="alert alert-primary">
    <strong>Message!</strong> if file not downloaded,Download file from <a href="notepad_download.php?file=<?php echo $file_loc ?>">here.</a>
	<a href="#" class="close" data-dismiss="alert">&times;</a>

  </div>
 <?php
									}
									else if($output_format=='Word')
									{
									require_once 'word.php';
									getData($transcription);
									?>	
	<div class="alert alert-primary">
    <strong>Message!</strong> if file not downloaded,Download file from <a href="download.php">here.</a>
	<a href="#" class="close" data-dismiss="alert">&times;</a>

  </div>
 <?php
									}
}
						}
else 
		{
			?>
			<div class="alert alert-danger">
    <strong>ERROR!</strong> Please upload a valid flac file.
	<a href="#" class="close" data-dismiss="alert">&times;</a>
  </div>
  <?php
	}
}
if(isset($_POST['submit_1']))
{
	if (($_FILES["file"]["type"] == "audio/flac")
					&& ($_FILES["file"]["size"] <50000000000))
						{
							if ($_FILES["file"]["error"] > 0)
							{
									echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
							}
							else
							{
								$file_name1=$_FILES["file"]["name"];
								$finalname=(explode(".", $file_name1));
								$ext = end($finalname);
								move_uploaded_file($_FILES["file"]["tmp_name"],"audio/.{$login_session}.name.{$ext}");
								# The name of the audio file to transcribe
								$fileName = 'audio/name.'.$ext;
								$object_name='name_16dx16.'.$ext;
								$language=$_POST["lang"];
								$output_format=$_POST["output"];
								require_once 'upload.php';
								$transcript=upload_object('my_firsttry', $object_name,$fileName,$language);
								if($output_format=='note')
									{
									$file = fopen("output/notepad/test.txt","w");
									fwrite($file,$transcript);
									fclose($file);
									$file_loc="output/notepad/test.txt";
									header("Refresh:5;url=notepad_download.php?file=".$file_loc);
		?>	
	<div class="alert alert-primary">
    <strong>Message!</strong> if file not downloaded,Download file from <a href="notepad_download.php?file=<?php echo $file_loc ?>">here.</a>
	<a href="#" class="close" data-dismiss="alert">&times;</a>
  </div>
 <?php
							
									}
									else if($output_format=='Word')
									{
									require_once 'word.php';
									getData($transcript);
										?>	
	<div class="alert alert-primary">
    <strong>Message!</strong> if file not downloaded,Download file from <a href="download.php">here.</a>
	<a href="#" class="close" data-dismiss="alert">&times;</a>

  </div>
		<?php							}
							}
						}
						else 
		{
			?>
			<div class="alert alert-danger">
    <strong>ERROR!</strong> Please upload a valid flac file.
	<a href="#" class="close" data-dismiss="alert">&times;</a> 
  </div>
  <?php
	}

}
if(isset($_POST['event_submit']))
{
	$event_name=$_POST['event_name'];
	$event_loaction=$_POST['event_loc'];
	$event_date=$_POST['event_date'];
	$event_description=$_POST['event_des'];
	require_once 'sql.php';
	$result=mysqli_query($con,"insert into event VALUES('$event_name','$event_loaction','$event_date','$event_description','$login_session')");
	$result1=mysqli_query($con,"insert into notification  VALUES('$login_session',NULL,'Created a event called $event_name',NOW(),0)");
	if($result)
	{
		echo mysqli_error($con);
		?>
		<script>alert("sucessfully updated ");</script>
	<?php
	header( "refresh:1; url=index.php" ); 
	}
	else
	{?>
			<script>alert("some error occured");</script>
		<?php
	}
}
?>
<html>
<head>
<title>Speech to text</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="styles.css">
 <script src="js/jquery.min.js"></script>
 <script src="js/bootstrap.min.js"></script>
	<script src="js/filecheck.js"></script>
	<script>
	function delete_key(login)
{
	$.ajax({
  type: 'post',
  url: 'delete_notify.php',
  data: {
   session:login,
    },
  success: function (response) {
 $('#status' ).html(response);
	if(response=="success")	
   {
	alert("all notifications cleared");
window.location.assign("index.php");	
  }
  else
  {
	alert("please try again");  
  }
  }
  });
}
</script>
 <style>
 #snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

.topnav {
  overflow: hidden;
  background-color: #286fc3;
}
.write{
  color: #305477; 
  font-family: "GOOGLE";
  font-size: 20px;
  margin: 10px 0 0 10px;
  white-space: nowrap;
  overflow: hidden;
  width: 21em;
  animation: type 4s steps(1000, end); 
}


.write a{
  color: lime;
  text-decoration: none;
}


@keyframes type{ 
  from { width: 0; } 
} 

@keyframes type2{
  0%{width: 0;}
  50%{width: 0;}
  100%{ width: 100; } 
} 

@keyframes blink{
  to{opacity: .0;}
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.top a {
  float: right;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.active {
  background-color:#af664c;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
}

textarea {
    width: 100%;
    height: 150px;
    padding: 12px 20px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #f8f8f8;
    font-size: 16px;
    resize: none;
}
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 9px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.jumbotron {
    padding: 2rem 1rem;
    margin-bottom: 2rem;
    background-color: #e9ecef;
    border-radius: .3rem;
}
.text-center {
    text-align: center!important;
}
.button:hover span {
  padding-right: 20px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
#Large {
  background-image: url("images/bg/small.jpg");
}
#form {
  background-image: url("images/bg/small.jpg");
}
#demo {
  background-image: url("images/bg/live.jpg");
}
img:hover {
  /* Start the shake animation and make the animation last for 0.5 seconds */
  animation: shake 0.5s; 

  /* When the animation is finished, start again */
  animation-iteration-count: infinite; 
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}

</style>
</head>
<body background="images/bg/bgprofile.gif">
<script>
  $(document).ready(function(){

  $(document).ajaxStart(function(){
		$("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
		               $("#wait").css("display", "none");
	});
	$("#smallbutton").click(function(){
      $("#form").collapse('hide'); //hide
    });
	
	$("#largebutton").click(function(){
      $("#Large").collapse('hide'); //hide
    });

    $("#audio").submit(function()
			{
		        $("#form").load("index.php");
    });
	$("#audio_large").submit(function()
			{
		        $("#Large").load("index.php");
    });
});

</script>
	<header>
	<div class="jumbotron text-center" style="margin-bottom:0">
<h3 class="write"><i class="fa fa-microphone "></i> WELCOME TO SPEECH-TO-TEXT</h3>
 </div>

<nav class="navbar navbar-expand-md bg-dark navbar-dark" style="background-color:#286fc3 !important;">
  <a class="navbar-brand" href="#"><i class="fa fa-microphone "></i> Speech To Text</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#container" ><i class="fa fa-bullhorn"></i> Convert</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#event" ><i class="fa fa-book"></i> Event Details</a>
      </li>
	 
    
	   </ul>
	     <ul class="navbar-nav ml-auto">

<li class="nav-item dropdown">
<?php
	  require_once 'sql.php';
	  $reset=mysqli_query($con,"select message,created_time  from notification where for_name='$login_session' AND is_read!=1");   
	    $not_no=mysqli_num_rows($reset);
?>	
	<a class="nav-link dropdown-toggle" style="padding-left:170px !important" href="#" id="navbardrop" data-toggle="dropdown" ><i class="fa fa-bell"></i><span class="badge"style="background-color:green"><?php echo $not_no;?></span> NOTIFICATION</a>
 <div class="dropdown-menu">

      <button onclick="delete_key('<?php echo $login_session;?>')" class="btn btn-warning" style="padding-left:50px">CLEAR ALL</button>
	   <?php 
	   echo "<a class='dropdown-item' href='#'> "."<div class='alert alert-primary' role='alert'>
 "."Your last login was on  ". $_SESSION['last_login']."</div></a>";

	  $i=1;$j=2;$k=3;
		$m=4;$n=5;$o=6;
	  while ($row =mysqli_fetch_array($reset))
	{
        $message= $row['message'];
        $time= $row['created_time'];
		if($m==($i+3))
		{
		echo "<a class='dropdown-item' href='#'> "."<div class='alert alert-primary' role='alert'>
 ".$message." ". $time." &times;</div></a>";
 $i=$i+1;
		}
		else if($n==($j+3))
		{
   echo "<a class='dropdown-item' href='#'>"."<div class='alert alert-secondary' role='alert'>
".$message." ".$time."</div></a>";
		$j=$j+1;
		}
		else if($o==($k+3))
		{
echo "<a class='dropdown-item' href='#'>"."<div class='alert alert-success' role='alert'>
 ".$message." ". $time."</div></a>";
 $k=$k+1;
 $m=$m+1;
 $n=$n+1;
 $k=$k+1;
		}
	}
	 ?>
	 	</div>
   
 </li>	
<img  src="profilepic/<?php echo $login_session;?>/<?php echo $login_session;?>.jpg" class="avatar img-circle" alt="avatar" height="35" width="35">
 
		<li class="nav-item dropdown">
 <?php 
 require_once 'sql.php';
		$result=mysqli_query($con,"select verify from login where username='$login_session'");
		while($row=mysqli_fetch_array($result))//while look to fetch the result and store in a array $row.  
        {  
			$verify=$row[0];  
  	}
	if($verify==0)
	{?>
 <a class="nav-link dropdown-toggle" style="padding-left:70px !important" href="#" id="navbardrop" data-toggle="dropdown">
		<i class="fa fa-fw fa-users"></i><span class="badge"style="background-color:red">1</span><?php echo $login_session;?>
		</a>
<?php
	}
	else
	{
		?>
 <a class="nav-link dropdown-toggle" style="padding-left:70px !important" href="#" id="navbardrop" data-toggle="dropdown">
		<i class="fa fa-fw fa-users"></i><?php echo $login_session;?>
		</a>
	<?php
	}
	?>
	 <div class="dropdown-menu">
        <a class="dropdown-item" href="profile.php"><i class="fa fa-fw fa-home"></i>Profile</a>
        <a class="dropdown-item" href="edit_profile.php"><i class="fa fa-edit"></i>Edit</a>
        <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
      </div>
    </li>

	 </ul>
  </div>  
</nav>
<br>
</header>
 


	<div id="min" style="display:none;">
<div class="alert alert-info">
    <strong>Info!</strong> use longer Audio section.
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	</div>
</div>
<div id="min>" style="display:none;">
<div class="alert alert-info">
    <strong>Info!</strong> use Short Audio section.
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	</div>
</div>
 <div class="container">
 <?php
 require_once 'sql.php';
		$result=mysqli_query($con,"select verify from login where username='$login_session'");
		while($row=mysqli_fetch_array($result))//while look to fetch the result and store in a array $row.  
        {  
			$verify=$row[0];  
  	}
	if($verify==1)
{
 ?>
<button type="button"  class="btn" data-toggle="collapse" data-target="#form" id="local">Small Audio</button>&#160;&#160;&#160;
	<button type="button" class="btn btn-primary"id="foriegn" class="btn btn-info" data-toggle="collapse" data-target="#demo">Real Time</button>&#160;&#160;&#160;
<button type="button" id="long" class="btn btn-secondary" data-toggle="collapse" data-target="#large">Large Audio</button>
	<br>
	<br>
	<br>
<?php
}
else
{
?>
<div id="snackbar" >Please verify your mobile to continue</div>
<?php
}
?>
	   
<div id="form" class="collapse in">
<h2>Short Audio Recognition</h2>

<form action="index.php" method="post" enctype="multipart/form-data" id="audio">
<select name="event_o" id="event_o"  required>
										<option disabled  selected value="none">Select  the event that you have saved</option>
										<?php
require_once 'sql.php';
        $result = mysqli_query($con,"select event_name from event where created_by='$login_session' ");
    while ($row = $result->fetch_assoc()) 
	{
        $eventname = $row['event_name'];
        echo '<option value=" '.$eventname.'">eventname:'.$eventname.'</option>';
    }
	echo mysqli_error($con);
	?>										
										</select>

<select name="output">
<option value='note'>Notepad</option>
<option value='Word'>Word document</option>
</select>
<select name="lang">
    <option value='af-ZA'>Afrikaans (South Africa)</option>
    <option value='am-ET'>Amharic (Ethiopia)</option>
	<option value='hy-AM'>Armenian (Armenia)</option>
	<option value='az-AZ'>Azerbaijani(Azerbaijan)</option>
  <option value='id-ID'>Indonesian (Indonesia)</option>
  <option value='ms-MY'>Malay (Malaysia)</option>
  <option value='bn-BD'>Bengali (Bangladesh)</option>
  <option value='bn-IN'>Bengali (India)</option>
  <option value='ca-ES'>Catalan (Spain)</option>
   <option value='cs-CZ'>  Czech (Czech Republic)</option>
 <option value='da-DK'>	Danish (Denmark)</option>
 <option value='de-DE'>	German (Germany)</option>
 <option value='en-AU'>	English (Australia)</option>
 <option value='en-CA'>	English (Canada)</option>
 <option value='en-GH'>	English (Ghana)</option>
 <option value='en-GB'>	English (United Kingdom)</option>
 <option value='en-IN'>	English (India)</option>
	 <option value='en-IE'>	English (Ireland)</option>
 <option value='en-KE'>	English (Kenya)</option>
 <option value='en-NZ'>	English (New Zealand)</option>
 <option value='en-NG'>	English (Nigeria)</option>
 <option value='en-PH'>	English (Philippines)</option>
	 <option value='en-ZA'>	English (South Africa)</option>
	 <option value='en-TZ'>	English (Tanzania)</option>
	 <option value='en-US'selected>	English (United States)</option>
	 
	 
<option value='es-AR'>	Spanish (Argentina)</option>
<option value='	es-BO'>	Spanish (Bolivia)</option>
<option value='es-CL'>	Spanish (Chile)</option>
<option value='es-CO'>	Spanish (Colombia)</option>
<option value='es-CR'>	Spanish (Costa Rica)</option>
<option value='es-EC'>	Spanish (Ecuador)</option>
<option value='es-SV'>	Spanish (El Salvador)</option>
<option value='es-ES'>	Spanish (Spain)</option>
<option value='es-US' >	Spanish (United States)</option>
<option value='	es-GT'>	Spanish (Guatemala)</option>
<option value='es-HN'>	Spanish (Honduras)</option>
<option value='es-MX'>	Spanish (Mexico)</option>
<option value='	es-NI'>	Spanish (Nicaragua)</option>
<option value='es-PA'>	Spanish (Panama)</option>
<option value='es-PY'>	Spanish (Paraguay)</option>
<option value='es-PE'>	Spanish (Peru)</option>
<option value='es-PR'>	Spanish (Puerto Rico)</option>
<option value='es-DO'>	Spanish (Dominican Republic)</option>
<option value='es-UY'>	Spanish (Uruguay)</option>
<option value='es-VE'>	Spanish (Venezuela)</option>
<option value='eu-ES'>	Basque (Spain)</option>
<option value='fil-PH'>	Filipino (Philippines)</option>
<option value='fr-CA'>	French (Canada)</option>
<option value='fr-FR'>	French (France)</option>
<option value='gl-ES'>	Galician (Spain)</option>
<option value='ka-GE'>	Georgian (Georgia)</option>
<option value='gu-IN'>	Gujarati (India)</option>
<option value='hr-HR'>	Croatian (Croatia)</option>
<option value='zu-ZA'>	Zulu (South Africa)</option>
<option value='is-IS'>	Icelandic (Iceland)</option>
<option value='it-IT'>	Italian (Italy)</option>
<option value='jv-ID'>	Javanese (Indonesia)</option>
<option value='kn-IN'>	Kannada (India)</option>
<option value='km-KH'>	Khmer (Cambodia)</option>
<option value='lo-LA'>	Lao (Laos)</option>
<option value='lv-LV'>Latvian (Latvia)</option>
<option value='lt-LT'>Lithuanian (Lithuania)</option>
<option value='hu-HU'>Hungarian (Hungary)</option>
<option value='ml-IN'>	Malayalam (India)</option>
<option value='mr-IN'>	Marathi (India)</option>
<option value='nl-NL'>	Dutch (Netherlands)</option>
<option value='ne-NP'>	Nepali (Nepal)</option>
<option value='nb-NO'>	Norwegian Bokmål (Norway)</option>
<option value='pl-PL'>	Polish (Poland)</option>
<option value='pt-BR'>	Portuguese (Brazil)</option>
<option value='pt-PT'>	Portuguese (Portugal)</option>
<option value='ro-RO'>	Romanian (Romania)</option>
<option value='si-LK'>	Sinhala (Sri Lanka)</option>
<option value='sk-SK'>	Slovak (Slovakia)</option>
<option value='sl-SI'>	Slovenian (Slovenia)</option>
<option value='su-ID'>	Sundanese (Indonesia)</option>
<option value='sw-TZ'>	Swahili (Tanzania)</option>
<option value='sw-KE'>	Swahili (Kenya)</option>
<option value='fi-FI'>	Finnish (Finland)</option>
<option value='sv-SE'>	Swedish (Sweden)</option>
<option value='ta-IN'>	Tamil (India)</option>
<option value='ta-SG'>	Tamil (Singapore)</option>
<option value='ta-LK'>	Tamil (Sri Lanka)</option>
<option value='ta-MY'>	Tamil (Malaysia)</option>
<option value='te-IN'>	Telugu (India)</option>
<option value='vi-VN'>	Vietnamese (Vietnam)</option>

<option value='tr-TR'>	Turkish (Turkey)</option>
<option value='ur-PK'>	Urdu (Pakistan)</option>
<option value='ur-IN'>	Urdu (India)</option>
<option value='el-GR'>	Greek (Greece)</option>
<option value='bg-BG'>	Bulgarian (Bulgaria)</option>
<option value='ru-RU'>	Russian (Russia)</option>
<option value='sr-RS'>	Serbian (Serbia)</option>
<option value='uk-UA'>	Ukrainian (Ukraine)</option>
<option value='he-IL'>	Hebrew (Israel)</option>
<option value='ar-IL'>	Arabic (Israel)</option>
<option value='ar-JO'>	Arabic (Jordan)</option>
<option value='ar-AE'>	Arabic (United Arab Emirates)</option>
<option value='ar-BH'>	Arabic (Bahrain)</option>
<option value='ar-DZ'>	Arabic (Algeria)</option>
<option value='ar-SA'>	Arabic (Saudi Arabia)</option>
<option value='ar-IQ'>	Arabic (Iraq)</option>
<option value='ar-KW'>	Arabic (Kuwait)</option>
<option value='ar-MA'>	Arabic (Morocco)</option>
<option value='ar-TN'>	Arabic (Tunisia)</option>
<option value='ar-OM'>	Arabic (Oman)</option>
<option value='ar-PS'>Arabic (State of Palestine)</option>
<option value='ar-QA'>	Arabic (Qatar)</option>
<option value='ar-LB'>	Arabic (Lebanon)</option>
<option value='ar-EG'>	Arabic (Egypt)</option>
<option value='fa-IR'>	Persian (Iran)</option>
<option value='hi-IN'>	Hindi (India)</option>
<option value='th-TH'>	Thai (Thailand)</option>
<option value='ko-KR'>	Korean (South Korea)</option>
<option value='cmn-Hant-TW'>Chinese, Mandarin (Traditional, Taiwan)</option>
<option value='yue-Hant-HK'>Chinese, Cantonese (Traditional, Hong Kong)</option>
<option value='ja-JP'>Japanese (Japan)</option>
<option value='cmn-Hans-HK'>Chinese, Mandarin (Simplified, Hong Kong)</option>
<option value='cmn-Hans-CN'>Chinese, Mandarin (Simplified, China)</option>
</select>
<input type="file" name="file" id="file" class="btn btn-warning" onchange="checkFileDuration()"required/> 
<button  name="submit" class="button" id="smallbutton" style="vertical-align:middle" disabled><span>Upload</span></button>
</form>
   </div>

   <div id="Large" class="collapse in">
<h2>Long Audio Recognition</h2>
<form action="index.php" method="post" enctype="multipart/form-data" id="audio_large">
<select name="event_o" id="event_o"  required>
										<option disabled  selected value="none">Select  the event that you have saved</option>
										<?php
require_once 'sql.php';
        $result = mysqli_query($con,"select event_name from event where created_by='$login_session' ");
    while ($row = $result->fetch_assoc()) 
	{
        $eventname = $row['event_name'];
        echo '<option value=" '.$eventname.'">eventname:'.$eventname.'</option>';
    }
	echo mysqli_error($con);
	?>										
										</select>
					
<select name="output">
<option value='note'>Notepad</option>
<option value='Word'>Word document</option>
</select>

<select name="lang">
    <option value='af-ZA'>Afrikaans (South Africa)</option>
    <option value='am-ET'>Amharic (Ethiopia)</option>
	<option value='hy-AM'>Armenian (Armenia)</option>
	<option value='az-AZ'>Azerbaijani(Azerbaijan)</option>
  <option value='id-ID'>Indonesian (Indonesia)</option>
  <option value='ms-MY'>Malay (Malaysia)</option>
  <option value='bn-BD'>Bengali (Bangladesh)</option>
  <option value='bn-IN'>Bengali (India)</option>
  <option value='ca-ES'>Catalan (Spain)</option>
   <option value='cs-CZ'>  Czech (Czech Republic)</option>
 <option value='da-DK'>	Danish (Denmark)</option>
 <option value='de-DE'>	German (Germany)</option>
 <option value='en-AU'>	English (Australia)</option>
 <option value='en-CA'>	English (Canada)</option>
 <option value='en-GH'>	English (Ghana)</option>
 <option value='en-GB'>	English (United Kingdom)</option>
 <option value='en-IN'>	English (India)</option>
	 <option value='en-IE'>	English (Ireland)</option>
 <option value='en-KE'>	English (Kenya)</option>
 <option value='en-NZ'>	English (New Zealand)</option>
 <option value='en-NG'>	English (Nigeria)</option>
 <option value='en-PH'>	English (Philippines)</option>
	 <option value='en-ZA'>	English (South Africa)</option>
	 <option value='en-TZ'>	English (Tanzania)</option>
	 <option value='en-US'selected>	English (United States)</option>
	 
	 
<option value='es-AR'>	Spanish (Argentina)</option>
<option value='	es-BO'>	Spanish (Bolivia)</option>
<option value='es-CL'>	Spanish (Chile)</option>
<option value='es-CO'>	Spanish (Colombia)</option>
<option value='es-CR'>	Spanish (Costa Rica)</option>
<option value='es-EC'>	Spanish (Ecuador)</option>
<option value='es-SV'>	Spanish (El Salvador)</option>
<option value='es-ES'>	Spanish (Spain)</option>
<option value='es-US' >	Spanish (United States)</option>
<option value='	es-GT'>	Spanish (Guatemala)</option>
<option value='es-HN'>	Spanish (Honduras)</option>
<option value='es-MX'>	Spanish (Mexico)</option>
<option value='	es-NI'>	Spanish (Nicaragua)</option>
<option value='es-PA'>	Spanish (Panama)</option>
<option value='es-PY'>	Spanish (Paraguay)</option>
<option value='es-PE'>	Spanish (Peru)</option>
<option value='es-PR'>	Spanish (Puerto Rico)</option>
<option value='es-DO'>	Spanish (Dominican Republic)</option>
<option value='es-UY'>	Spanish (Uruguay)</option>
<option value='es-VE'>	Spanish (Venezuela)</option>
<option value='eu-ES'>	Basque (Spain)</option>
<option value='fil-PH'>	Filipino (Philippines)</option>
<option value='fr-CA'>	French (Canada)</option>
<option value='fr-FR'>	French (France)</option>
<option value='gl-ES'>	Galician (Spain)</option>
<option value='ka-GE'>	Georgian (Georgia)</option>
<option value='gu-IN'>	Gujarati (India)</option>
<option value='hr-HR'>	Croatian (Croatia)</option>
<option value='zu-ZA'>	Zulu (South Africa)</option>
<option value='is-IS'>	Icelandic (Iceland)</option>
<option value='it-IT'>	Italian (Italy)</option>
<option value='jv-ID'>	Javanese (Indonesia)</option>
<option value='kn-IN'>	Kannada (India)</option>
<option value='km-KH'>	Khmer (Cambodia)</option>
<option value='lo-LA'>	Lao (Laos)</option>
<option value='lv-LV'>Latvian (Latvia)</option>
<option value='lt-LT'>Lithuanian (Lithuania)</option>
<option value='hu-HU'>Hungarian (Hungary)</option>
<option value='ml-IN'>	Malayalam (India)</option>
<option value='mr-IN'>	Marathi (India)</option>
<option value='nl-NL'>	Dutch (Netherlands)</option>
<option value='ne-NP'>	Nepali (Nepal)</option>
<option value='nb-NO'>	Norwegian Bokmål (Norway)</option>
<option value='pl-PL'>	Polish (Poland)</option>
<option value='pt-BR'>	Portuguese (Brazil)</option>
<option value='pt-PT'>	Portuguese (Portugal)</option>
<option value='ro-RO'>	Romanian (Romania)</option>
<option value='si-LK'>	Sinhala (Sri Lanka)</option>
<option value='sk-SK'>	Slovak (Slovakia)</option>
<option value='sl-SI'>	Slovenian (Slovenia)</option>
<option value='su-ID'>	Sundanese (Indonesia)</option>
<option value='sw-TZ'>	Swahili (Tanzania)</option>
<option value='sw-KE'>	Swahili (Kenya)</option>
<option value='fi-FI'>	Finnish (Finland)</option>
<option value='sv-SE'>	Swedish (Sweden)</option>
<option value='ta-IN'>	Tamil (India)</option>
<option value='ta-SG'>	Tamil (Singapore)</option>
<option value='ta-LK'>	Tamil (Sri Lanka)</option>
<option value='ta-MY'>	Tamil (Malaysia)</option>
<option value='te-IN'>	Telugu (India)</option>
<option value='vi-VN'>	Vietnamese (Vietnam)</option>

<option value='tr-TR'>	Turkish (Turkey)</option>
<option value='ur-PK'>	Urdu (Pakistan)</option>
<option value='ur-IN'>	Urdu (India)</option>
<option value='el-GR'>	Greek (Greece)</option>
<option value='bg-BG'>	Bulgarian (Bulgaria)</option>
<option value='ru-RU'>	Russian (Russia)</option>
<option value='sr-RS'>	Serbian (Serbia)</option>
<option value='uk-UA'>	Ukrainian (Ukraine)</option>
<option value='he-IL'>	Hebrew (Israel)</option>
<option value='ar-IL'>	Arabic (Israel)</option>
<option value='ar-JO'>	Arabic (Jordan)</option>
<option value='ar-AE'>	Arabic (United Arab Emirates)</option>
<option value='ar-BH'>	Arabic (Bahrain)</option>
<option value='ar-DZ'>	Arabic (Algeria)</option>
<option value='ar-SA'>	Arabic (Saudi Arabia)</option>
<option value='ar-IQ'>	Arabic (Iraq)</option>
<option value='ar-KW'>	Arabic (Kuwait)</option>
<option value='ar-MA'>	Arabic (Morocco)</option>
<option value='ar-TN'>	Arabic (Tunisia)</option>
<option value='ar-OM'>	Arabic (Oman)</option>
<option value='ar-PS'>Arabic (State of Palestine)</option>
<option value='ar-QA'>	Arabic (Qatar)</option>
<option value='ar-LB'>	Arabic (Lebanon)</option>
<option value='ar-EG'>	Arabic (Egypt)</option>
<option value='fa-IR'>	Persian (Iran)</option>
<option value='hi-IN'>	Hindi (India)</option>
<option value='th-TH'>	Thai (Thailand)</option>
<option value='ko-KR'>	Korean (South Korea)</option>
<option value='cmn-Hant-TW'>Chinese, Mandarin (Traditional, Taiwan)</option>
<option value='yue-Hant-HK'>Chinese, Cantonese (Traditional, Hong Kong)</option>
<option value='ja-JP'>Japanese (Japan)</option>
<option value='cmn-Hans-HK'>Chinese, Mandarin (Simplified, Hong Kong)</option>
<option value='cmn-Hans-CN'>Chinese, Mandarin (Simplified, China)</option>
</select>
<input type="file" name="file" class="btn btn-warning" id="file_large"  onchange="checkFileDuration_long()"required/> 
<button  name="submit_1" id="largebutton" class="button" style="vertical-align:middle" disabled><span>Upload</span></button>
</form>
   </div> 
   
  <div id="demo" class="collapse in">
		<h3 class="no-browser-support">Sorry, Your Browser Doesn't Support the Web Speech API. Try Opening This Demo In Google Chrome.</h3>

            <div class="app"> 
                <h3>Speech Note</h3>
<select name="language" id="language">
    <option value='af-ZA'>Afrikaans (South Africa)</option>
    <option value='am-ET'>Amharic (Ethiopia)</option>
	<option value='hy-AM'>Armenian (Armenia)</option>
	<option value='az-AZ'>Azerbaijani(Azerbaijan)</option>
  <option value='id-ID'>Indonesian (Indonesia)</option>
  <option value='ms-MY'>Malay (Malaysia)</option>
  <option value='bn-BD'>Bengali (Bangladesh)</option>
  <option value='bn-IN'>Bengali (India)</option>
  <option value='ca-ES'>Catalan (Spain)</option>
   <option value='cs-CZ'>  Czech (Czech Republic)</option>
 <option value='da-DK'>	Danish (Denmark)</option>
 <option value='de-DE'>	German (Germany)</option>
 <option value='en-AU'>	English (Australia)</option>
 <option value='en-CA'>	English (Canada)</option>
 <option value='en-GH'>	English (Ghana)</option>
 <option value='en-GB'>	English (United Kingdom)</option>
 <option value='en-IN'>	English (India)</option>
	 <option value='en-IE'>	English (Ireland)</option>
 <option value='en-KE'>	English (Kenya)</option>
 <option value='en-NZ'>	English (New Zealand)</option>
 <option value='en-NG'>	English (Nigeria)</option>
 <option value='en-PH'>	English (Philippines)</option>
	 <option value='en-ZA'>	English (South Africa)</option>
	 <option value='en-TZ'>	English (Tanzania)</option>
	 <option value='en-US'selected>	English (United States)</option>
	 
	 
<option value='es-AR'>	Spanish (Argentina)</option>
<option value='	es-BO'>	Spanish (Bolivia)</option>
<option value='es-CL'>	Spanish (Chile)</option>
<option value='es-CO'>	Spanish (Colombia)</option>
<option value='es-CR'>	Spanish (Costa Rica)</option>
<option value='es-EC'>	Spanish (Ecuador)</option>
<option value='es-SV'>	Spanish (El Salvador)</option>
<option value='es-ES'>	Spanish (Spain)</option>
<option value='es-US' >	Spanish (United States)</option>
<option value='	es-GT'>	Spanish (Guatemala)</option>
<option value='es-HN'>	Spanish (Honduras)</option>
<option value='es-MX'>	Spanish (Mexico)</option>
<option value='	es-NI'>	Spanish (Nicaragua)</option>
<option value='es-PA'>	Spanish (Panama)</option>
<option value='es-PY'>	Spanish (Paraguay)</option>
<option value='es-PE'>	Spanish (Peru)</option>
<option value='es-PR'>	Spanish (Puerto Rico)</option>
<option value='es-DO'>	Spanish (Dominican Republic)</option>
<option value='es-UY'>	Spanish (Uruguay)</option>
<option value='es-VE'>	Spanish (Venezuela)</option>
<option value='eu-ES'>	Basque (Spain)</option>
<option value='fil-PH'>	Filipino (Philippines)</option>
<option value='fr-CA'>	French (Canada)</option>
<option value='fr-FR'>	French (France)</option>
<option value='gl-ES'>	Galician (Spain)</option>
<option value='ka-GE'>	Georgian (Georgia)</option>
<option value='gu-IN'>	Gujarati (India)</option>
<option value='hr-HR'>	Croatian (Croatia)</option>
<option value='zu-ZA'>	Zulu (South Africa)</option>
<option value='is-IS'>	Icelandic (Iceland)</option>
<option value='it-IT'>	Italian (Italy)</option>
<option value='jv-ID'>	Javanese (Indonesia)</option>
<option value='kn-IN'>	Kannada (India)</option>
<option value='km-KH'>	Khmer (Cambodia)</option>
<option value='lo-LA'>	Lao (Laos)</option>
<option value='lv-LV'>Latvian (Latvia)</option>
<option value='lt-LT'>Lithuanian (Lithuania)</option>
<option value='hu-HU'>Hungarian (Hungary)</option>
<option value='ml-IN'>	Malayalam (India)</option>
<option value='mr-IN'>	Marathi (India)</option>
<option value='nl-NL'>	Dutch (Netherlands)</option>
<option value='ne-NP'>	Nepali (Nepal)</option>
<option value='nb-NO'>	Norwegian Bokmål (Norway)</option>
<option value='pl-PL'>	Polish (Poland)</option>
<option value='pt-BR'>	Portuguese (Brazil)</option>
<option value='pt-PT'>	Portuguese (Portugal)</option>
<option value='ro-RO'>	Romanian (Romania)</option>
<option value='si-LK'>	Sinhala (Sri Lanka)</option>
<option value='sk-SK'>	Slovak (Slovakia)</option>
<option value='sl-SI'>	Slovenian (Slovenia)</option>
<option value='su-ID'>	Sundanese (Indonesia)</option>
<option value='sw-TZ'>	Swahili (Tanzania)</option>
<option value='sw-KE'>	Swahili (Kenya)</option>
<option value='fi-FI'>	Finnish (Finland)</option>
<option value='sv-SE'>	Swedish (Sweden)</option>
<option value='ta-IN'>	Tamil (India)</option>
<option value='ta-SG'>	Tamil (Singapore)</option>
<option value='ta-LK'>	Tamil (Sri Lanka)</option>
<option value='ta-MY'>	Tamil (Malaysia)</option>
<option value='te-IN'>	Telugu (India)</option>
<option value='vi-VN'>	Vietnamese (Vietnam)</option>

<option value='tr-TR'>	Turkish (Turkey)</option>
<option value='ur-PK'>	Urdu (Pakistan)</option>
<option value='ur-IN'>	Urdu (India)</option>
<option value='el-GR'>	Greek (Greece)</option>
<option value='bg-BG'>	Bulgarian (Bulgaria)</option>
<option value='ru-RU'>	Russian (Russia)</option>
<option value='sr-RS'>	Serbian (Serbia)</option>
<option value='uk-UA'>	Ukrainian (Ukraine)</option>
<option value='he-IL'>	Hebrew (Israel)</option>
<option value='ar-IL'>	Arabic (Israel)</option>
<option value='ar-JO'>	Arabic (Jordan)</option>
<option value='ar-AE'>	Arabic (United Arab Emirates)</option>
<option value='ar-BH'>	Arabic (Bahrain)</option>
<option value='ar-DZ'>	Arabic (Algeria)</option>
<option value='ar-SA'>	Arabic (Saudi Arabia)</option>
<option value='ar-IQ'>	Arabic (Iraq)</option>
<option value='ar-KW'>	Arabic (Kuwait)</option>
<option value='ar-MA'>	Arabic (Morocco)</option>
<option value='ar-TN'>	Arabic (Tunisia)</option>
<option value='ar-OM'>	Arabic (Oman)</option>
<option value='ar-PS'>Arabic (State of Palestine)</option>
<option value='ar-QA'>	Arabic (Qatar)</option>
<option value='ar-LB'>	Arabic (Lebanon)</option>
<option value='ar-EG'>	Arabic (Egypt)</option>
<option value='fa-IR'>	Persian (Iran)</option>
<option value='hi-IN'>	Hindi (India)</option>
<option value='th-TH'>	Thai (Thailand)</option>
<option value='ko-KR'>	Korean (South Korea)</option>
<option value='cmn-Hant-TW'>Chinese, Mandarin (Traditional, Taiwan)</option>
<option value='yue-Hant-HK'>Chinese, Cantonese (Traditional, Hong Kong)</option>
<option value='ja-JP'>Japanese (Japan)</option>
<option value='cmn-Hans-HK'>Chinese, Mandarin (Simplified, Hong Kong)</option>
<option value='cmn-Hans-CN'>Chinese, Mandarin (Simplified, China)</option>
</select>
           
			   <div class="input-single">
                    <textarea id="note-textarea" placeholder="Create a new note by typing or using voice recognition." rows="6"></textarea>
                </div>         
		        <button id="start-record-btn" title="Start Recording" onclick="onSend()"class="btn btn-success">Start Recognition</button>
                <button id="pause-record-btn" title="Pause Recording" class="btn btn-danger">Pause Recognition</button>
                <p id="recording-instructions">Press the <strong>Start Recognition</strong> button and allow access.</p>  
            </div> 
 <script src="script.js"></script>
        </div>
<div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
<img src='images/load/demo.gif' width="64" height="64" />
<br>Loading..</div>
		<div id="pross" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
  <img src="images/load/loader.gif" width="64" height="64"  />
</div>
<div style="padding-top:700px" >
<div id="event">
<h3> EVENT DETAILS</h3>
<form method="post" action="index.php">
<input type="text" name="event_name" placeholder="Enter Event Name"  required>
<input type="text" name="event_loc" placeholder="Enter Event location" required>
<input type="date" name="event_date" required><br><br>
<textarea placeholder="Enter Event Description" name="event_des" rows="6" required>
</textarea>
<br><br>
<button type="submit" name="event_submit">SUBMIT</button>
</form>
</div>
</div>	
</div>
<script>    
	 var x = document.getElementById("snackbar");
  x.className = "show";
	setInterval(interval,5000);
  function interval()
  { var x = document.getElementById("snackbar");
  x.className = "show";
   x.hide();
   }
</script>
<footer>
<div class="jumbotron text-center" style="margin-bottom:0">
<h3 class="write"><i class="fa fa-microphone "></i> Designed and Developed by PSG Ptc..&copy;</h3>
 </div>
</footer>

</body>
</html>

