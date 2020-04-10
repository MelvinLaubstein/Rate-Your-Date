<!DOCTYPE html>

<html>
  <head>
	<title> My Account </title>
	<meta charset="UTF-8">
  	<link rel="stylesheet" type="text/css" href="CSS/My_Account_Rate_My_Date.css">
  </head>
    
	<body>
		<!-- This is the div for the header -->
		<div id="header">
		  <center>
			<h1> Rate My Date </h1>
		  </center>
		</div>
		 <!-- This is the div for the nav bar -->
		<div id="nav">
			<center>
				<b id="Username_Welcome"> Welcome, <?php session_start(); echo $_SESSION['username']; ?>
				<a href="Homepage_Rate_My_Date.php" class="nav_link">Home</a> |
				<a href="My_Account_Rate_My_Date.php" class="nav_link">My Account</a> |
				<a href="Search_Rate_My_Date.php" class="nav_link"> Search For Dated People </a> |
				<a href="Add_Your_Date_Rate_My_Date.php" class="nav_link"> Add Your Date </a> |
				<a href="Logout_Rate_My_Date.php" class="nav_link">Log Out</a>
			</center>
		</div>
		 <!-- This is the div for the body of account info-->
		<div id="Info">
			<center>
			  <h3 id="accountheader"> Account Info </h3>
			</center>
			
			<center>
				<form enctype='multipart/form-data' action='My_Account_Rate_My_Date.php' method='post'>
				
				<?php
					$servername = 'localhost';
					$username = 'root';
					$password = 'password';
					$dbname = 'mydb';
					$conn = new mysqli($servername, $username, $password, $dbname);
					$loggedInUser = $_SESSION['username'];
					
					$checkRater = mysqli_query($conn, "SELECT * from RATER where RATER_USERNAME='$loggedInUser'");
					$checkAdministrator = mysqli_query($conn, "SELECT * from ADMINISTRATOR where ADMINISTRATOR_USERNAME='$loggedInUser'");
					if (mysqli_num_rows($checkRater) > 0) {
						while($data = mysqli_fetch_assoc($checkRater)) {
							echo "<b> Your Profile Picture </b> <br>";
							echo '<img width="200px" height="200px" src="data:image/png;base64,' . $data['RATER_PROFILE_PICTURE'] . '" />';
							echo "<br>";
							echo "<input id='picture' name='picture' type='file'>";
							echo ("<input type='submit' name='picturetureSubmit' id='picturetureSubmit' value='Change Profile pictureture (Select a File First)'>");
							echo "<br><br><br>";
							echo ("Username: " . $loggedInUser);
							echo "<br><br>";
							echo "Old Password: " . "<input type='password' name='oldPassword' id='oldPassword'>" . " " . " New Password: " . "<input type='password' id='newPassword' name='newPassword'>" . " " . "<input type='submit' id='passwordSubmit' name='passwordSubmit' value='Change Password'>";
							echo "<br><br>";
							echo "Current Email Address: " . $data['RATER_EMAIL_ADDRESS'] . " <br><br> " . " New Email Address: " . "<input type='email' name='newEmail' id='newEmail'>" . "<input type='submit' id='emailSubmit' name='emailSubmit' value='Change Email Address'><br><br>";
							echo "Current Phone Number: " . "(" . $data['RATER_AREA_CODE'] . ")" . " " . $data['RATER_PHONE_NUMBER'] . "<br><br>";
							echo "Updated Phone Number: <input type='text' maxlength='3' minlength='3' id='areacode' name='areacode' placeholder='area code'> " . " " . "<input type='text' id='phone' name='phone' maxlength='7' minlength='7' placeholder='phone number'>" . "<input type='submit' name='phonesubmit' id='phonesubmit'>";
						
							if (isset($_POST['picturetureSubmit'])) {
							  if (isset($_FILES['picture']['name'])) {
								$picture = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
								mysqli_query($conn, "UPDATE RATER SET RATER_PROFILE_PICTURE='$picture' where RATER_USERNAME='$loggedInUser'");
								echo "<script> window.location.href='My_Account_Rate_My_Date.php' </script>"; 	
							  }
							} 
						
							if (isset($_POST['emailSubmit'])) {
								$newEmail = $_POST['newEmail'];
								mysqli_query($conn, "UPDATE RATER SET RATER_EMAIL_ADDRESS='$newEmail' where RATER_USERNAME='$loggedInUser'");
								echo "<script> alert('Your email address was successfully updated!'); </script>";
								echo "<script> window.location.href='My_Account_Rate_My_Date.php' </script>"; 				
							}
							
							if (isset($_POST['passwordSubmit'])) {
								if (($_POST['oldPassword'] == $data['RATER_PASSWORD'])) {
									$newPassword = $_POST['newPassword'];
									mysqli_query($conn, "UPDATE RATER SET RATER_PASSWORD='$newPassword' where RATER_USERNAME='$loggedInUser'");
									echo "<script> alert('Your password has been updated!'); </script>";
									echo "<script> window.location.href='My_Account_Rate_My_Date.php'</script>";
								} else {
									echo "<script> alert('Your input for your old (Current) password is incorrect!') </script>";
								}
							}
							
								if (isset($_POST['phonesubmit'])) {
									$newAreaCode = $_POST['areacode'];
									$newPhone = $_POST['phone'];
									mysqli_query($conn, "UPDATE RATER SET RATER_AREA_CODE='$newAreaCode' where RATER_USERNAME='$loggedInUser'");
									mysqli_query($conn, "UPDATE RATER SET RATER_PHONE_NUMBER='$newPhone' where RATER_USERNAME='$loggedInUser'");
									echo "<script> alert('Your phone number has been updated!'); </script>";
									echo "<script> window.location.href='My_Account_Rate_My_Date.php'</script>";
							}
							
							}
								echo "</form>";
						} else if (mysqli_num_rows($checkAdministrator) > 0) {
							while($data = mysqli_fetch_assoc($checkAdministrator)) {
							echo "<b> Your Profile Picture </b> <br>";
							echo '<img width="200px" height="200px" src="data:image/png;base64,' . $data['ADMINISTRATOR_PROFILE_PICTURE'] . '" />';
							echo "<br>";
							echo "<input id='picture1' name='picture1' type='file'>";
							echo ("<input type='submit' name='picturetureSubmit1' id='picturetureSubmit1' value='Change Profile pictureture (Select a File First)'>");
							echo "<br><br><br>";
							echo ("Username: " . $loggedInUser);
							echo "<br><br>";
							echo "Old Password: " . "<input type='password' name='oldPassword1' id='oldPassword1'>" . " " . " New Password: " . "<input type='password' id='newPassword1' name='newPassword1'>" . " " . "<input type='submit' id='passwordSubmit1' name='passwordSubmit1' value='Change Password'>";
							echo "<br><br>";
							echo "Current Email Address: " . $data['ADMINISTRATOR_EMAIL_ADDRESS'] . " <br><br> " . " New Email Address: " . "<input type='email' name='newEmail1' id='newEmail1'>" . "<input type='submit' id='emailSubmit1' name='emailSubmit1' value='Change Email Address'><br><br>";
							echo "Current Phone Number: " . "(" . $data['ADMINISTRATOR_AREA_CODE'] . ")" . " " . $data['ADMINISTRATOR_PHONE_NUMBER'] . "<br><br>";
							echo "Updated Phone Number: <input type='text' maxlength='3' minlength='3' id='areacode1' name='areacode1' placeholder='area code'> " . " " . "<input type='text' id='phone1' name='phone1' maxlength='7' minlength='7' placeholder='phone number'>" . "<input type='submit' name='phonesubmit1' id='phonesubmit1'>";
						
							if (isset($_POST['picturetureSubmit1'])) {
							  if (isset($_FILES['picture1']['name'])) {
								$picture1 = base64_encode(file_get_contents($_FILES['picture1']['tmp_name']));
								mysqli_query($conn, "UPDATE ADMINISTRATOR SET ADMINISTRATOR_PROFILE_PICTURE='$picture1' where ADMINISTRATOR_USERNAME='$loggedInUser'");
								echo "<script> window.location.href='My_Account_Rate_My_Date.php' </script>"; 	
							  } 
							} 
						
							if (isset($_POST['emailSubmit1'])) {
								$newEmail1 = $_POST['newEmail1'];
								mysqli_query($conn, "UPDATE ADMINISTRATOR SET ADMINISTRATOR_EMAIL_ADDRESS='$newEmail1' where ADMINISTRATOR_USERNAME='$loggedInUser'");
								echo "<script> alert('Your email address was successfully updated!'); </script>";
								echo "<script> window.location.href='My_Account_Rate_My_Date.php' </script>"; 				
							}
							
							if (isset($_POST['passwordSubmit1'])) {
								if (($_POST['oldPassword1'] == $data['ADMINISTRATOR_PASSWORD'])) {
									$newPassword1 = $_POST['newPassword1'];
									mysqli_query($conn, "UPDATE ADMINISTRATOR SET ADMINISTRATOR_PASSWORD='$newPassword1' where ADMINISTRATOR_USERNAME='$loggedInUser'");
									echo "<script> alert('Your password has been updated!'); </script>";
									echo "<script> window.location.href='My_Account_Rate_My_Date.php'</script>";
								} else {
									echo "<script> alert('Your input for your old (Current) password is incorrect!') </script>";
								}
							}
							
							if (isset($_POST['phonesubmit1'])) {
								$newAreaCode1 = $_POST['areacode1'];
								$newPhone1 = $_POST['phone1'];
								mysqli_query($conn, "UPDATE ADMINISTRATOR SET ADMINISTRATOR_AREA_CODE='$newAreaCode1' where ADMINISTRATOR_USERNAME='$loggedInUser'");
								mysqli_query($conn, "UPDATE ADMINISTRATOR SET ADMINISTRATOR_PHONE_NUMBER='$newPhone1' where ADMINISTRATOR_USERNAME='$loggedInUser'");
									echo "<script> alert('Your phone number has been updated!'); </script>";
									echo "<script> window.location.href='My_Account_Rate_My_Date.php'</script>";
							}
							
							}
								echo "</form>";
						}
					?>
			
			</center>
		</div>
	</body>
</html>
