
<?php

if(isset($_POST["btnLogin"]))
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	$valid = false;
	
//db connection
	$con = mysqli_connect("localhost","root","","customer_website");
	
	if(!$con)
	{
		die("Cannot connect to DB server");
	}
	
	$sql = "select * from usertable where email='".$email."' && password='".$password."'";
	
	$result = mysqli_query($con, $sql);
	
	if(mysqli_num_rows($result) > 0)
	{
	//if()
		$valid = true;
	}
	else
	{
		$valid = false;
	}
	if($valid)
	{
		$_SESSION["email"] = $email;
		echo '<script>alert("You are logged in successfully")</script>';
		header('Location:ProductView.html');
	}
	else
	{
		echo '<script>alert("Please enter correct email and password")</script>';
		header("refresh:1; url=loginNew.html");
	}

}
?>

