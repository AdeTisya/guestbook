<?= $this->extend('template/admin_header_footer',  ['cssFile' => 'admin.css']) ?>
<?= $this->section('content-admin') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tamu</h1>
        <a href="<?= base_url('admin') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tamu</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <p class="form-control-static"><?= esc($tamu['nama']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Asal Instansi/Perusahaan</label>
                                <p class="form-control-static"><?= esc($tamu['dari']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <p class="form-control-static"><?= esc($tamu['asal']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <p class="form-control-static"><?= esc($tamu['no_telp']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p class="form-control-static"><?= esc($tamu['jenis_kelamin']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Jam Datang</label>
                                <p class="form-control-static"><?= date('d/m/Y H:i:s', strtotime($tamu['jam_datang'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keperluan</label>
                        <p class="form-control-static"><?= esc($tamu['keperluan']) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Tamu</h6>
                </div>
                <div class="card-body text-center">
                    <img src="<?= $tamu['foto_data'] ?>" class="img-fluid rounded" alt="Foto Tamu">
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body text-center">
                    <button class="btn btn-danger btn-icon-split delete-btn" data-id="<?= $tamu['id'] ?>">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Tamu</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data tamu ini?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger" id="deleteConfirm" href="#">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
// Delete button handler
document.querySelector('.delete-btn').addEventListener('click', function() {
    const id = this.getAttribute('data-id');
    document.getElementById('deleteConfirm').href = `<?= base_url('admin/tamu/delete/') ?>${id}`;
    $('#deleteModal').modal('show');
});
</script>

<?= $this->endSection() ?>