<?php 
	session_start();
	$servername = 'localhost';
	$username = 'root';
	$password = 'password';
	$dbname = 'mydb';
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$deleteCommentsId = $_POST['hiddenDeletePost'];
	$editCommentsId = $_POST['hiddenEditPost'];
	$editCommentsText = $_POST['hiddenEditPostText'];
	$deleteRateeNow = $_POST['hiddenDeleteRatee'];

	if ($_POST['hiddenDeletePost'] !== "") {
		$deletePostQuery = "DELETE FROM COMMENTS where comments_id='$deleteCommentsId'";
		mysqli_query($conn, $deletePostQuery);
		echo "<script> alert('Comment Deleted!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
	
	if ($_POST['hiddenEditPost'] !== "") {
		$editPostQuery = "UPDATE COMMENTS SET comments_text='$editCommentsText' where comments_id='$editCommentsId'";
		mysqli_query($conn, $editPostQuery);
		echo "<script> alert('Comment Edited!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
	
	if ($_POST['hiddenDeleteRatee'] !== "") {
		$deleteRateeQuery = "DELETE FROM RATEE where ratee_id='$deleteRateeNow'";
		mysqli_query($conn, $deleteRateeQuery);
		
	
		echo "<script> alert('Ratee deleted!'); 
		window.location.href='Search_Rate_My_Date.php' </script>"; 
	}
	
?>