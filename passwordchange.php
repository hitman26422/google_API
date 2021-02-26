<?php
if(isset($_GET['token']))
{
require_once 'sql.php';
$ticket=$_GET['token'];
	$result=mysqli_query($con,"select token from login where token='$ticket' AND NOW() <= DATE_ADD(created_token, INTERVAL 5 MINUTE) ");
	if (mysqli_num_rows($result)==0) 
	{ 
		?>
	<h1 align="center">Session Expired</h1>
<?php
	}
	else 
	{
	?>
	<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<style>
 .form-gap {
    padding-top: 70px;
}
</style>
 <div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-4" style="padding-left:300px">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Reset Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
    
                    <form id="register-form" role="form" action="reset-psw.php" autocomplete="off" class="form" method="post">
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="password" name="Password" placeholder="Password" class="form-control"  type="password" required>
                        </div>
                      </div>
					   <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="password-re" name="Password-re" placeholder="Password-reenter" class="form-control"  type="password" required disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" id="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit"  disabled>
                      </div>
                      
                      <input type="hidden" class="hide" name="token" id="token" value="<?php echo $ticket;?>" > 
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>
<script>
var myInput = document.getElementById("password");
var myInput1 = document.getElementById("password-re");
myInput1.onkeyup = function() {
var c_pas = document.getElementById("password").value;  
if(myInput1.value.match(c_pas))
{
document.getElementById("password-re").style.borderColor = "green"; // this adds the error class
document.getElementById("recover-submit").disabled =false;
}
 else 
	{
		document.getElementById("recover-submit").disabled =true;
		document.getElementById("password-re").style.borderColor = "red"; // this adds the error class
    }

}
myInput.onkeyup = function() {
   
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  // Validate numbers
  var numbers = /[0-9]/g;
  
   if((myInput.value.length >= 8)&&(myInput.value.match(lowerCaseLetters))&&(myInput.value.match(upperCaseLetters))&&(myInput.value.match(numbers)))
  {
document.getElementById("password").style.borderColor = "green"; // this adds the error class  
  document.getElementById("password-re").disabled =false;
  }
  else 
	{
		document.getElementById("password-re").disabled =true;
		document.getElementById("password").style.borderColor = "red"; // this adds the error class
    }
  
}



</script>
<?php
	}
}
else
{
	?>
	<h1 align="center">Session Expired</h1>
<?php
}
?>