<?php 
	session_start();
	$servername = 'localhost';
	$username = 'root';
	$password = 'password';
	$dbname = 'mydb';
	$conn = new mysqli($servername, $username, $password, $dbname);
	$firstNameInput = $_POST['fname']; 
	$lastNameInput = $_POST['lname'];
	$stateInput = $_POST['state'];
	$birthInput = $_POST['birth'];
	$hygieneInput = $_POST['hygiene'];
	$dressInput = $_POST['dress'];
	$honestyInput = $_POST['honesty'];
	$empathyInput = $_POST['empathy'];
	$maturityInput = $_POST['maturity'];
	$humorInput = $_POST['humor'];
	$affectionInput = $_POST['affection'];
	$careerInput = $_POST['career'];
	$incomeInput = $_POST['income'];
	if (isset($_POST['criminal'])) {
		$criminalInput = $_POST['criminal'];
	}
	
	$Looks_Score = (($hygieneInput + $dressInput) / 2);
	$Personality_Score = (($honestyInput + $empathyInput + $maturityInput + $humorInput + $affectionInput) / 5);
	$Career_Score = (($careerInput + $incomeInput) / 2);
	if (!isset($criminalInput)) {
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score) / 3);
	} else {
		$Total_Score = (($Looks_Score + $Personality_Score + $Career_Score + $criminalInput) / 4);
		echo "Looks: " . $Looks_Score . " ";
		echo "Personality: " . $Personality_Score . " ";
		echo "Career: " . $Career_Score . " ";
		echo "Criminal: " . $criminalInput . " ";
		echo "Total before division: " . ($Looks_Score + $Personality_Score + $Career_Score + $criminalInput);
	}
 if (isset($_FILES['picture']['name'])) {
		$pictureInput = base64_encode(file_get_contents($_FILES['picture']['tmp_name']));
		$sqlRateeBasicInfo = "INSERT INTO RATEE (ratee_firstname, ratee_lastname, ratee_state, ratee_birthyear, ratee_overall_score, ratee_personal_picture) VALUES ('$firstNameInput', '$lastNameInput', 
			'$stateInput', '$birthInput', '$Total_Score', '$pictureInput')";
		mysqli_query($conn, $sqlRateeBasicInfo);
	}

?>