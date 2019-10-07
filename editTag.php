<?php
session_start();

if(!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'function.php';

// get data
$no_tagihan = $_GET["no_tagihan"];

// query -> nim
$tag = query("SELECT * FROM dev_tagihan_m WHERE no_tagihan = '$no_tagihan'")[0];
$sis = query("SELECT * FROM dev_siswa");
$det = query("SELECT dev_tagihan_d.`kode_jenis`, dev_jenis.`nama`, dev_tagihan_d.`nilai` 
				FROM dev_tagihan_d, dev_jenis
			WHERE dev_tagihan_d.`kode_jenis` = dev_jenis.`kode_jenis` && no_tagihan = '$no_tagihan'");

// cek tombol submit sudah ditekan atau belum
if ( isset($_POST["submit"]) ) {	
	// cek success or not
	if( editTag($_POST) > 0 ) {
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
}
?>
<html>
	<head>
		<title> Data Tagihan </title>
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
				<a class="btn btn-dark" href="tagihan.php">Back</a>
				<h1 class="mt-4">Data Tagihan</h1>
				<div class="container">
					<form action="" method="post">
						<div class="form-group row">
							<label for="nim" class="col-sm-2 col-form-label">NIM</label>
							<div class="col-sm-10">
								<select name="nim">
									<option value="">-- Pilih NIM --</option>
									<?php foreach( $sis as $row ) : ?>
									<option value="<?=$row["nim"]?>" <?= @$tag['nim'] == $row['nim'] ? 'selected' : ''?>><?=$row["nim"]?> - <?=$row["nama"]?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
							<div class="col-sm-10">
								<input type="date" class = "form-control" name="tanggal" value="<?=$tag["tanggal"] ?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?=$tag["keterangan"]?>">
							</div>
						</div>
						<button class="btn btn-primary" name="submit">Save</button>
						<a class="btn btn-success" href="tambahDataTag.php?no_tagihan=<?=$tag["no_tagihan"]?>">Tambah Tagihan</a>
					</form>
					<table id="dtBasicExample" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="th-sm">No</th>
							<th class="th-sm">Kode Jenis Tagihan</th>
							<th class="th-sm">Jenis Tagihan</th>
							<th class="th-sm">Nilai</th>
							<th class="th-sm">Aksi</th>
						</tr>
					</thead>
						<?php $i=1; ?>
						<?php foreach( $det as $rows ) : ?>
					<tbody>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $rows["kode_jenis"]; ?></td>
							<td><?= $rows["nama"]; ?></td>
							<td><?= $rows["nilai"]; ?></td>
							<td>
								<a class="btn btn-primary" href="editDataTag.php?no_tagihan=<?= $_GET["no_tagihan"]; ?>&kode_jenis=<?= $rows["kode_jenis"]; ?>">Edit</a>
								<a class="btn btn-danger" href="deleteDataTag.php?nilai=<?= $rows["nilai"]; ?>&no_tagihan=<?= $no_tagihan; ?>" onclick="return confirm('Are You Serious?');">Delete</a>
							</td>
						</tr>
					</tbody>
						<?php $i++; ?>
						<?php endforeach; ?>
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