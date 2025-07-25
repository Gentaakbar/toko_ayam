<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengguna</title>
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
    <h3><center>LAPORAN DATA PENGGUNA</center></h3>
    <br/>
    <div class="row">
        <table class="table-data">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode Pengguna</th>
					<th>Nama Pengguna</th>
					<th>Username</th>
					<th>Password</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($all_pengguna as $pengguna): ?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $pengguna->kode_pengguna ?></td>
						<td><?= $pengguna->nama_pengguna ?></td>
						<td><?= $pengguna->username_pengguna ?></td>
						<td><?= $pengguna->password_pengguna ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</body>
</html>