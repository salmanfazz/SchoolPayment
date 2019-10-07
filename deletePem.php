<?php
require 'function.php';

$no_bayar = $_GET["no_bayar"];

if( deletePem($no_bayar) > 0 ) {
		echo "
			<script>
				alert('Success');
				document.location.href = 'pembayaran.php';
			</script>
			";
	} else {
		echo "
			<script>
				alert('Failed');
				document.location.href = 'pembayaran.php';
			</script>
			";
	}
?>