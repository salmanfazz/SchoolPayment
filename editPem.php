<?php
session_start();

if(!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'function.php';

// get data
$nim = $_GET["nim"];
$no_bayar = $_GET["no_bayar"];

// query -> nim
$pem = query("SELECT * FROM dev_bayar_m WHERE nim = '$nim'")[0];
$sis = query("SELECT * FROM dev_siswa");
$det = query("SELECT dev_tagihan_d.`no_tagihan`, dev_tagihan_m.`keterangan`, dev_tagihan_d.`nilai`
				FROM dev_tagihan_d, dev_tagihan_m, dev_bayar_m
				WHERE dev_tagihan_m.`no_tagihan` = dev_tagihan_d.`no_tagihan` && dev_tagihan_m.`nim` = dev_bayar_m.`nim` && dev_tagihan_m.`nim` = '$nim'
				");

// cek tombol submit sudah ditekan atau belum
if ( isset($_POST["submit"]) ) {	
	// cek success or not
	if( editPem($_POST) > 0 ) {
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
}

if ( isset($_POST["bayar"]) ) {	
	// cek success or not
	if( bayar($_POST) > 0 ) {
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
}
?>
<html>
	<head>
		<title> Data Pembayaran </title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- DataTables CSS -->
		<link href="css/addons/datatables.min.css" rel="stylesheet">
		<!-- DataTables JS -->
		<script href="js/addons/datatables.min.js" rel="stylesheet"></script>
		<!-- DataTables Select CSS -->
		<link href="css/addons/datatables-select.min.css" rel="stylesheet">
		<!-- DataTables Select JS -->
		<script href="js/addons/datatables-select.min.js" rel="stylesheet"></script>		
		<link href="css/simple-sidebar.css" rel="stylesheet">
	</head>
	<body>
		<div class="d-flex" id="wrapper">
			<!-- Sidebar -->
			<div class="bg-dark border-right" id="sidebar-wrapper">
					<div class="list-group list-group-flush">
						<a href="index.php" class="list-group-item list-group-item-action bg-dark text-light">Dashboard</a>
						<a href="siswa.php" class="list-group-item list-group-item-action bg-dark text-light">Data Siswa</a>
						<a href="pembayaran.php" class="list-group-item list-group-item-action bg-dark text-light">Data Pembayaran</a>
						<a href="tagihan.php" class="list-group-item list-group-item-action bg-dark text-light">Data Tagihan</a>
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
				<a class="btn btn-dark" href="pembayaran.php">Back</a>
				<h1 class="mt-4">Data Pembayaran</h1>
				<div class="container">
					<form action="" method="post">
						<input type="hidden" name="no_bayar" value="<?=$pem["no_bayar"];?>" />
						<div class="form-group row">
							<label for="nim" class="col-sm-2 col-form-label">NIM</label>
							<div class="col-sm-10">
								<select name="nim">
									<option value="">-- Pilih NIM --</option>
									<?php foreach( $sis as $row ) : ?>
									<option value="<?=$row["nim"]?>" <?= @$pem['nim'] == $row['nim'] ? 'selected' : ''?>><?=$row["nim"]?> - <?=$row["nama"]?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
							<div class="col-sm-10">
								<input type="date" class = "form-control" name="tanggal" value="<?=$pem["tanggal"] ?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?=$pem["keterangan"]?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="periode" class="col-sm-2 col-form-label">Periode</label>
							<div class="col-sm-10">
								<input type="text" class = "form-control" name="periode" pattern="[0-9]{4}/[0-9]{2}" placeholder="yyyy/dd" value="<?=$pem["periode"]?>">
							</div>
						</div>
						<button class="btn btn-primary" name="submit">Submit</button>
					</form>
					<table id="dtBasicExample" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="th-sm">No Tagihan</th>
							<th class="th-sm">Keterangan</th>
							<th class="th-sm">Nilai Tagihan</th>
							<th class="th-sm">Aksi</th>
						</tr>
							<?php foreach($det as $rows) :?>
						<tbody>
							<tr>
							<form action="" method="post">
								<input type="hidden" name="no_bayar" value="<?=$pem["no_bayar"];?>" />
								<td><?= $rows["no_tagihan"]; ?></td>
								<input type="hidden" name="no_tagihan" value="<?=$rows["no_tagihan"];?>" />
								<td><?= $rows["keterangan"]; ?></td>
								<td><?= $rows["nilai"]; ?></td>
								<input type="hidden" name="nilai" value="<?=$rows["nilai"];?>" />
								<td>
									<button class="btn btn-primary" name="bayar" onclick="return confirm('Are You Serious?');">Bayar</button>
								</td>
							</form>
							</tr>
						</tbody>
							<?php endforeach; ?>
					</thead>
				</table>
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
	</body>
</html>