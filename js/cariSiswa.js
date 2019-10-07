// get element 
var keyword = document.getElementById('keyword');
var container = document.getElementById('container');

// add event search function
keyword.addEventListener('keyup', function() {
	
	// create ajax object
	var xhr = new XMLHttpRequest();
	
	// check ajax
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			container.innerHTML = xhr.responseText;
		}
	}
	
	// action ajax
	xhr.open('GET', 'js/cari/cariSiswa.php?keyword=' + keyword.value, true);
	xhr.send();
});