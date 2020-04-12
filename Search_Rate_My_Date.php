<!DOCTYPE html>

<html>
  <head>
	<title> Search </title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/Search_Rate_My_Date.css">
	<script src="Javascript/Search_Javascript.js"> </script>
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
				<br><br>	
				<input type="submit" class="searchSubmitButtons" id="all4" name="all4" value="Search With All Four Boxes"> 
				<input type="submit" class="searchSubmitButtons" id="justFirstName" value="Search Just By First Name">
				<input type="submit" class="searchSubmitButtons" id="justLastName" value="Search Just By Last Name">
				<input type="submit" class="searchSubmitButtons"id="firstAndLast" value="Search By Both First And Last Name">
				<br><br>
				<input type="submit" class="searchSubmitButtons" id="justState" value="Search Just By State">
				<input type="submit" class="searchSubmitButtons" id="justBirthyear" value="Search Just By Birth Year">
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

	if(isset($_POST['all4'])) {
		if ($firstName != null && $lastName != null && $state != null && $birthyear != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_firstname like '$firstName%') OR (ratee_lastname like '$lastName%') OR (ratee_state='$state') OR (ratee_birthyear='$birthyear'))  
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
						if (mysqli_num_rows($displayComments) > 0) {
							while ($data = mysqli_fetch_assoc($displayComments)) {
								$Text = $data['COMMENTS_TEXT'];
								if ($Text != " ") {
									echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data['RATER_RATER_USERNAME'] . $data['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data['COMMENTS_DATE'] . "</tr></td></table> <br> Their Comment: " . $Text . "<br><br>"; 
								if ($data['RATER_RATER_USERNAME'] == $_SESSION['username']) {
									echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data['COMMENTS_ID'] .")'> <br><br> </div> ";
									}
								}

								if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
									echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_RATEE_ID'] . ")'> </td>";		
								}
							}
						}							
							echo "</tr>";
							}
						echo "</table>";
					echo "</form>";									
			} else {
				echo "<script> alert('Your search results did not return any matches.') </script>";
			}
		} else {
			echo "<script> alert('You need to fill in at least one box to search...') </script>";
		}
	}
?>
  </body>
</html>