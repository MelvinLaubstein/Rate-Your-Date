<?php 
/* Connects to database and starts session */
	session_start();
	$servername = 'localhost';
	$username = 'root';
	$password = 'password';
	$dbname = 'mydb';
	$conn = new mysqli($servername, $username, $password, $dbname);
/* Grabs all rating information from the form, setting it to PHP variables. */
	$theirId = $_POST['theirId'];
	$theirId = (string) $theirId;
	$updaterUsername = $_SESSION['username'];
	$stateInput = $_POST['state1'];
	$hygieneInput = $_POST['hygiene'];
	$dressInput = $_POST['dress'];
	$honestyInput = $_POST['honesty'];
	$empathyInput = $_POST['empathy'];
	$maturityInput = $_POST['maturity'];
	$humorInput = $_POST['humor'];
	$affectionInput = $_POST['affection'];
	$careerInput = $_POST['career'];
	$incomeInput = $_POST['income'];
/* Sets blank values for certain variables if nothing is inputted by the user. */	
	if (isset($_POST['COMMENTS'])) {
		$commentInput = $_POST['COMMENTS'];
	} else {
		$commentInput = "";
	}
	
	if (isset($_POST['criminal'])) {
		$criminalInput = $_POST['criminal'];
	}
/* Sets each category's total score to be the average of that category's scores. */
	$Looks_Score = (($hygieneInput + $dressInput) / 2);
	$Personality_Score = (($honestyInput + $empathyInput + $maturityInput + $humorInput + $affectionInput) / 5);
	$Career_Score = (($careerInput + $incomeInput) / 2);
/* Calculates the overall total of all categories if no criminal record was inputted. */
	if (!isset($criminalInput)) {
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score) / 3);
		$checkOldScore = (mysqli_query($conn, "SELECT * FROM RATEE WHERE RATEE_ID='$theirId'"));
		/* Takes the current overall score in as a PHP variable to average with the new overall score, thereby obtaining an updated average score. */
		if (mysqli_num_rows($checkOldScore) > 0 ) {
			while ($data11 = mysqli_fetch_assoc($checkOldScore)) {
				$OldScore = $data11['RATEE_OVERALL_SCORE'];
			}

			$Total_Score = ($Total_Score + $OldScore) / 2;
			$Total_Score = round($Total_Score, 2);
		}
		
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score) / 3);
		$Total_Score = round($Total_Score,2);
	/* Calculates the overall total of all categories if criminal record was inputted. */
	} else {
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score + $criminalInput) / 4);
		$checkOldScore = (mysqli_query($conn, "SELECT * FROM RATEE WHERE RATEE_ID='$theirId'"));
		if (mysqli_num_rows($checkOldScore) > 0 ) {
			while ($data10 = mysqli_fetch_assoc($checkOldScore)) {
				$OldScore = $data10['RATEE_OVERALL_SCORE'];
				}
			}
		$Total_Score = ($Total_Score + $OldScore) / 2;
		$Total_Score = round($Total_Score,2);
	}
	/* Updates the ratee's state and profile picture (just in case they moved or look different now), inserts every new category score, and inserts any new comment (everything going into its respective table). This means that while existing ratees get more scores/comments inserted for them, none of this code intends to -- or does -- add any new ratee(s). */
		$raterCheckDuplicate = mysqli_query($conn, "Select * from Comments where rater_rater_username='$updaterUsername' && ratee_ratee_id='$theirId'");
		$administratorCheckDuplicate = mysqli_query($conn, "Select * from Comments where administrator_administrator_username='$updaterUsername' && ratee_ratee_id='$theirId'");
		if (mysqli_num_rows($raterCheckDuplicate) < 1) {		
		  if (isset($_FILES['picture']['name'])) {
			$pictureInput = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
				$sqlRateeBasicInfo = "UPDATE RATEE set ratee_state='$stateInput', ratee_overall_score='$Total_Score', ratee_personal_picture='$pictureInput' where ratee_id='$theirId'"; 
				mysqli_query($conn, $sqlRateeBasicInfo);
				
				$sqlPersonality = "INSERT INTO PERSONALITY (personality_honesty_score, personality_empathy_score, personality_maturity_score, 
				personality_sense_of_humor_score, personality_affection_score, personality_overall_score, ratee_ratee_id) VALUES ('$honestyInput', 
				'$empathyInput','$maturityInput', '$humorInput', '$affectionInput', '$Personality_Score', '$theirId')";
				mysqli_query($conn, $sqlPersonality);
				
				$sqlLooks = "INSERT INTO LOOKS (looks_hygiene_score, looks_dress_appearance_score, looks_overall_score, ratee_ratee_id) VALUES ('$hygieneInput',
				'$dressInput', '$Looks_Score', '$theirId')";
				mysqli_query($conn, $sqlLooks);
				
				$sqlCareer = "INSERT INTO CAREER (career_job_satisfaction_score, career_income_score, career_overall_score, ratee_ratee_id) VALUES ('$careerInput', 
				'$incomeInput', '$Career_Score', '$theirId')";
				mysqli_query($conn, $sqlCareer);
				
				if (isset($_POST['criminal'])) {
					$sqlCriminal = "INSERT INTO CRIMINAL_RECORD (criminal_record_status, ratee_ratee_id) VALUES ('$criminalInput', '$theirId')";
					mysqli_query($conn, $sqlCriminal);
				}
				
				$currentUser = $_SESSION['username'];
				$checkRaterSql = "Select * from Rater where rater_username='$currentUser'";
					if (mysqli_num_rows(mysqli_query($conn, $checkRaterSql)) > 0) {
						$sqlCOMMENTS = "INSERT INTO COMMENTS (comments_date, comments_text, ratee_ratee_id, rater_rater_username, administrator_administrator_username) VALUES (NOW(), '$commentInput','$theirId', '$currentUser', null)";
						mysqli_query($conn, $sqlCOMMENTS);
					} 
					
					$checkAdminSql = "Select * from Administrator where administrator_username='$currentUser'";
					if (mysqli_num_rows(mysqli_query($conn, $checkAdminSql)) > 0) {
						$sqlCOMMENTS = "INSERT INTO COMMENTS (comments_date, comments_text, ratee_ratee_id, rater_rater_username, administrator_administrator_username) VALUES (NOW(), '$commentInput','$theirId', null, '$currentUser')";
						mysqli_query($conn, $sqlCOMMENTS);
				}
				echo "<script> alert('Rating was added successfully.');
				window.location.href='Search_Rate_My_Date.php' </script>"; 
				
			} else {
				echo "<script> alert('Rating was unsuccessful. You shouldn't see this.'); 
				window.location.href='Add_Your_Date_Rate_My_Date.php' </script>"; 
			}
		/* The below code will funtion if a rater, and a rater alone, is trying to submit two or more ratings for the same ratee(s). An aministrator check is available above, and 
		can be implemented if the site owners want to extend this restriction to admins as well. */
		} else {
			echo "<script> alert('You cannot review someone twice!'); window.location.href='Search_Rate_My_Date.php' </script>"; 
		}
?>