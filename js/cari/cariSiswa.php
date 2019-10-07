<?php
require '../../function.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM dev_siswa
			WHERE nim LIKE '%$keyword%' OR
			nama LIKE '%$keyword%' OR
			kode_jur LIKE '%$keyword%'
			";
$siswa = query($query);
?>
<table id="dtBasicExample" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="th-sm">No</th>
			<th class="th-sm">NIM</th>
			<th class="th-sm">Nama</th>
			<th class="th-sm">Kode Jurusan</th>
			<th class="th-sm">Aksi</th>
		</tr>
	</thead>
	<?php $i = 1; ?>
	<?php foreach( $siswa as $row ) : ?>
	<tbody>
		<tr>
			<td><?= $i; ?></td>
			<td><?= $row["nim"]; ?></td>
			<td><?= $row["nama"]; ?></td>
			<td><?= $row["kode_jur"]; ?></td>
			<td>
				<a class="btn btn-primary" href="edit.php?nim=<?= $row["nim"]; ?>">Edit</a>
				<a class="btn btn-danger" href="delete.php?nim=<?= $row["nim"]; ?>" onclick="return confirm('Are You Serious?');">Delete</a>
			</td>
		</tr>
	</tbody>
	<?php $i++ ?>
	<?php endforeach; ?>
	<tfoot>
		<tr>
			<th>No</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Kode Jurusan</th>
			<th>Aksi</th>
		</tr>
	</tfoot>
</table>