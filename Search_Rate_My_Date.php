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
				<input type="submit" class="searchSubmitButtons" name="justFirstName" id="justFirstName" value="Search Just By First Name">
				<input type="submit" class="searchSubmitButtons" name="justLastName" id="justLastName" value="Search Just By Last Name">
				<input type="submit" class="searchSubmitButtons" name="firstAndLast" id="firstAndLast" value="Search By Both First And Last Name">
				<br><br>
				<input type="submit" class="searchSubmitButtons" name="justState" id="justState" value="Search Just By State">
				<input type="submit" class="searchSubmitButtons" name="justBirthyear" id="justBirthyear" value="Search Just By Birth Year">
				<input type="submit" class="searchSubmitButtons" name="showTableNoConditions" id="showTableNoConditions" value="Just Search, No Conditions">			
			</form>
        </center>
      </div> 

<?php
/* Connects to the database */
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "mydb";
	$conn = new mysqli($servername, $username, $password, $dbname);
	/* Set empty inputs to being null, and if they're not null, sets them to PHP variables. */
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
/* Perform the following if the user indicates to search using all four boxes, using all four boxes to search. */
	if(isset($_POST['all4'])) {
		if ($firstName != null && $lastName != null && $state != null && $birthyear != null) {
			/* Sets up the table to display the database on the webpage. */
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			/* Show the delete button heading if the currently logged-in user is an administrator. */
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			/* Pulls everything from the database that matches the search criteria. */
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_firstname like '$firstName%') OR (ratee_lastname like '$lastName%') OR (ratee_state='$state') OR (ratee_birthyear='$birthyear'))  
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
					/* Display comments that are associated with the ratee, if they exist. */
					if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						/* Show the delete button if the currently logged-in user is an administrator. */
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
						}
							}
					echo "</tr>";								
							}
						echo "</table>";
					echo "</form>";									
			} else {
				echo "<script> alert('Your search results did not return any matches.') </script>";
			}
			/* Indicate that the user clicked a button to search, but hasn't filled in the necessary boxes for that search. */
		} else {
			echo "<script> alert('You need to fill in all four boxes to search!') </script>";
		}
	/* Performs the entire process described above, except only using first name as a search criterion. */
	} else if (isset($_POST['justFirstName'])) {
		if ($firstName != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_firstname like '$firstName%')) 
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
					if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
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
			echo "<script> alert('You need to fill in the their first name!') </script>";
		}
	/* Performs the entire process described above, except only using last name as a search criterion. */
	} else if (isset($_POST['justLastName'])) {
		if ($lastName != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_lastname like '$lastName%')) 
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
						if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
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
			echo "<script> alert('You need to fill in the their last name!') </script>";
		}
	/* Performs the entire process described above, except only using a combination of both the first and last name as search criteria. */
	} else if(isset($_POST['firstAndLast'])) {
		if ($firstName != null && $lastName != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_firstname like '$firstName%') OR (ratee_lastname like '$lastName%'))
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
						if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
						}
							}
					echo "</tr>";				
							echo "</tr>";
							}
						echo "</table>";
					echo "</form>";									
			} else {
				echo "<script> alert('Your search results did not return any matches.') </script>";
			}
		} else {
			echo "<script> alert('You need to fill in both their first and last name!') </script>";
		}
	/* Performs the entire process described above, except only using state as a search criterion. */
	} if(isset($_POST['justState'])) {
		if ($state != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_state='$state'))  
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
				if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
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
			echo "<script> alert('You need to fill in their state!') </script>";
		}
	/* Performs the entire process described above, except only using birth year as a search criterion. */
	} else if(isset($_POST['justBirthyear'])) {
		if ($birthyear != null) {
			echo "<br><br><br><br><br><br><br><br><br><br>";
			echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
			echo "<table id='searchTable' cellspacing='0'>";
			echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
			$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
			if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
				echo "<th> Delete This Ratee </th>";
			}
			$displayResults = mysqli_query($conn, "SELECT * from 
			(SELECT * from RATEE where (ratee_birthyear='$birthyear'))  
			RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
			echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
			echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
			echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
			echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
			if (mysqli_num_rows($displayResults) > 0) {
				while($data = mysqli_fetch_assoc($displayResults)) {			
					echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
						$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
					if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
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
			echo "<script> alert('You need to fill in their birth year!') </script>";
		}
	/* Performs the entire process described above, except it displays everything in the database without restrictions, so long as it pertains to ratees, their ratings, or their comments. */
	} else if (isset($_POST['showTableNoConditions'])) {
		echo "<br><br><br><br><br><br><br><br><br><br>";
		echo "<form id='searchForm' action='Search_Extra_Rate_My_Date.php' method='post' onsubmit='return false'>";
		echo "<table id='searchTable' cellspacing='0'>";
		echo "<th id='ProfilePicture'> Picture </th><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th><th id='Ranking'> Their Overall Ranking </th><th> COMMENTS </th>";
		$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");
		if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
			echo "<th> Delete This Ratee </th>";
		}
		$displayResults = mysqli_query($conn, "SELECT * from 
		(SELECT * from RATEE where 1=1)  
		RATEE INNER JOIN COMMENTS on ratee.ratee_id = comments.ratee_ratee_id GROUP BY ratee_id ORDER BY ratee.ratee_overall_score desc");
		echo "<input type='text' name='hiddenEditPost' id='hiddenEditPost' value='' hidden>";
		echo "<input type='text' name='hiddenEditPostText' id='hiddenEditPostText' value='' hidden>";
		echo "<input type='text' name='hiddenDeletePost' id='hiddenDeletePost' value='' hidden>";
		echo "<input type='text' name='hiddenDeleteRatee' id='hiddenDeleteRatee' value='' hidden>";	
	if (mysqli_num_rows($displayResults) > 0) {
		while($data = mysqli_fetch_assoc($displayResults)) {			
			echo "<tr><td> <img width='200px' height='200px' src='data:image/png;base64," . $data['RATEE_PERSONAL_PICTURE'] . "' /> </td><td>" . $data['RATEE_FIRSTNAME'] . " " . $data['RATEE_LASTNAME'] . "</td><td>" . $data['RATEE_BIRTHYEAR'] . "</td><td>" . $data['RATEE_STATE'] . "</td><td>" . $data['RATEE_OVERALL_SCORE'] . "</td><td>";
				$displayComments = mysqli_query($conn, "SELECT * FROM COMMENTS where ratee_ratee_ID=" . $data['RATEE_ID'] . "");	
				if (mysqli_num_rows($displayComments) > 0) {
					while ($data2 = mysqli_fetch_assoc($displayComments)) {
						$Text = $data2['COMMENTS_TEXT'];
						if ($Text != " " && $Text != "") {
							echo "<div id='commentSeparator'><table class='raterAndDate'><tr class='raterAndDate'><td class='raterAndDate'>" . "Submitted by " . $data2['RATER_RATER_USERNAME'] . $data2['ADMINISTRATOR_ADMINISTRATOR_USERNAME'] . " on " . $data2['COMMENTS_DATE'] . "</tr></td></table> <br>" . $Text . "<br><br>"; 
						if ($data2['RATER_RATER_USERNAME'] == $_SESSION['username'] || mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<input type='submit' name='EditTheAbove' value='Edit The Above Post' onclick='editThisPost(" . $data2['COMMENTS_ID'] . ")'>  </button> <br><br> <input type='submit' name='deletePostPHP'  value='Delete The Above Post' onclick='deleteThisPost(" . $data2['COMMENTS_ID'] .")'> <br><br> </div> ";
							}								
						}
					}
						$HideDeleteButtonQuery = mysqli_query($conn, "SELECT * FROM ADMINISTRATOR WHERE administrator_username='" . $_SESSION['username'] . "'");	
						if (mysqli_num_rows($HideDeleteButtonQuery) > 0) {
							echo "<td><input type='submit' value='Delete This Ratee' class='DeleteTheLeft' onclick='deleteThisRatee(". $data['RATEE_ID'] . ")'> </td>";		
						}
							}
					echo "</tr>";		
					}
				echo "</table>";
			echo "</form>";									
	} else {
		echo "<script> alert('Your search results did not return any matches.') </script>";
	}	
}

?>
  </body>
</html>