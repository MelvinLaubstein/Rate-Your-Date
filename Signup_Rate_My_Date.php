<?php
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "mydb";
	$conn = new mysqli($servername, $username, $password, $dbname);

	$username = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$prof = $_POST["profile_picture"];
	$dob = $_POST["DOB"];
	$area = $_POST["area"];
	$phone = $_POST["phone"];
	$_SESSION['username'] = $username;
	
	$sql = "SELECT * from rater WHERE (rater_username='$username')";
	$sql2 = "SELECT * from administrator WHERE (administrator_username='$username')";
	$check = mysqli_query($conn, $sql);
	$check2 = mysqli_query($conn, $sql2);
	if (mysqli_num_rows($check) >= 1 OR mysqli_num_rows($check2) >= 1) {
		echo "<script> alert('That username is taken!'); window.location.href='Login_Rate_My_Date.html' </script>"; 
	} else {
		$adduser = "insert into rater (`rater_username`, `rater_password`, `rater_profile_picture`,`rater_email_address`, `rater_dob`, `rater_areacode`, `rater_phone_number`) VALUES 
		('$username', '$password', '$prof', '$email', '$dob', '$area', '$phone')";
		mysqli_query($conn, $adduser);
		echo "<script> alert('Signup was successful. Now, please login.'); 
		window.location.href='Login_Rate_My_Date.html' </script>"; 
	}

?>
