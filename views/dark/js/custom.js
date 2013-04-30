function setError() {
	var place = document.getElementById("errorPlace");
	var error = document.getElementById("error").innerHTML;
	place.innerHTML = error;
	error = "";
}