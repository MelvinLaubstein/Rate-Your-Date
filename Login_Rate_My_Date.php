<?php
/* Connects to database and starts session */
session_start();
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "mydb";
	$conn = new mysqli($servername, $username, $password, $dbname);

/* Grabs username and password from the login form, setting them to PHP variables */
	$username = $_POST["username"];
	$password = $_POST["password"];
/* Sets a session variable to whatever the newly logged-in user username's might be */
	$_SESSION['username'] = $username;
	
/* Checks within the administrator table for a matching username + password combination based on the username + password combination that the user typed into the form.
If a match is found, then log them in and send them to the homepage. */
if (isset($_POST['admin'])) {
	$sql = "SELECT * from administrator WHERE (administrator_username='$username' AND administrator_password='$password')";
	$check = mysqli_query($conn, $sql);
	if (mysqli_num_rows($check) >= 1) {
		header("location: Homepage_Rate_My_Date.php");
	} else {
		echo "<script> alert('Login Failed!'); window.location.href='Login_Rate_My_Date.html' </script>"; 
	}
}
/* Checks within the rater table for a matching username + password combination based on the username + password combination that the user typed into the form.
If a match is found, then log them in and send them to the homepage. */
if (isset($_POST['rater'])) {
	$sql = "SELECT * from rater WHERE (rater_username='$username' AND rater_password='$password')";
	$check = mysqli_query($conn, $sql);
	if (mysqli_num_rows($check) >= 1) {
		header("location: Homepage_Rate_My_Date.php");
	} else {
		echo "<script> alert('Login Failed!'); window.location.href='Login_Rate_My_Date.html' </script>"; 
	}
}
?>
