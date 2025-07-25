<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<style type="text/css">
		.table-data {
			width: 100%;
			border-collapse: collapse;
		}

		.table-data tr th,
		.table-data tr td {
			border: 1px solid black;
			font-size: 11pt;
			font-family: Verdana;
			padding: 10px;
		}

		.table-data th {
			background-color: LightGray;
		}

		h3 {
			font-family: Verdana;
		}
	</style>
</head>

<body>
	<h3>
		<center>LAPORAN DETAIL PENJUALAN</center>
	</h3>
	<hr />
	<div class="row">
		<div class="col-md-4">
			<table class="table table-borderless">
				<tr>
					<td><strong>No Penjualan</strong></td>
					<td>:</td>
					<td><?= $penjualan->no_penjualan ?></td>
				</tr>
				<tr>
					<td><strong>Nama Kasir</strong></td>
					<td>:</td>
					<td><?= $penjualan->nama_kasir ?></td>
				</tr>
				<tr>
					<td><strong>Waktu Penjualan</strong></td>
					<td>:</td>
					<td><?= $penjualan->tgl_penjualan ?> - <?= $penjualan->jam_penjualan ?></td>
				</tr>
			</table>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-data">
				<thead>
					<tr>
						<th><strong>No</strong></th>
						<th><strong>Nama Produk</strong></th>
						<th><strong>Harga Produk</strong></th>
						<th><strong>Jumlah</strong></th>
						<th><strong>Sub Total</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($all_detail_penjualan as $detail_penjualan): ?>
						<tr>
							<td><?= $no++ ?></td>
							<td><?= $detail_penjualan->nama_barang ?></td>
							<td>Rp <?= number_format($detail_penjualan->harga_barang, 0, ',', '.') ?></td>
							<td><?= $detail_penjualan->jumlah_barang ?> 	<?= strtoupper($detail_penjualan->satuan) ?></td>
							<td>Rp <?= number_format($detail_penjualan->sub_total, 0, ',', '.') ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" align="right"><strong>Total : </strong></td>
						<td>Rp <?= number_format($penjualan->total, 0, ',', '.') ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		window.print(); 
	</script>
</body>

</html>