<!DOCTYPE html>
<html>
  <head>
	<title> Add Date </title>
	<meta charset="UTF-8">
 	<link rel="stylesheet" type="text/css" href="CSS/Add_Your_Date_Rate_My_Date.css">
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
		<b id="Username_Welcome"> Welcome, <?php session_start(); echo $_SESSION['username']; ?>
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
			<h3> Post about your ex! </h3>
			<form action="Add_Your_Date_Extra_Rate_My_Date.php" enctype="multipart/form-data" method="post" id="add_form">
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
					<input type="text" name="birth" id="birth" value="" maxlength="4" required>
				</label>
				
				<br><br>

				<label for="picture"> A photo of them:
					<input type="file" name="picture" id="picture" required> </input>
				</label>
				
				<br><br>

				<h2> ------ Looks ------ </h2>
				<h3> How Hygienic Are They? </h3>
				 1 <input type="radio" name="hygiene" value="1" required> </input> 
				 2 <input type="radio" name="hygiene" value="2"> </input>  
				 3 <input type="radio" name="hygiene" value="3"> </input> 
				 4 <input type="radio" name="hygiene" value="4"> </input> 
				 5 <input type="radio" name="hygiene" value="5"> </input> 
				 6 <input type="radio" name="hygiene" value="6"> </input> 
				 7 <input type="radio" name="hygiene" value="7"> </input> 
				 8 <input type="radio" name="hygiene" value="8"> </input> 
				 9 <input type="radio" name="hygiene" value="9"> </input> 
				 10 <input type="radio" name="hygiene" value="10"> </input> 

				<h3> How Well Do They Dress? </h3>
				 1 <input type="radio" name="dress" value="1" required> </input> 
				 2 <input type="radio" name="dress" value="2"> </input>  
				 3 <input type="radio" name="dress" value="3"> </input> 
				 4 <input type="radio" name="dress" value="4"> </input> 
				 5 <input type="radio" name="dress" value="5"> </input> 
				 6 <input type="radio" name="dress" value="6"> </input> 
				 7 <input type="radio" name="dress" value="7"> </input> 
				 8 <input type="radio" name="dress" value="8"> </input> 
				 9 <input type="radio" name="dress" value="9"> </input> 
				 10 <input type="radio" name="dress" value="10"> </input> 

				<h2> ------ Personality ------ </h2>

				<h3> How Honest Are They? </h3>
				 1 <input type="radio" name="honesty" value="1" required> </input> 
				 2 <input type="radio" name="honesty" value="2"> </input>  
				 3 <input type="radio" name="honesty" value="3"> </input> 
				 4 <input type="radio" name="honesty" value="4"> </input> 
				 5 <input type="radio" name="honesty" value="5"> </input> 
				 6 <input type="radio" name="honesty" value="6"> </input> 
				 7 <input type="radio" name="honesty" value="7"> </input> 
				 8 <input type="radio" name="honesty" value="8"> </input> 
				 9 <input type="radio" name="honesty" value="9"> </input> 
				 10 <input type="radio" name="honesty" value="10"> </input> 

				<h3> How Empathetic Are They? </h3>
				 1 <input type="radio" name="empathy" value="1" required> </input> 
				 2 <input type="radio" name="empathy" value="2"> </input>  
				 3 <input type="radio" name="empathy" value="3"> </input> 
				 4 <input type="radio" name="empathy" value="4"> </input> 
				 5 <input type="radio" name="empathy" value="5"> </input> 
				 6 <input type="radio" name="empathy" value="6"> </input> 
				 7 <input type="radio" name="empathy" value="7"> </input> 
				 8 <input type="radio" name="empathy" value="8"> </input> 
				 9 <input type="radio" name="empathy" value="9"> </input> 
				 10 <input type="radio" name="empathy" value="10"> </input> 

				<h3> How Mature Are They? </h3>
				 1 <input type="radio" name="maturity" value="1" required> </input> 
				 2 <input type="radio" name="maturity" value="2"> </input>  
				 3 <input type="radio" name="maturity" value="3"> </input> 
				 4 <input type="radio" name="maturity" value="4"> </input> 
				 5 <input type="radio" name="maturity" value="5"> </input> 
				 6 <input type="radio" name="maturity" value="6"> </input> 
				 7 <input type="radio" name="maturity" value="7"> </input> 
				 8 <input type="radio" name="maturity" value="8"> </input> 
				 9 <input type="radio" name="maturity" value="9"> </input> 
				 10 <input type="radio" name="maturity" value="10"> </input> 

				<h3> How Would You Rate Their Sense of Humor? </h3>
				 1 <input type="radio" name="humor" value="1" required> </input> 
				 2 <input type="radio" name="humor" value="2"> </input>  
				 3 <input type="radio" name="humor" value="3"> </input> 
				 4 <input type="radio" name="humor" value="4"> </input> 
				 5 <input type="radio" name="humor" value="5"> </input> 
				 6 <input type="radio" name="humor" value="6"> </input> 
				 7 <input type="radio" name="humor" value="7"> </input> 
				 8 <input type="radio" name="humor" value="8"> </input> 
				 9 <input type="radio" name="humor" value="9"> </input> 
				 10 <input type="radio" name="humor" value="10"> </input> 

				<h3> How Affectionate Are They? </h3>
				 1 <input type="radio" name="affection" value="1" required> </input> 
				 2 <input type="radio" name="affection" value="2"> </input>  
				 3 <input type="radio" name="affection" value="3"> </input> 
				 4 <input type="radio" name="affection" value="4"> </input> 
				 5 <input type="radio" name="affection" value="5"> </input> 
				 6 <input type="radio" name="affection" value="6"> </input> 
				 7 <input type="radio" name="affection" value="7"> </input> 
				 8 <input type="radio" name="affection" value="8"> </input> 
				 9 <input type="radio" name="affection" value="9"> </input> 
				 10 <input type="radio" name="affection" value="10"> </input> 

				<h2> ------ Career ------ </h2>
				
				<h3> How Would You Rate Their Career Field? </h3>
				 1 <input type="radio" name="career" value="1" required> </input> 
				 2 <input type="radio" name="career" value="2"> </input>  
				 3 <input type="radio" name="career" value="3"> </input> 
				 4 <input type="radio" name="career" value="4"> </input> 
				 5 <input type="radio" name="career" value="5"> </input> 
				 6 <input type="radio" name="career" value="6"> </input> 
				 7 <input type="radio" name="career" value="7"> </input> 
				 8 <input type="radio" name="career" value="8"> </input> 
				 9 <input type="radio" name="career" value="9"> </input> 
				 10 <input type="radio" name="career" value="10"> </input> 

				<h3> How Would You Rate Their Income? </h3>
				 1 <input type="radio" name="income" value="1" required> </input> 
				 2 <input type="radio" name="income" value="2"> </input>  
				 3 <input type="radio" name="income" value="3"> </input> 
				 4 <input type="radio" name="income" value="4"> </input> 
				 5 <input type="radio" name="income" value="5"> </input> 
				 6 <input type="radio" name="income" value="6"> </input> 
				 7 <input type="radio" name="income" value="7"> </input> 
				 8 <input type="radio" name="income" value="8"> </input> 
				 9 <input type="radio" name="income" value="9"> </input> 
				 10 <input type="radio" name="income" value="10"> </input> 

				<h2> ------ Criminal Record ------ </h2>
				<h3> Do They Have a Criminal Record? </h3>
				Yes <input type="radio" name="criminal" value="1"> </input>
				No <input type="radio" name="criminal" value="10"> </input>
				
				<br><br>

				Additional Comments/Your Story with Them <br>
				<textarea placeholder="Type your comments/story here!" rows="10" cols="50"> </textarea>

				<br><br>

				<input type="submit" value="Submit">
				
			</form>
		</center>
    </div>
  </body>
</html>

