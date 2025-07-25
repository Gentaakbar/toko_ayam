<!DOCTYPE html>
<html>

<head>
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
        <center>LAPORAN DATA PENJUALAN</center>
    </h3>
    <br />
    <div class="row">
        <table class="table-data">
            <thead>
                <tr>
                    <th>No Penjualan</th>
                    <th>Nama Kasir</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_penjualan as $penjualan): ?>
                    <tr>
                        <td><?= $penjualan->no_penjualan ?></td>
                        <td><?= $penjualan->nama_kasir ?></td>
                        <td><?= $penjualan->tgl_penjualan ?> Pukul <?= $penjualan->jam_penjualan ?></td>
                        <td>Rp <?= number_format($penjualan->total, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        window.print(); 
    </script>
</body>

</html>