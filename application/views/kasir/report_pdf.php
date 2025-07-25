<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Kasir</title>
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
    <h3><center>LAPORAN DATA KASIR</center></h3>
    <br/>
    <div class="row">
        <table class="table-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Kasir</th>
                    <th>Nama Kasir</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($all_kasir as $kasir): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($kasir->kode_kasir) ?></td>
                        <td><?= htmlspecialchars($kasir->nama_kasir) ?></td>
                        <td><?= htmlspecialchars($kasir->username_kasir) ?></td>
                        <td><?= htmlspecialchars($kasir->password_kasir) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
