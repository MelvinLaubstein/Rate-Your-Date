function hideInitialSearch(id) {
	document.getElementById("openingHide").remove();
	document.getElementById("showInitialSearch").remove();
	document.getElementById("stuffToHide").style.visibility = "visible";
	document.getElementById("theirId").value = id;
	document.getElementById("theirId").style.visibility = "hidden";
	alert("Great! Glad you found them! You can rate them below.");
}