<?php
require 'function.php';

// cek tombol register sudah ditekan atau belum
if ( isset($_POST["register"]) ) {	
	// cek success or not
	if( register($_POST) > 0 ) {
		echo "
			<script>
				alert('Success');
			</script>
			";
	} else {
		echo "
			<script>
				alert('Failed');
			</script>
			";
	}
}
?>
<html>
	<head>
		<title> Halaman Register </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		<div id="login">
			<h3 class="text-center text-white pt-5">Register</h3>
			<div class="container">
				<div id="login-row" class="row justify-content-center align-items-center">
					<div id="login-column" class="col-md-6">
						<div id="login-box" class="col-md-12">
							<form id="login-form" class="form" action="" method="post">
								<h3 class="text-center text-info">Register</h3>
								<div class="form-group">
									<label for="username" class="text-info">Username:</label><br>
									<input type="text" name="username" id="username" class="form-control">
								</div>
								<div class="form-group">
									<label for="password" class="text-info">Password:</label><br>
									<input type="password" name="password" id="password" class="form-control">
								</div>
								<div class="form-group">
									<label for="confirm" class="text-info">Confirm Password:</label><br>
									<input type="password" name="confirm" id="confirm" class="form-control">
								</div>
								<div class="form-group">
									<input type="submit" name="register" class="btn btn-info btn-md" value="Sign Up">
								</div>
								<div id="register-link" class="text-right">
									<a href="login.php" class="text-info">Login</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>