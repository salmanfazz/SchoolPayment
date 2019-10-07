<?php
require '../../function.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM dev_tagihan_m
			WHERE nim LIKE '%$keyword%' OR
			tanggal LIKE '%$keyword%' OR
			keterangan LIKE '%$keyword%'
			";
$tag = query($query);
?>
<table id="dtBasicExample" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="th-sm">No Tagihan</th>
			<th class="th-sm">NIM</th>
			<th class="th-sm">Tanggal</th>
			<th class="th-sm">Keterangan</th>
			<th class="th-sm">Aksi</th>
		</tr>
	</thead>
	<?php foreach( $tag as $row ) : ?>
	<tbody>
		<tr>
			<td><?= $row["no_tagihan"]; ?></td>
			<td><?= $row["nim"]; ?></td>
			<td><?= $row["tanggal"]; ?></td>
			<td><?= $row["keterangan"]; ?></td>
			<td>
				<a class="btn btn-primary" href="editTag.php?no_tagihan=<?= $row["no_tagihan"]; ?>">Edit</a>
				<a class="btn btn-danger" href="deleteTag.php?no_tagihan=<?= $row["no_tagihan"]; ?>" onclick="return confirm('Are You Serious?');">Delete</a>
			</td>
		</tr>
	</tbody>
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