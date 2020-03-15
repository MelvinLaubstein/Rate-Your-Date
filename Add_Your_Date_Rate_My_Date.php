<?php 
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "mydb";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$test = "INSERT INTO `ratee` (`RATEE_OVERALL_SCORE`, `RATEE_PERSONAL_PICTURE`) VALUES (23.32, 3)";
	mysqli_query($conn, $test);
	mysqli_close($conn);
?>