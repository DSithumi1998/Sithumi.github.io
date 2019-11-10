<?php
	
	$con = mysqli_connect('localhost','root','');
	
	if(!$con)
	{
		echo 'Not connected to server';
	}
	if(!mysqli_select_db($con,'customer_website'))
	{
		echo 'database not selected';
	}
	
	$name = $_POST['user'];
	$address = $_POST['address'];
	$cno = $_POST['cno'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	
	$sql = "INSERT INTO usertable (name,address,cno,email,password,cpassword) VALUES ('$name', '$address', '$cno', '$email', '$password','$cpassword')";
	
	if(!mysqli_query($con,$sql))
	{
		echo 'Not inserted';
	}
	else
	{
		echo 'Inserted';
	}
	
	header("refresh:1; url=registrationNew.html");


?>