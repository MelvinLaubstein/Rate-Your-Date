<!DOCTYPE html>

<html>
  <head>
	<title> Search </title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/Search_Rate_My_Date.css">
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

    <!-- This is the div for the search bar -->
    
      <div id="search">
        <center>
            <form action="http://localhost/search.php" method="post">
				<h2> Search for people you may know </h2>
				
				First Name: <input type="text" name="fname" id="fname" value=""> 
				Last Name: <input type="text" name="lname" id="lname"> 
				Their State (initials): <input type="text" name="state" id="state" maxlength="2" size="2"> 
				Their year of birth: <input type="text" name="birthyear" id="birthyear" maxlength="4" size="4">
				<input type="submit" value="Submit">
			</form>
        </center>
      </div>  
  </body>
</html>

