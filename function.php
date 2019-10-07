<?php

	//koneksi db
	$con = mysqli_connect("119.235.255.105","root","Saisai2019","dbmagang");
	function query($query) {
		global $con;
		$result = mysqli_query($con, $query);
		$rows = [];
		while( $row = mysqli_fetch_assoc($result) ) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	function hitung($hitung) {
		global $con;
		$result = mysqli_query($con, $hitung);
		$rowcount = mysqli_num_rows($result);
		mysqli_free_result($result);
		return $rowcount;
	}
	
	function register($data) {
		global $con;
		$username = strtolower(stripslashes($data["username"]));
		$password = mysqli_real_escape_string($con, $data["password"]);
		$confirm = mysqli_real_escape_string($con, $data["password"]);
		
		//cek username sudah ada atau belum
		$result = mysqli_query($con, "SELECT username FROM dev_admin WHERE username = '$username'");
		if(mysqli_fetch_assoc($result)) {
			echo"<script>
				alert('Username sudah Terdaftar!'); 
				</script>";
			return false;
		}
		
		// cek password sama
		if($password != $confirm) {
			echo"<script>
				alert('Confirm Password Tidak Sesuai'); 
				</script>";
			return false;
		}
		
		//enkripsi password
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		// tambah user ke db
		mysqli_query($con, "INSERT INTO dev_admin VALUES('', '$username', '$password')");
		return mysqli_affected_rows($con);
	}
	
	// tambah siswa
	function tambah($data) {
		global $con;
		$nim = htmlspecialchars($data["nim"]);
		$nama = htmlspecialchars($data["nama"]);
		$kode_jur = htmlspecialchars($data["kode_jur"]);
		
		$query = "INSERT INTO dev_siswa
				VALUES
				('$nim', '', '$nama','$kode_jur')
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//edit siswa
	function edit($data) {
		
		$nim = $data["nim"];
		global $con;
		$nim = htmlspecialchars($data["nim"]);
		$nama = htmlspecialchars($data["nama"]);
		$kode_jur = htmlspecialchars($data["kode_jur"]);
		
		$query = "UPDATE dev_siswa SET
					nim = '$nim',
					nama = '$nama',
					kode_jur = '$kode_jur'
				  WHERE nim = $nim;
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//delete siswa
	function delete($nim) {
		global $con;
		mysqli_query($con, "DELETE FROM dev_siswa WHERE nim = $nim");
		return mysqli_affected_rows($con);
	}
	
	//tambah tagihan
	function tambahTag($data) {
		global $con;
		$nim = htmlspecialchars($data["nim"]);
		$tanggal = $data["tanggal"];
		$keterangan = htmlspecialchars($data["keterangan"]);
		
		$query = "INSERT INTO dev_tagihan_m
				VALUES
				('', '', '$nim', '$tanggal','$keterangan', '')
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//edit tagihan
	function editTag($data) {
		
		$nim = $data["nim"];
		global $con;
		$nim = htmlspecialchars($data["nim"]);
		$tanggal = $data["tanggal"];
		$keterangan = htmlspecialchars($data["keterangan"]);
		
		$query = "UPDATE dev_tagihan_m SET
					nim = '$nim',
					tanggal = '$tanggal',
					keterangan = '$keterangan'
				  WHERE nim = $nim;
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//delete tagihan
	function deleteTag($no_tagihan) {
		global $con;
		mysqli_query($con, "DELETE FROM dev_tagihan_m WHERE no_tagihan = $no_tagihan");
		return mysqli_affected_rows($con);
	}
	
	//tambah data tagihan
	function tambahDataTag($data) {
		$no_tagihan = $_GET["no_tagihan"];
		global $con;
		$kode_jenis = htmlspecialchars($data["kode_jenis"]);
		$nilai = htmlspecialchars($data["nilai"]);
		
		$query = "INSERT INTO dev_tagihan_d
				VALUES
				('$no_tagihan', '', '$kode_jenis', '$nilai')
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//edit data tagihan
	function editDataTag($data) {
		
		$no_tagihan = $_GET["no_tagihan"];
		$kode_jenis = $data["kode_jenis"];
		global $con;
		$nilai = $data["nilai"];
		
		$query = "UPDATE dev_tagihan_d SET
					kode_jenis = '$kode_jenis',
					nilai = '$nilai'
				  WHERE no_tagihan = '$no_tagihan' && kode_jenis = '$kode_jenis';
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//delete data tagihan
	function deleteDataTag($nilai) {
		global $con;
		mysqli_query($con, "DELETE FROM dev_tagihan_d 
		WHERE nilai = $nilai");
		return mysqli_affected_rows($con);
	}
	
	//tambah pembayaran
	function tambahPem($data) {
		global $con;
		$nim = htmlspecialchars($data["nim"]);
		$tanggal = $data["tanggal"];
		$keterangan = htmlspecialchars($data["keterangan"]);
		$periode = htmlspecialchars($data["periode"]);
		
		$query = "INSERT INTO dev_bayar_m
				VALUES
				('', '', '$nim', '$tanggal','$keterangan', '$periode')
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//edit pembayaran
	function editPem($data) {
		
		$no_bayar = $data["no_bayar"];
		global $con;
		$nim = $data["nim"];
		$tanggal = $data["tanggal"];
		$keterangan = $data["keterangan"];
		$periode = $data["periode"];
		
		$query = "UPDATE dev_bayar_m SET
					nim = '$nim',
					tanggal = '$tanggal',
					keterangan = '$keterangan',
					periode = '$periode'
				  WHERE no_bayar = $no_bayar;
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//bayar
	function bayar($data) {
		
		global $con;
		$no_bayar = $data["no_bayar"];
		$no_tagihan = $data["no_tagihan"];
		$nilai = $data["nilai"];
		
		$query = "INSERT INTO dev_bayar_d
				VALUES
				('$no_bayar', '', '$no_tagihan', '$nilai')
				";
		mysqli_query($con, $query);
		
		return mysqli_affected_rows($con);
	}
	//delete pembayaran
	function deletePem($no_bayar) {
		global $con;
		mysqli_query($con, "DELETE FROM dev_bayar_m
		WHERE no_bayar = $no_bayar");
		return mysqli_affected_rows($con);
	}
?>