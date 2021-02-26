<?php
include('session.php');
?>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
.marquee {
  position: relative;
  animation: marquee 2s linear infinite;
  text-align:center;
  color:#ffffff;
}
@keyframes marquee {
  0% {
    top: 10em
  }
  100% {
    top: -2em
  }
}
</style>
</head>
<body>

<h2 style="text-align:center">User Profile Card</h2>

<div class="card">
<img  src="profilepic/<?php echo $login_session;?>/<?php echo $login_session;?>.jpg" class="avatar img-circle" alt="avatar" style="width:100%">
  <h1><?php echo  $login_session;?></h1>
 <marquee behaviour='scroll' scrollamount='3' height='100' bgcolor='red' vspace='20' direction='up'>
  <?php
  require_once'sql.php';
  $reset=mysqli_query($con,"select message,created_time  from notification where for_name='$login_session' AND is_read!=1");   
	    $not_no=mysqli_num_rows($reset);
		  while ($row =mysqli_fetch_array($reset))
	{
        $message= $row['message'];
        $time= $row['created_time'];
echo " <font color='white'>".$message.$time."</font>";
	}
	?>
	</marquee>
  <p>Activities</p>
  <div style="margin: 24px 0;">
    <a href="#"><i class="fa fa-dribbble"></i></a> 
    <a href="#"><i class="fa fa-twitter"></i></a>  
    <a href="#"><i class="fa fa-linkedin"></i></a>  
    <a href="#"><i class="fa fa-facebook"></i></a> 
  </div>
  <p><button>Contact</button></p>
</div>

</body>
</html>
