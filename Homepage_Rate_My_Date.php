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
		<b id="Username_Welcome"> Welcome, <?php session_start(); echo $_SESSION['username']; ?>
		<a href="Homepage_Rate_My_Date.php" class="nav_link">Home</a> |
		<a href="My_Account_Rate_My_Date.php" class="nav_link">My Account</a> |
		<a href="Search_Rate_My_Date.php" class="nav_link"> Search For Dated People </a> |
		<a href="Add_Your_Date_Rate_My_Date.php" class="nav_link"> Add Your Date </a> |
		<a href="Logout_Rate_My_Date.php" class="nav_link">Log Out</a>
		</center>
	</div>
	
    <div id="content">
        <center>
			WELCOME TO RATE MY DATE!
		</center>
    </div>
  </body>
</html>

