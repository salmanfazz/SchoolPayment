<?php
session_start();
require 'function.php';

//cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];
	
	// get username by id
	$result = mysqli_query($con, "SELECT username FROM dev_admin WHERE id = '$id'");
	$row = mysqli_fetch_assoc($result);
	
	//cek cookie & username
	if( $key == hash('sha256', $row['username']) ) {
		$_SESSION['login'] = true;
	}
}

if(isset($_SESSION["login"])) {
	header("Location: index.php");
	exit;
}

// cek tombol login sudah ditekan atau belum
if ( isset($_POST["login"]) ) {	

	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$result = mysqli_query($con, "SELECT * FROM dev_admin WHERE username = '$username'");
	// cek username 
	if(mysqli_num_rows($result) == 1){	
		// cek password
		$rows = mysqli_fetch_assoc($result);
		if (password_verify($password, $rows["password"])) {
			//set session
			$_SESSION["login"] = true;
			
			//cek rememer
			if(isset($_POST['remember'])) {
				//set cookie
				setcookie('id', $rows['id'], time()+60);
				setcookie('key', hash('sha256', $rows['username']), time()+60);
			}
			
			header("Location: index.php");
			exit;
		}
	}
	
	$error = true;
}
?>
<html>
	<head>
		<title> Halaman Login </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		<div id="login">
			<h3 class="text-center text-white pt-5">Login form</h3>
			<div class="container">
				<div id="login-row" class="row justify-content-center align-items-center">
					<div id="login-column" class="col-md-6">
						<div id="login-box" class="col-md-12">
							<form id="login-form" class="form" action="" method="post">
								<h3 class="text-center text-info">Login School</h3>
								<div class="form-group">
									<label for="username" class="text-info">Username:</label><br>
									<input type="text" name="username" id="username" class="form-control">
								</div>
								<div class="form-group">
									<label for="password" class="text-info">Password:</label><br>
									<input type="password" name="password" id="password" class="form-control">
								</div>
								<div class="form-group">
									<label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember" name="remember" type="checkbox"></span></label><br>
									<input type="submit" name="login" class="btn btn-info btn-md" value="Login">
								</div>
								<div id="register-link" class="text-right">
									<a href="register.php" class="text-info">Register</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>