<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Barang</title>
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
        <center>LAPORAN DATA BARANG</center>
    </h3>
    <br />
    <table class="table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($all_barang as $barang): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($barang->kode_barang); ?></td>
                    <td><?= htmlspecialchars($barang->nama_barang); ?></td>
                    <td>Rp <?= number_format($barang->harga_jual, 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($barang->stok); ?>     <?= strtoupper(htmlspecialchars($barang->satuan)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>