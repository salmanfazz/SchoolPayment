<?php
session_start();

if(!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'function.php';
// $sis = hitung("SELECT * FROM dev_siswa");
$tag = hitung("SELECT * FROM dev_tagihan_m");
$pem = hitung("SELECT * FROM dev_bayar_m");
$sis = hitung("SELECT * FROM dev_siswa");

$dataPoints = array( 
	array("y" => $sis, "label" => "Jumlah Siswa" ),
	array("y" => $tag, "label" => "Jumlah Tagihan" ),
	array("y" => $pem, "label" => "Jumlah Pembayaran" )
);
?>
<html>
	<head>
		<title> Dashboard </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link href="css/simple-sidebar.css" rel="stylesheet">
	</head>
	<body>
		<div class="d-flex" id="wrapper">
			<!-- Sidebar -->
			<div class="bg-dark border-right" id="sidebar-wrapper">
					<div class="list-group list-group-flush">
						<a href="index.php" class="list-group-item list-group-item-action bg-dark text-light">Dashboard</a>
						<a href="siswa.php" class="list-group-item list-group-item-action bg-dark text-light">Data Siswa</a>
						<a href="tagihan.php" class="list-group-item list-group-item-action bg-dark text-light">Data Tagihan</a>
						<a href="pembayaran.php" class="list-group-item list-group-item-action bg-dark text-light">Data Pembayaran</a>
					</div>
			</div>
			<!-- /#sidebar-wrapper -->
			<!-- Page Content -->
			<div id="page-content-wrapper">
				<nav class="navbar navbar-expand-lg navbar-light bg-secondary border-bottom">
					<button class="btn btn-primary" id="menu-toggle"><<<</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
							<li class="nav-item active">
								<a class="nav-link text-light" href="logout.php">Logout</a>
							</li>
						</ul>
					</div>
				</nav>
		<div class="container-fluid">
			<h1 class="mt-4">Dashboard</h1>
			<div class="row">
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-warning">
							<h5 class="card-title text-dark">Data Siswa</h5>
							<center><img src="icon/student.png" width="42%"/>
							<h1><?= $sis ?></h1></center>
						</div>
							<a href="siswa.php" class="btn btn-primary">Detail</a>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-success">
							<h5 class="card-title">Data Tagihan</h5>
							<center><img src="icon/bill.png" width="35%"/>
							<h1><?= $tag ?></h1></center>
						</div>
							<a href="tagihan.php" class="btn btn-primary">Detail</a>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-danger">
							<h5 class="card-title">Data Pembayaran</h5>
							<center><img src="icon/pay.png" width="40%"/>
							<h1><?= $pem ?></h1></center>
						</div>
							<a href="pembayaran.php" class="btn btn-primary">Detail</a>
					</div>
				</div>
				<div id="chartContainer" style="height: 370px; width: 100%;"></div>
				<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
			</div>
		</div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  
	  <!-- Menu Toggle Script -->
		<script>
			$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
			});
		</script>
		<script>
			window.onload = function() {
			 
			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				theme: "light2",
				title:{
					text: "Data Pembayaran dan Tagihan Siswa"
				},
				axisY: {
					title: "Data Pembayaran dan Tagihan Siswa (Bulan)"
				},
				data: [{
					type: "column",
					yValueFormatString: "#,##0.## tonnes",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();
			 
			}
		</script>
	</body>
</html>