<!DOCTYPE html>
<html>
  <head>
	<title> Add Date </title>
	<meta charset="UTF-8">
 	<link rel="stylesheet" type="text/css" href="CSS/Add_Your_Date_Rate_My_Date.css">
	<script src="Javascript/Add_Your_Date_Main_Rate_My_Date.js"> </script>
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

    <!-- This is the div for the body -->
    <div id="content">
        <center>
		<div id="openingHide">
			<h3> Post about your ex! </h3> 
			<form enctype="multipart/form-data" method="post" id="add_form" action="Add_Your_Date_Rate_My_Date.php">
				<label for="fname"> Their First Name:
					<input type="text" name="fname" id="fname" value="" required>
				</label>
				
				<br>
				
				<label for="lname"> Their Last Name: 
					<input type="text" name="lname" id="lname" value="" required>
				</label>
			
				<br>	

				<label for="state"> Their State Initials:
					<input type="text" name="state" id="state" value="" maxlength="2" required>
				</label>

				<br>				
				
				<label for="birth"> Their birth year:
					<input type="text" name="birth" id="birth" value="" maxlength="4" minlength="4" required>
				</label>
				
				<br>
				<br>
				
				<input type="submit" id="initialSearch" name="initialSearch" value="Search by these criteria">
				<br>
				<br>

			</form>
		</div>


			<form action="Add_Your_Date_Extra_Rate_My_Date.php" method="post" enctype="multipart/form-data">
				<div id="showInitialSearch">
			<?php 		
				$servername = "localhost";
				$username = "root";
				$password = "password";
				$dbname = "mydb";
				$conn = new mysqli($servername, $username, $password, $dbname);
				if (isset($_POST['initialSearch'])) {
					if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['state']) && isset($_POST['birth'])) {
						$firstName = $_POST['fname'];
						$lastName = $_POST['lname'];
						$state = $_POST['state'];
						$birthyear = $_POST['birth'];

						echo "<table>";
						$showSearch = mysqli_query($conn, "SELECT * from RATEE where (ratee_firstname like '$firstName%') OR (ratee_lastname like '$lastName%') OR (ratee_state='$state') OR (ratee_birthyear='$birthyear')");
								echo "<tr><th id='PersonName'> Name </th><th id='BirthYear'> Birth Year </th><th id='PersonState'> Their State </th> <th> Affirm This Person </th></tr>";
						if (mysqli_num_rows($showSearch) > 0) {
							while($dataInitialSearchSql = mysqli_fetch_assoc($showSearch)) {
								echo "<tr><td>" . $dataInitialSearchSql['RATEE_FIRSTNAME'] . " " . $dataInitialSearchSql['RATEE_LASTNAME'] . "</td><td>" . $dataInitialSearchSql['RATEE_BIRTHYEAR'] . "</td><td>" . $dataInitialSearchSql['RATEE_STATE'] . "</td><td> <button onclick='hideInitialSearch(" . $dataInitialSearchSql['RATEE_ID'] . ")' id=" . $dataInitialSearchSql['RATEE_ID'] . "> This is who I'm looking for! </button> </td></tr>";
							}

						} else {
							echo "<script> alert('No results found! Redirecting you now to submit a new profile!'); </script>";
							echo "<script> window.location.href='New_Person_Rate_My_Date.php' </script>";
						}
					} else {
						echo "<script> alert('You need to fill in all four boxes to search!'); </script>";
					}
						echo "</table>";
						echo "<br><br> <button> <a id='Show_Form'href='New_Person_Rate_My_Date.php'> I don't see them in your results. I want to add them now!  </a></button>";
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
							background-color: pink;
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
					
					<br>
					<br>
			</div>
					
				<div id="stuffToHide">	
					<br>
					<label for="state"> Their State Initials:
						<input type="text" name="state1" id="state1" value="" maxlength="2" required>
					</label>

					<input type="text" name="theirId" id="theirId" value="">

					<br><br>		
							
					<label for="picture"> A photo of them:
						<input type="file" name="picture" id="picture" required> 
					</label>
					
					<br><br>

					<h2> ------ Looks ------ </h2>
					<h3> How Hygienic Are They? </h3>
					 1 <input type="radio" name="hygiene" value="1" required>  
					 2 <input type="radio" name="hygiene" value="2">   
					 3 <input type="radio" name="hygiene" value="3">  
					 4 <input type="radio" name="hygiene" value="4">  
					 5 <input type="radio" name="hygiene" value="5">  
					 6 <input type="radio" name="hygiene" value="6">  
					 7 <input type="radio" name="hygiene" value="7">  
					 8 <input type="radio" name="hygiene" value="8">  
					 9 <input type="radio" name="hygiene" value="9">  
					 10 <input type="radio" name="hygiene" value="10">  

					<h3> How Well Do They Dress? </h3>
					 1 <input type="radio" name="dress" value="1" required>  
					 2 <input type="radio" name="dress" value="2">   
					 3 <input type="radio" name="dress" value="3">  
					 4 <input type="radio" name="dress" value="4">  
					 5 <input type="radio" name="dress" value="5">  
					 6 <input type="radio" name="dress" value="6">  
					 7 <input type="radio" name="dress" value="7">  
					 8 <input type="radio" name="dress" value="8">  
					 9 <input type="radio" name="dress" value="9">  
					 10 <input type="radio" name="dress" value="10">  

					<h2> ------ Personality ------ </h2>

					<h3> How Honest Are They? </h3>
					 1 <input type="radio" name="honesty" value="1" required>  
					 2 <input type="radio" name="honesty" value="2">   
					 3 <input type="radio" name="honesty" value="3">  
					 4 <input type="radio" name="honesty" value="4">  
					 5 <input type="radio" name="honesty" value="5">  
					 6 <input type="radio" name="honesty" value="6">  
					 7 <input type="radio" name="honesty" value="7">  
					 8 <input type="radio" name="honesty" value="8">  
					 9 <input type="radio" name="honesty" value="9">  
					 10 <input type="radio" name="honesty" value="10">  

					<h3> How Empathetic Are They? </h3>
					 1 <input type="radio" name="empathy" value="1" required>  
					 2 <input type="radio" name="empathy" value="2">   
					 3 <input type="radio" name="empathy" value="3">  
					 4 <input type="radio" name="empathy" value="4">  
					 5 <input type="radio" name="empathy" value="5">  
					 6 <input type="radio" name="empathy" value="6">  
					 7 <input type="radio" name="empathy" value="7">  
					 8 <input type="radio" name="empathy" value="8">  
					 9 <input type="radio" name="empathy" value="9">  
					 10 <input type="radio" name="empathy" value="10">  

					<h3> How Mature Are They? </h3>
					 1 <input type="radio" name="maturity" value="1" required>  
					 2 <input type="radio" name="maturity" value="2">   
					 3 <input type="radio" name="maturity" value="3">  
					 4 <input type="radio" name="maturity" value="4">  
					 5 <input type="radio" name="maturity" value="5">  
					 6 <input type="radio" name="maturity" value="6">  
					 7 <input type="radio" name="maturity" value="7">  
					 8 <input type="radio" name="maturity" value="8">  
					 9 <input type="radio" name="maturity" value="9">  
					 10 <input type="radio" name="maturity" value="10">  

					<h3> How Would You Rate Their Sense of Humor? </h3>
					 1 <input type="radio" name="humor" value="1" required>  
					 2 <input type="radio" name="humor" value="2">   
					 3 <input type="radio" name="humor" value="3">  
					 4 <input type="radio" name="humor" value="4">  
					 5 <input type="radio" name="humor" value="5">  
					 6 <input type="radio" name="humor" value="6">  
					 7 <input type="radio" name="humor" value="7">  
					 8 <input type="radio" name="humor" value="8">  
					 9 <input type="radio" name="humor" value="9">  
					 10 <input type="radio" name="humor" value="10">  

					<h3> How Affectionate Are They? </h3>
					 1 <input type="radio" name="affection" value="1" required>  
					 2 <input type="radio" name="affection" value="2">   
					 3 <input type="radio" name="affection" value="3">  
					 4 <input type="radio" name="affection" value="4">  
					 5 <input type="radio" name="affection" value="5">  
					 6 <input type="radio" name="affection" value="6">  
					 7 <input type="radio" name="affection" value="7">  
					 8 <input type="radio" name="affection" value="8">  
					 9 <input type="radio" name="affection" value="9">  
					 10 <input type="radio" name="affection" value="10">  

					<h2> ------ Career ------ </h2>
					
					<h3> How Would You Rate Their Career Field? </h3>
					 1 <input type="radio" name="career" value="1" required>  
					 2 <input type="radio" name="career" value="2">   
					 3 <input type="radio" name="career" value="3">  
					 4 <input type="radio" name="career" value="4">  
					 5 <input type="radio" name="career" value="5">  
					 6 <input type="radio" name="career" value="6">  
					 7 <input type="radio" name="career" value="7">  
					 8 <input type="radio" name="career" value="8">  
					 9 <input type="radio" name="career" value="9">  
					 10 <input type="radio" name="career" value="10">  

					<h3> How Would You Rate Their Income? </h3>
					 1 <input type="radio" name="income" value="1" required>  
					 2 <input type="radio" name="income" value="2">   
					 3 <input type="radio" name="income" value="3">  
					 4 <input type="radio" name="income" value="4">  
					 5 <input type="radio" name="income" value="5">  
					 6 <input type="radio" name="income" value="6">  
					 7 <input type="radio" name="income" value="7">  
					 8 <input type="radio" name="income" value="8">  
					 9 <input type="radio" name="income" value="9">  
					 10 <input type="radio" name="income" value="10">  

					<h2> ------ Criminal Record ------ </h2>
					<h3> Do They Have a Criminal Record? </h3>
					Yes <input type="radio" name="criminal" value="1"> 
					No <input type="radio" name="criminal" value="10"> 
					
					<br><br>

					Additional Comment/Your Story with Them <br>
					<textarea placeholder="Type your comments/story here!" name="COMMENTS" rows="10" cols="50"> </textarea>

					<br><br>
					
					<input type="submit" id="send1" name="send1" value="Finish Rating">
				</div>
			</form>
		</center>
	</div>
	</body>
</html>

