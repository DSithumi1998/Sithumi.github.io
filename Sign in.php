<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign in</title>
	<link rel="stylesheet" type="text/css" href="css/Signinstyle.css">
    <link rel="stylesheet" href="Style1.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="HomePageStyles.css" />
 
	
</head>

<body>

<header>
    	<div class="main">
        	<div class="logo">
            <img src="logo3.png"/>
        	<ul>
           	  	<li><a href="Homepage.html">Home</a></li>
                <li class="active"><a href="LogIn.php">LogIn</a></li>
                <li><a href="registration.php">SignUp</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="index.php">Find Us</a></li>
            </ul>
        </div>
        </div>
        </header>
	
	<div class="loginbox">
		<h1>Login</h1>
		
	<form name="form1" action="" method="post" >
		<p>Username</p>
		<input type="text" placeholder="Username" name="txtusername" id="txtusername" required>
		
		<p>Password</p>
		<input type="password" placeholder="Password" name="pwdpassword" id="pwdpassword" required>
		
		<input type="submit" name="btnlogin" id="btnlogin" value="Sign In" class="signinbtn" /> 
		
		<p>Admin Login</p><input type="checkbox" name="chkadmin" id="chkadmin"/>
		<br>
		<a href="Create Account.php" target="_top">Don't have an account</a>

	</div>
		</form>
		
		
		<!--user-->
	<?php
	   if(isset($_POST["btnlogin"]))
	   {
	      $userName=$_POST["txtusername"];
	      $password=$_POST["pwdpassword"];
		  $valid=false;
		  
		  $con = mysqli_connect("localhost","root","","heartsease");
		   if(!$con)
			{	
				die("Cannot connect to DB server");		
			}
			
			$sql="SELECT * FROM `user` WHERE `Email`='".$userName."' and `Password`='".$password."'";
			
			$result = mysqli_query($con,$sql);
		  
		  
		  if(mysqli_num_rows($result) >0)
		{
		  
		  
		 // if(($userName=="test@gmail.com") && ($password=="test@123"))
		 // {
			  $valid=true;
		  }
		  else
		  {
			  $valid=false;
		  }
		  
		   
		   
		  if($valid)
		  {
			  $_SESSION["username"] =$userName;
			  header('Location:view.php');
		  }
		  
		  else
		  {
			  echo("Please enter valid username and password") ;
		  }
	   }
	   ?>
		
		
</body>
	
	
</html>
