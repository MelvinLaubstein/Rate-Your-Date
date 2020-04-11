<!DOCTYPE html>

<html>
  <head>
	<title> Search </title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/Search_Rate_My_Date.css">
  </head>

  <body>
    <!-- This is the div for the header -->
    <div id="header">
      <center>
        <h1> Rate My Date </h1>
      </center>
    </div>
	
	<div id="nav">
		<center>
		<span id="Username_Welcome"> <b> Welcome, <?php session_start(); echo $_SESSION['username']; ?> </b> </span>
		<a href="Homepage_Rate_My_Date.php" class="nav_link">Home</a> |
		<a href="My_Account_Rate_My_Date.php" class="nav_link">My Account</a> |
		<a href="Search_Rate_My_Date.php" class="nav_link"> Search For Dated People </a> |
		<a href="Add_Your_Date_Rate_My_Date.php" class="nav_link"> Add Your Date </a> |
		<a href="Logout_Rate_My_Date.php" class="nav_link">Log Out</a>
		</center>
	</div>

    <!-- This is the div for the search bar -->
    
      <div id="search">
        <center>
            <form method="post" action="Search_Rate_My_Date.php">
				<h2> Search for people you may know </h2>
				First Name: <input type="text" name="firstname" id="firstname" value=""> 
				Last Name: <input type="text" name="lastname" id="lastname"> 
				Their State (initials): <input type="text" name="state" id="state" maxlength="2" size="2"> 
				Their year of birth: <input type="text" name="birthyear" id="birthyear" maxlength="4" size="4">
				<input type="submit" id="SearchPageSubmit" name="SearchPageSubmit" value="Submit">
			</form>
        </center>
      </div> 

<?php
		$servername = "localhost";
		$username = "root";
		$password = "password";
		$dbname = "mydb";
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		if (isset($_POST['firstname'])) {
			$firstName = $_POST['firstname'];
		} else {
			$firstName = NULL;
		}
		
		if (isset($_POST['lastname'])) {
			$lastName = $_POST['lastname'];
		} else {
			$lastName = NULL;
		}
		
		if (isset($_POST['state'])) {
			$state = $_POST['state'];
		} else {
			$state = NULL;
		}
		
		if (isset($_POST['birthyear'])) {
			$birthyear = $_POST['birthyear'];
		} else {
			$birthyear = NULL;
		}
	if(isset($_POST['SearchPageSubmit'])) {
		if ($firstName != null && $lastName != null && $state != null && $birthyear != null) {
			echo "<br><br><br><br><br><br>";
			echo "<table id='searchTable'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_firstname like '$firstName%') OR (ratee_lastname like '$lastName%') OR (ratee_state='$state') OR (ratee_birthyear='$birthyear'))  
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id");
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {
					if ($data['COMMENTS_TEXT'] == " ") {
						$Text = "No COMMENTS by this user.";
					} else {
						$Text = $data['COMMENTS_TEXT'];
					}
					
					echo "<tr><td> Not Implemented Yet. </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>" .
					"<table id='raterAndDate'><tr id='raterAndDate'><td id='raterAndDate'>" . "Written by " . $data['RATER_RATER_USERNAME'] . $data['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data['COMMENTS_DATE'] . "</tr></td></table>" . $Text . "</td></tr>";
		
					}
				} else {
					echo "<script> alert('Your search results did not return any matches.') </script>";
				}			
		
		echo "</table>";

		} else {
			echo "<script> alert('You need to fill in at least one box to search...') </script>";
		}		
	}		
?>

	<style type="text/css"> 
		table, th, td {
			border: 1px solid black;
			color: black;
			text-align: center;
		}
		
		th:nth-child(even) {
			background-color: lightgreen;
		}
		
		th:nth-child(odd) {
			background-color: lightblue;
		}
		
		
		td {
			background-color: #FF7F50;
		}
		
		#raterAndDate {
			width: 100%;
			background-color: white;
		}
		
		#searchTable {
			position: absolute;
			left: 20%;
		}
	</style>
	  
  </body>
</html>
