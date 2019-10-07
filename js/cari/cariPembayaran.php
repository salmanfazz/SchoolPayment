<?php
require '../../function.php';

$keyword = $_GET["keyword"];

$query = "SELECT * FROM dev_bayar_m
			WHERE nim LIKE '%$keyword%' OR
			tanggal LIKE '%$keyword%' OR
			keterangan LIKE '%$keyword%' OR
			periode LIKE '%$keyword%' 
			";
$pem = query($query);
?>
<table id="dtBasicExample" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="th-sm">No Pembayaran</th>
			<th class="th-sm">NIM</th>
			<th class="th-sm">Tanggal</th>
			<th class="th-sm">Keterangan</th>
			<th class="th-sm">Periode</th>
			<th class="th-sm">Aksi</th>
	</tr>
	</thead>
	<?php foreach( $pem as $row ) : ?>
	<tbody>
		<tr>
			<td><?= $row["no_bayar"]; ?></td>
			<td><?= $row["nim"]; ?></td>
			<td><?= $row["tanggal"]; ?></td>
			<td><?= $row["keterangan"]; ?></td>
			<td><?= $row["periode"]; ?></td>
			<td>
				<a class="btn btn-primary" href="editPem.php?no_bayar=<?= $row["no_bayar"]; ?>&nim=<?=$row["nim"]?>">Edit</a>
				<a class="btn btn-danger" href="deletePem.php?no_bayar=<?= $row["no_bayar"]; ?>" onclick="return confirm('Are You Serious?');">Delete</a>
			</td>
		</tr>
	</tbody>
	<?php endforeach; ?>		
	<tfoot>
		<tr>
			<th class="th-sm">No Pembayaran</th>
			<th class="th-sm">NIM</th>
			<th class="th-sm">Tanggal</th>
			<th class="th-sm">Keterangan</th>
			<th class="th-sm">Periode</th>
			<th class="th-sm">Aksi</th>
		</tr>
	</tfoot>
</table>