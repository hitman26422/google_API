<?php  
include('session.php'); // Includes Login Script
?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<?php
if(isset($_POST['otp_submit']))
{
	$otp_check=$_POST['otp'];
	require_once 'sql.php';
	$result=mysqli_query($con,"select otp from otp_expiry where is_expired!=1 AND otp='$otp_check' AND NOW()<= DATE_ADD(created_at, INTERVAL 5 MINUTE)");
	if (mysqli_num_rows($result)==0) 
	{
		
	header("location: edit_profile.php?error_1=1");
	}
	else
	{
	require_once 'sql.php';
	$result=mysqli_query($con,"update login set verify=1 where username='$login_session'");
$result1=mysqli_query($con,"update otp_expiry set is_expired=1 where otp='$otp_check'");
	if($result)
	{
		require_once 'sql.php';
		$result2=mysqli_query($con,"update otp_expiry set is_expired=1 where NOW()<= DATE_ADD(created_at, INTERVAL 5 MINUTE)");
$result1=mysqli_query($con,"insert into notification  VALUES('$login_session','NULL','Verified Mobile No',NOW(),0)");
		header("location: edit_profile.php?success=1");	
	}	
	}
}
?>
<script>
$(document).ready(function(){

  $(document).ajaxStart(function(){
		$("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
		               $("#wait").css("display", "none");
	});
	$("#otp_submit").submit(function()
			{
		        $("#otp_submit_1").load("edit_profile.php");
    });
	
});
function getOtp(mobile) 
{
    $('#pross').show();
	         $.ajax({
            url: 'Otp.php',
            type: 'post',
           data: {
   mobile_no:mobile,
  },
             success: function(response){
                if(response != 0)
				{
					var modal = document.getElementById('myModal');	// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var btn = document.getElementById("verify");

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}		//or have your javascript here

}
				   else{
					   $('#pross').hide();
               alert("Try again Later");
			   }
            },
        });
$('#pross').hide();
}
function checkFileDuration() 
{
  var file = document.querySelector('input[type=file]' ).files[0];
  var reader = new FileReader();
  var fileSize = file.size;
  var uploadMax=2000000;

  if (fileSize > uploadMax) 
  {
    alert('file too large');
    $('#file').val("");
  } 
  else 
  {
    $('#pross').show();
   
		console.log("hi");
	  if (file.type == "image/jpeg"||file.type == "image/jpg") 
	  {
		   var fd = new FormData();
		    var files = $('#file')[0].files[0];
             fd.append('file',files);
         $.ajax({
            url: 'update_profile.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0)
				{
                   alert("uploaded");
				   location.reload();
				 }
				   else{
                    alert('file not uploaded');
                }
            },
        });
    }
	else
	{
				alert("file is not in jpg");
	}
            $('#pross').hide();
	
  }
}
</script>
<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #4e53ca;
  margin: auto;
  padding: 20px;
  border: 1px solid #6d3d3d;
  width: 80%;

}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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

.alert2 {
    padding: 20px;
    background-color: red;
    color: white;
}

</style>

<div class="container">
<?php
						if(isset($_GET["success"]))
						{
						?>
						<div class="alert1">
  <a href="home.php"><span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span></a> 
  <strong>Success!</strong> Successfully Updated.
</div>
<?php
}
?>

<?php
						if(isset($_GET["error"]))
						{
						?>
						<div class="alert2" >
  <a href="home.php"><span class="closebtn" onclick="this.parentElement.style.display='none';" >&times;</span></a> 
  <strong>Error!</strong> some error occured.
</div>
<?php
}
?>
<?php
						if(isset($_GET["error_1"]))
						{
						?>
						<div class="alert2" >
  <a href="home.php"><span class="closebtn" onclick="this.parentElement.style.display='none';" >&times;</span></a> 
  <strong>Error!</strong> Invalid OTP or OTP expired.
</div>
<?php
}
?>

    <h1>Edit Profile</h1>
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="profilepic/<?php echo $login_session;?>/<?php echo $login_session;?>.jpg" class="avatar img-circle" alt="avatar" height="100" width="100">
          <h6>Upload a different photo... in jpg format only</h6>
          
          <input type="file" id="file" onchange="checkFileDuration()" class="form-control">
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          <strong>Update changes.</strong>.  
		  </div>
        <h3>Personal info</h3>
        
		<?php
		require_once 'sql.php';
		$result=mysqli_query($con,"select full_name,password,mobile,verify from login where username='$login_session'");
		while($row=mysqli_fetch_array($result))//while look to fetch the result and store in a array $row.  
        {  
			$fullname=$row[0];  
            $password=$row[1];  
            $mobile=$row[2];  
			$verify=$row[3];  
  	}
		?>
        <form class="form-horizontal" action="update.php"  method="post">
          <div class="form-group">
            <label class="col-lg-3 control-label">Name</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="<?php echo $fullname;?>" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Mobile:</label>
            <div class="col-lg-8">
              <input class="form-control" id="mobile" type="text" value="<?php echo $mobile;?>" disabled> 
<?php 
if($verify==0)
{
	?>
			  <br>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
            &#160;&#160;&#160;&#160;<button type="button" name="verify" id="verify" class="btn btn-primary" onclick="getOtp(<?php echo $mobile;?>)">Verify Mobile</button>
<?php
}
?>	
	</div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-8">
              <input class="form-control" id="uname" name="username" type="text" value="<?php echo $login_session;?>" required>
            <span id="name_status" ></span>
			  <br>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
            &#160;&#160;&#160;&#160;<button type="submit" name="udad" id="udad" class="btn btn-primary" disabled>Change</button>			
			</div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" name="psw-1" id="psw-1" type="password" value="<?php echo $password;?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" placeholder="Enter a new or old Password" id="psw-2" type="password" value="" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <button type="submit" Onclick="check_valid()" name="submit" class="btn btn-primary" >Save Changes</button>
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
		<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" >
    <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
    <form id="otp_submit_1" method="post" role="form" action="edit_profile.php">
	<div class="form-group" style="padding-top: 50px;" align="center">
<h3> VERIFICATION PANEL</h3>         
<br>
		 <div class="col-md-8">
       <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP Send To Your Mobile <?php echo $mobile;?>">
<br>	 
	 <button type="submit" class="btn btn-default" name="otp_submit">Submit</button>
		</form> 
		<p id="demo" style=" text-align: center;
  font-size: 60px;
  margin-top: 0px;"></p>
  	 </div>
          </div>
          
	</div>

</div>

		<script>


// Set the date we're counting down to
var dt = new Date();
 dt.setMinutes( dt.getMinutes() + 5 );

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = dt - now;
    
  // Time calculations for days, hours, minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
location.reload(); 	
}
}, 1000);


var myInput = document.getElementById("psw-1");
var myInput1 = document.getElementById("psw-2");
var myInput3= document.getElementById("uname");

function check_valid()
{
	color2=document.getElementById("psw-1").style.borderColor;
    color3=document.getElementById("psw-2").style.borderColor;
	if((color2=="green")&&(color3=="green"))
{
	if(myInput.value==myInput1.value)
	{

	}
	else
	{
	alert("password doesnt match");
	}
}
else
{
	alert("please fill the password with one uppercase lowercase numbers and minimum 8 characters");
}
}

myInput1.onkeyup = function() {
var c_pas = document.getElementById("psw-1").value;  
if(myInput1.value.match(c_pas))
{
document.getElementById("psw-2").style.borderColor = "green"; 
// this adds the error class
}
 else 
	{
		document.getElementById("psw-2").style.borderColor = "red"; // this adds the error class
    }

}
// When the user starts to type something inside the password field
myInput.onkeyup = function() {
   
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  // Validate numbers
  var numbers = /[0-9]/g;
  
   if((myInput.value.length >= 8)&&(myInput.value.match(lowerCaseLetters))&&(myInput.value.match(upperCaseLetters))&&(myInput.value.match(numbers)))
  {
document.getElementById("psw-1").style.borderColor = "green"; // this adds the error class  

  document.getElementById("psw-2").disabled =false;
  }
  else 
	{
		document.getElementById("psw-2").disabled =true;
		document.getElementById("psw-1").style.borderColor = "red"; // this adds the error class
    }
  
}

myInput3.onkeyup = function() {

 var name=document.getElementById( "uname" ).value;
	 var numbers = /[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g;
 if(!(myInput3.value.match(numbers)))
 {
if(name)
 {
  $.ajax({
  type: 'post',
  url: 'check.php',
  data: {
   user_name:name,
  },
  success: function (response) {	
 $( '#name_status' ).html(response);
   if(response=="OK<br>")	
   {
	document.getElementById("uname").style.borderColor = "green"; // this adds the error class
document.getElementById("udad").disabled=false;
	return true;	
   }
   else
   {
	   document.getElementById("udad").disabled=true;
		document.getElementById("uname").style.borderColor = "red"; // this adds the error class
 
 return false;	
   }
  }
  });
 

 }
 else
 {
	 document.getElementById("udad").disabled=true;
		document.getElementById("uname").style.borderColor = "red"; // this adds the error class 
 $( '#name_status' ).html("");
  return false;
 }
 }
 else
 {
	 document.getElementById("udad").disabled=true;
		document.getElementById("uname").style.borderColor = "red"; // this adds the error class 
 $( '#name_status' ).html("");
 }
}
		</script>
		<div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
<img src='images/load/demo.gif' width="64" height="64" />
<br>Loading..</div>

<div id="pross" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
  <img src="images/load/loader.gif" width="64" height="64"  />
</div>	 
 </div>
  </div>
</div>
<hr>