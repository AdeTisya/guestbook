<?= $this->extend('template/admin_header_footer_print') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="text-center mb-4">
        <h3>BUKU TAMU DISKOMINFO GUNUNGKIDUL</h3>
        <h5>DATA KUNJUNGAN TAMU</h5>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="border p-3">
                <img src="<?= $tamu['foto_data'] ?>" class="img-fluid" alt="Foto Tamu">
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama</th>
                    <td><?= esc($tamu['nama']) ?></td>
                </tr>
                <tr>
                    <th>Asal Instansi</th>
                    <td><?= esc($tamu['dari']) ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= esc($tamu['asal']) ?></td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td><?= esc($tamu['no_telp']) ?></td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td><?= esc($tamu['jenis_kelamin']) ?></td>
                </tr>
                <tr>
                    <th>Jam Datang</th>
                    <td><?= date('d/m/Y H:i', strtotime($tamu['jam_datang'])) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mb-4">
        <h5>Keperluan</h5>
        <div class="border p-3">
            <?= esc($tamu['keperluan']) ?>
        </div>
    </div>

    <div class="text-right mt-5">
        <div class="d-inline-block text-center">
            <div class="border-top pt-2" style="width: 150px;">
                Petugas
            </div>
        </div>
    </div>

    <script <?= csp_script_nonce() ?>>
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>
</div>

<?= $this->endSection() ?>