	function birthyear() {
	var inputtedLength = document.getElementById("birth").value;
		if (inputtedLength.length > 4) {
			alert("You cannot be born in a year with more than 4 numbers... At least, not for now.");
		} else if (inputtedLength.length < 4) {
			alert("You cannot be born in a year without at least 4 numbers... Unless you're time travelling.");
		} else {
		document.getElementById("add_form").submit();
		}
	}