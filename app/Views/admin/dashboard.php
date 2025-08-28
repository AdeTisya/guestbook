<?php echo $this->extend('template/admin_header_footer', ['cssFile' => 'admin.css']); ?>
<?= $this->section('content-admin') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Buku Tamu</h1>
        <div class="d-none d-sm-inline-block">
            <span class="text-muted"><?= date('d F Y') ?></span>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row">
        <!-- Total Tamu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tamu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTamu ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tamu Hari Ini Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tamu Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tamuHariIni ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tamu Bulan Ini Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tamu Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tamuBulanIni ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tamu Perempuan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tamu Perempuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tamuPerempuan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tamu</h6>
            <div>
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control bg-light border-0 small" placeholder="Cari tamu..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($tamu as $t) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($t['nama']) ?></td>
                                <td><?= esc($t['dari']) ?></td>
                                <td><?= esc($t['asal']) ?></td>
                                <td><?= esc($t['no_telp']) ?></td>
                                <td><?= esc($t['jenis_kelamin']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($t['jam_datang'])) ?></td>
                                <td><?= esc($t['keperluan']) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/tamu/detail/' . $t['id']) ?>" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $t['id'] ?>" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php if (!empty($t['foto_data'])) : ?>
                                        <button class="btn btn-secondary btn-sm view-photo" data-photo="<?= $t['foto_data'] ?>" title="Lihat Foto">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Photo Preview Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" alt="Foto Tamu">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Confirmation Modal - Bootstrap 5 -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data tamu ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a class="btn btn-danger" id="deleteConfirm" href="#">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
<<<<<<< HEAD
// Fixed JavaScript for admin dashboard - remove duplicates and fix Bootstrap 5 compatibility

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }

    // Delete button handler - only one instance
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const deleteConfirm = document.getElementById('deleteConfirm');
            if (deleteConfirm) {
                deleteConfirm.href = `<?= base_url('admin/tamu/delete/') ?>${id}`;
            }
            
            // Bootstrap 5 compatible modal show
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });
=======
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
>>>>>>> 7c9c2ed095255f642d571be8b1a7b391c3da5af7
    });

    // View photo handler - only one instance
    document.querySelectorAll('.view-photo').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const photoData = this.getAttribute('data-photo');
            const modalPhoto = document.getElementById('modalPhoto');
            if (modalPhoto && photoData) {
                modalPhoto.src = photoData;
                const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                photoModal.show();
            }
        });
    });


    // Modal close handlers
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        });
    });
});
</script>

<?= $this->endSection() ?>