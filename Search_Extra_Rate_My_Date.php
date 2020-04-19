<?php 
/* Connects to the database and starts session */
	session_start();
	$servername = 'localhost';
	$username = 'root';
	$password = 'password';
	$dbname = 'mydb';
	$conn = new mysqli($servername, $username, $password, $dbname);
/* Grabs the ID or text of whatever ratee or comment was chosen for edit or deletion */
	$deleteCommentsId = $_POST['hiddenDeletePost'];
	$editCommentsId = $_POST['hiddenEditPost'];
	$editCommentsText = $_POST['hiddenEditPostText'];
	$deleteRateeNow = $_POST['hiddenDeleteRatee'];
/* Set a comment to be blank, thereby making it appear deleted (if the user chose to do this). */
	if ($_POST['hiddenDeletePost'] !== "") {
		$deletePostQuery = "UPDATE COMMENTS set comments_text='' where comments_id='$deleteCommentsId'";
		mysqli_query($conn, $deletePostQuery);
		echo "<script> alert('Comment Deleted!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
/* Update a comment to be whatever the user decides it should be (if the user chose to do this). */	
	if ($_POST['hiddenEditPost'] !== "") {
		$editPostQuery = "UPDATE COMMENTS SET comments_text='$editCommentsText' where comments_id='$editCommentsId'";
		mysqli_query($conn, $editPostQuery);
		echo "<script> alert('Comment Edited!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
/* Delete a ratee from the database. Due to cascade on delete, this will delete all of their associated ratings and comments (along with their ratee profile). */	
	if ($_POST['hiddenDeleteRatee'] !== "") {
		$deleteRateeQuery = "DELETE FROM RATEE where ratee_id='$deleteRateeNow'";
		mysqli_query($conn, $deleteRateeQuery);	
		echo "<script> alert('Ratee deleted!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
	
?>