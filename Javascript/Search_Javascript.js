function deleteThisPost(id) {
	document.getElementById("hiddenDeletePost").value = id;
	var check = confirm("Are you sure you want to delete this comment?");
	if (check == true) {
		document.getElementById("searchForm").submit();
	}
}

function editThisPost(id) {
	document.getElementById("hiddenEditPost").value = id;
	var NewText = prompt("Please write your new comment.", "My Comment Here");
	document.getElementById("hiddenEditPostText").value = NewText;
	document.getElementById("searchForm").submit();
}

function deleteThisRatee(id) {
		document.getElementById("hiddenDeleteRatee").value = id;
		var check = confirm("Are you sure you want to delete this ratee?");
		if (check == true) {
			document.getElementById("searchForm").submit();
		}
}
