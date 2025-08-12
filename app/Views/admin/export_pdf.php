<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?= base_url('css/export_pdf.css') ?>">
</head>
<body>
    <h2 class="text-center">DATA TAMU DISKOMINFO GUNUNGKIDUL</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Asal Instansi</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Jenis Kelamin</th>
                <th>Jam Datang</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $item): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($item['nama']) ?></td>
                <td><?= esc($item['dari']) ?></td>
                <td><?= esc($item['asal']) ?></td>
                <td><?= esc($item['no_telp']) ?></td>
                <td><?= esc($item['jenis_kelamin']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($item['jam_datang'])) ?></td>
                <td><?= esc($item['keperluan']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>