<!DOCTYPE html>

<html>
  <head>
	<title> My Account </title>
	<meta charset="UTF-8">
  	<link rel="stylesheet" type="text/css" href="CSS/My_Account_Rate_My_Date.css">
  </head>
    
	<body>
		<!-- This is the div for the header -->
		<div id="header">
		  <center>
			<h1> Rate My Date </h1>
		  </center>
		</div>
		 <!-- This is the div for the nav bar -->
		<div id="nav">
			<center>
			Welcome, <?php session_start(); echo $_SESSION['username']; ?>
			<a href="Homepage_Rate_My_Date.php" class="nav_link">Home</a> |
			<a href="My_Account_Rate_My_Date.php" class="nav_link">My Account</a> |
			<a href="Search_Rate_My_Date.php" class="nav_link"> Search For Dated People </a> |
			<a href="Add_Your_Date_Rate_My_Date.php" class="nav_link"> Add Your Date </a> |
			<a href="Logout_Rate_My_Date.php" class="nav_link">Log Out</a>
			</center>
		</div>
		 <!-- This is the div for the body of account info-->
		<div id="Info">
			<center>
			  <h3 id="accountheader"> Account Info </h3>
			</center>
			<center>
			  <form action="http://localhost/account.php" method="post">
				<span id="profilepic"><img src="avatar.png" alt="Avatar" class="avatar"><br>[<a href="avatar_change">change</a>]</span>
				
				<br><br>
				
				Email:<br>
				
				<span id="field"></span>
				
				<br><br>
				
				Username:<br>
				
				<span id="field"></span>
				
				<br><br>
				
				Password:<br>
				
				<span id="field change "> [<a href="password_change">change password</a>]</span>
				
				<br><br>
			  
			  </form>
			</center>
		</div>
	</body>
</html>
