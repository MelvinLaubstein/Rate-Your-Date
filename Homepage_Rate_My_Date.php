<!DOCTYPE html>
<html>
  <head>
	<title> Homepage </title>
	<meta charset="UTF-8">
 	<link rel="stylesheet" type="text/css" href="CSS/Homepage_Rate_My_Date.css">
  </head>

  <body>
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
	
    <div id="content">
		<br><br>
        <center>
			<b> WELCOME TO RATE MY DATE! </b>
			<p id="Greeting" maxlength="700px"> The world of dating can be a scary place. <br><br>Do you ever wish you could hear from those who know your date as a romantic partner best before jumping in to a relationship? Do you ever wish you could warn other people about individuals who were a complete disaster as a significant other? <br><br> If so, Rate My Date will help you contribute to a compilation of information on people’s past dating experiences, and benefit yourself from this information! No longer date in fear! 
			<br><br> Access My Account to change your account information.
			<br><br> Access Search For Dated People to start searching for users' past dates. 
			<br><br> Access Add Your Date to begin adding your past dating experiences.</p>
		</center>
    </div>
  </body>
</html>

