<?php
include('login.php'); 
if(isset($_SESSION['login_user']))
{
header("location: index.php");
}// Includes Login Script
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/homestyle.css">  
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>  
<script src="js/bootstrap.min.js"></script>


</head>
<style>
 /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 100%;
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
ul {
    list-style: none;
    padding: 0;
}

</style>
<body  style="background-color:#286fc3">

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
        <a class="nav-link" href="#" ><i class="fa fa-fw fa-home"></i> Home</a>
      </li>
       <li class="nav-item">     
    <a class="nav-link" href="#about"><i class="fa fa-fw fa-search"></i> ABOUT</a>
      </li>
	  <li class="nav-item">     
    <a class="nav-link" href="#contact">
	  <i class="fa fa-fw fa-envelope"></i> Contact</a>
      </li>
 	 <li class="nav-item">     
    <a  class="nav-link" onclick="document.getElementById('id02').style.display='block'" style="width:auto;"><i class="fa fa-fw fa-user"></i> Sign-up</a>
	</li>	
	<li class="nav-item">    
         <a  class="nav-link" href="#" onclick="document.getElementById('myModal').style.display='block'"><font color="white">Reset password?</font></a>
</li>

	</ul>
<form class="form-inline" action="login.php" method="post">
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">@</span>
      </div>

       <input type="text" id="but1" class="form-control" placeholder="Enter Username" name="uname" required>
 &#160;&#160;&#160;&#160; <div class="input-group-prepend">
        <span class="input-group-text">*</span>
      </div>
      <input type="password" id="but" class="form-control" placeholder="Enter Password" name="psw" required>
        <button type="submit" id="styleset" name="submit_login">Login</button>
   
	</div>    
 </form>
 	
  </div>  
</nav>

 
 
 
 
 <div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/bg/map3.png" alt="Los Angeles" width="500" height="100">
    </div>
    <div class="carousel-item">
      <img src="images/bg/map1.jpg" alt="Chicago" width="500" height="100">
    </div>
    <div class="carousel-item">
      <img src="images/bg/map.jpg" alt="New York" width="500" height="100">
    </div>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

 
 
<div id="about">
<hr>
<br>
<h3 align="center">ABOUT</h3>
<p>Speech recognition is the inter-disciplinary sub-field of computational linguistics that develops methodologies and technologies that enables the recognition and translation of spoken language into text by computers. It is also known as automatic speech recognition (ASR), computer speech recognition or speech to text (STT). It incorporates knowledge and research in the linguistics, computer science, and electrical engineering fields.

Some speech recognition systems require "training" (also called "enrollment") where an individual speaker reads text or isolated vocabulary into the system. The system analyzes the person's specific voice and uses it to fine-tune the recognition of that person's speech, resulting in increased accuracy. Systems that do not use training are called "speaker independent" systems. Systems that use training are called "speaker dependent".

Speech recognition applications include voice user interfaces such as voice dialing (e.g. "call home"), call routing (e.g. "I would like to make a collect call"), domotic appliance control, search (e.g. find a podcast where particular words were spoken), simple data entry (e.g., entering a credit card number), preparation of structured documents (e.g. a radiology report), determining speaker characteristics,[2] speech-to-text processing (e.g., word processors or emails), and aircraft (usually termed direct voice input).

The term voice recognition or speaker identification refers to identifying the speaker, rather than what they are saying. Recognizing the speaker can simplify the task of translating speech in systems that have been trained on a specific person's voice or it can be used to authenticate or verify the identity of a speaker as part of a security process.</p>
</div>
<hr>
<h3 align="center">ADVANTAGE</h3>
<p style="text-align:center !important;">Transcribe Your voice to 120 Different Languages.</p>
<p style="text-align:center !important;">Faster Results.</p><p style="text-align:center !important;">First Web Application.</p><p style="text-align:center !important;">Accurate results.</p>
<p style="text-align:center !important;">Save To GOOGLE-Drive.</p>
<hr>
<div class="container">
<div id="contact">
  <div style="text-align:center">
    <h2>Contact Us</h2>
    <p style="text-align:center;">Swing by for a cup of coffee, or leave us a message:</p>
  </div>
    <div class="column" >
      <form action="send_faq.php" method="post">
        <label for="fname"><h3>First Name</h3></label>
        <input style="  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
"  type="text"  name="names" id="names" placeholder="Your name.." required>
        <label for="lname"><h3>MobileNo</h3></label>
        <input style="  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
"type="text" name="ms" id="ms" placeholder="Your Mobile ..."required>
        <label for="subject"><h3>Subject</h3></label>
        <textarea  style="  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
"id="subject" name="subject" placeholder="Write something.." style="height:170px" required></textarea>
        <input style=" background-color: #4CAF50 !important;
  color: white !important;
  padding: 12px 20px !important;
  border: none !important;
  cursor: pointer !important;" name="send-send" type="submit"  value="Submit">
      </form>
    </div>
  </div>
  </div>
</div>
<hr>
<style>
p {
  font-family: sans-serif;
  padding: 0 20px;
  font-size: 20px;
   font-weight: bold;
   color: #fff;
   text-align:justify;
}
 
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
.alert1 {
    padding: 20px;
    background-color: green;
    color: white;
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
</style>
<?php
						if(isset($_GET["send-sucess"]))
						{
						?>
						<script>alert("sucessfully sent");</script>
<?php
}
?>
<?php
						if(isset($_GET["send-error"]))
						{
						?>
						<script>alert("Try again after sometime");</script>
<?php
}
?>

<?php
						if(isset($_GET["error-login"]))
						{
						?>
				<script>alert("Error!Invalid username & password.");</script>
<?php
}
?>

<?php
						if(isset($_GET["error"]))
						{
						?>
  <script>alert("Error! some error occured.");</script>
<?php
}
?>
	<?php
						if(isset($_GET["success"]))
						{
						?>
					<script>alert("Success!Successfully registered login.");</script>
<?php
}
?>

<div id="id02" class="modal">
  <form class="modal-content" action="insert.php" method="post">
    <div class="container" id="sg" style="overflow:auto;">
	  <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
	  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close">&times;</span>
  
      <div class="row">	
	<div class="col-sm">
	  <label for="fullname"><b>Full Name</b></label>
      <input type="text" placeholder="Enter Your Name" id="fname" name="fname" required>
	  </div>
	  <div class="col-sm">
	  <label for="uname"><b>Username</b></label>
        <input type="text" id="uname" placeholder="Enter Username" name="uname" required>
<br><span id="name_status" style="color:red;display:none;"align="centre"></span>
</div>
	  
<div class="col-sm">
      <label for="email"><b>Email</b></label>
      <input type="email" id="e-mail" placeholder="Enter Email" name="email" required>
    </div>
	
</div>

<div class="row">
	
	<div class="col-sm">
	<label for="mobile"><b>MobileNo</b></label>
 <input type="text" id="mobile" placeholder="Enter Mobileno" name="mobile" required>
</div>
<div class="col-sm">
	   <label for="psw-1"><b>Password</b></label>
      <input type="password" id="psw-1" placeholder="Enter Password" name="psw" required>
</div>
<div class="col-sm">
      <label for="psw-repeat"><b>confirm Password</b></label>
      <input type="password" id="psw-2" placeholder="Repeat Password" name="psw-repeat" required disabled>
		</div>
</div>
		<p style="font-size:15px!important;"><ins>password must contain one uppercase,lower case,nos and greater than 8 characters</ins></p>
	 <span id="email_status" style="color:red;display:none";></span>
<span id="mobile_status" style="color:red;display:none;"></span>

	 <input type="checkbox" id="cfname">FullName
 <input type="checkbox" id="cuname" >Username
  <input type="checkbox" id="cemail">Email
   <input type="checkbox" id="cmobile">MobileNo
    <input type="checkbox" id="cpassword">Password
	 <input type="checkbox" id="cpassword-re">Password
 <br>
      <label>
        <input type="checkbox" id="terms"  onClick="check_valid()" name="remember"  style="margin-bottom:15px" required> By creating an account you agree to our <a href="#" style="color:white">Terms & Privacy</a>
      </label>
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" name="submit" id="signup" onClick="check_valid()" class="signupbtn" >Sign Up</button>
	  </div>
    </div>
  </form>
<script>
document.getElementById('sg').style.backgroundImage = "url('images/bg/bgsignup.gif')";
</script>
  </div>

  
  <!-- Modal -->
  <div class="modal" style="display:none" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" align="center">Reset Password</h3>
        </div>
        <div class="modal-body" align="center">
          <form>
		  <input type="text" id="resetpsw-1" placeholder="Enter your Registered E-mail Address">
		  <div id="pross" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
  <img src="images/load/loader.gif" width="64" height="64"  />
</div>
<br>
		  <span id="status" style="color:red; font-weight: bold;" ></span>
								</form>
</div>

        <div class="modal-footer" align="center">
          <button type="button"  style="color: #fefefe;
    background-color: #2e50ea;
	width:10%;
	padding-left: 20px;
	padding:12px 6px;
    border-color: #ccc;"  onclick="$('#myModal').hide();">Close</button>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript" src="js/login.js"></script> 
<footer>
<div class="jumbotron text-center" style="margin-bottom:0">
<h3 class="write"><i class="fa fa-microphone "></i> Designed and Developed by PSG Ptc..&copy;</h3>
 </div>
</footer>
</body>
</html>
                                                                                                                                                      