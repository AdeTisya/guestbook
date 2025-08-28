<?= $this->extend('template/admin_header_footer_print') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="text-center mb-4">
        <h3>BUKU TAMU DISKOMINFO GUNUNGKIDUL</h3>
        <h5>DATA KUNJUNGAN TAMU</h5>
        <hr>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="border p-3 text-center">
                <?php if (!empty($tamu['foto_data'])): ?>
                    <img src="<?= $tamu['foto_data'] ?>" class="img-fluid" alt="Foto Tamu" style="max-height: 200px;">
                <?php else: ?>
                    <div class="bg-light p-4">
                        <i class="fas fa-user fa-3x text-muted"></i>
                        <p class="mt-2 text-muted">Foto tidak tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th width="35%">Nama</th>
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
            <?= nl2br(esc($tamu['keperluan'])) ?>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="text-center">
                <div style="height: 80px;"></div>
                <div class="border-top pt-2" style="width: 200px; margin: 0 auto;">
                    Tamu
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <div style="height: 80px;"></div>
                <div class="border-top pt-2" style="width: 200px; margin: 0 auto;">
                    Petugas
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <small class="text-muted">
            Dicetak pada: <?= date('d F Y, H:i') ?> WIB
        </small>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
    // Auto print when page loads
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 500);
    });

    // Close window after printing
    window.addEventListener('afterprint', function() {
        window.close();
    });

    // Fallback for browsers that don't support afterprint
    setTimeout(function() {
        window.close();
    }, 5000);
</script>

<?= $this->endSection() ?>