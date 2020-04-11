<?php 
	session_start();
	$servername = 'localhost';
	$username = 'root';
	$password = 'password';
	$dbname = 'mydb';
	$conn = new mysqli($servername, $username, $password, $dbname);
	$theirId = $_POST['theirId'];
	$theirId = (string) $theirId;
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
	
	if (isset($_POST['COMMENTS'])) {
		$commentInput = $_POST['COMMENTS'];
	}
	
	if (isset($_POST['criminal'])) {
		$criminalInput = $_POST['criminal'];
	}
	
	$Looks_Score = (($hygieneInput + $dressInput) / 2);
	$Personality_Score = (($honestyInput + $empathyInput + $maturityInput + $humorInput + $affectionInput) / 5);
	$Career_Score = (($careerInput + $incomeInput) / 2);
	if (!isset($criminalInput)) {
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score) / 3);
		$checkOldScore = (mysqli_query($conn, "SELECT * FROM RATEE WHERE RATEE_ID='$theirId'"));
		if (mysqli_num_rows($checkOldScore) > 0 ) {
			while ($data11 = mysqli_fetch_assoc($checkOldScore)) {
				$OldScore = $data11['RATEE_OVERALL_SCORE'];
			}

			$Total_Score = ($Total_Score + $OldScore) / 2;
			$Total_Score = round($Total_Score, 2);
		}
		
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score) / 3);
		$Total_Score = round($Total_Score,2);
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
		
		if (isset($_POST['COMMENTS'])) {
			$checkRaterSql = "Select * from Rater where rater_username='$currentUser'";
			if (mysqli_num_rows(mysqli_query($conn, $checkRaterSql)) > 0) {
				$sqlCOMMENTS = "INSERT INTO COMMENTSS (comments_date, comments_text, ratee_ratee_id, rater_rater_username, administrator_administrator_username) VALUES (NOW(), '$commentInput','$theirId', '$currentUser', null)";
				mysqli_query($conn, $sqlCOMMENTS);
			} 
			
			$checkAdminSql = "Select * from Administrator where administrator_username='$currentUser'";
			if (mysqli_num_rows(mysqli_query($conn, $checkAdminSql)) > 0) {
				$sqlCOMMENTS = "INSERT INTO COMMENTSS (comments_date, comments_text, ratee_ratee_id, rater_rater_username, administrator_administrator_username) VALUES (NOW(), '$commentInput','$theirId', null, '$currentUser')";
				mysqli_query($conn, $sqlCOMMENTS);
			}
		}
		echo "<script> alert('Rating was added successfully.');
		window.location.href='Search_Rate_My_Date.php' </script>"; 
		
	} else {
		echo "<script> alert('Rating was unsuccessful. You shouldn't see this.'); 
		window.location.href='Add_Your_Date_Rate_My_Date.php' </script>"; 
	}

?>