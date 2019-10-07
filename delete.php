<?php
require 'function.php';

$nim = $_GET["nim"];

if( delete($nim) > 0 ) {
		echo "
			<script>
				alert('Success');
				document.location.href = 'siswa.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Failed');
				document.location.href = 'siswa.php';
			</script>
			";
	}
?>