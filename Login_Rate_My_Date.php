<?php
session_start();
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "mydb";
	$conn = new mysqli($servername, $username, $password, $dbname);

	$username = $_POST["username"];
	$password = $_POST["password"];
	$_SESSION['username'] = $username;
if (isset($_POST['admin'])) {
	$sql = "SELECT * from administrator WHERE (administrator_username='$username' AND administrator_password='$password')";
	$check = mysqli_query($conn, $sql);
	if (mysqli_num_rows($check) >= 1) {
		header("location: Homepage_Rate_My_Date.php");
	} else {
		echo "<script> alert('Login Failed!'); window.location.href='Login_Rate_My_Date.html' </script>"; 
	}
}

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
