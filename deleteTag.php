<?php
require 'function.php';

$no_tagihan = $_GET["no_tagihan"];

if( deleteTag($no_tagihan) > 0 ) {
		echo "
			<script>
				alert('Success');
				document.location.href = 'tagihan.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Failed');
				document.location.href = 'tagihan.php';
			</script>
			";
	}
?>