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
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#exportModal">
                    <i class="fas fa-file-export fa-sm"></i> Export
                </button>
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
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Tamu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" alt="Foto Tamu">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Data Tamu</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportForm" action="<?= base_url('admin/export') ?>" method="post">
                    <div class="form-group">
                        <label for="exportFormat">Format Export</label>
                        <select class="form-control" id="exportFormat" name="format">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dateRange">Rentang Tanggal</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">s/d</span>
                            </div>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="button" id="exportSubmit">Export</button>
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
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Delete button handler
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        document.getElementById('deleteConfirm').href = `<?= base_url('admin/tamu/delete/') ?>${id}`;
        $('#deleteModal').modal('show');
    });
});

// Export submit handler
document.getElementById('exportSubmit').addEventListener('click', function() {
    document.getElementById('exportForm').submit();
});

// View photo handler
document.querySelectorAll('.view-photo').forEach(btn => {
    btn.addEventListener('click', function() {
        const photoData = this.getAttribute('data-photo');
        document.getElementById('modalPhoto').src = photoData;
        $('#photoModal').modal('show');
    });
});

// Cancel button handler for modals
document.querySelectorAll('[data-dismiss="modal"]').forEach(btn => {
    btn.addEventListener('click', function() {
        $(this).closest('.modal').modal('hide');
    });
});

document.querySelectorAll('.view-photo').forEach(btn => {
    btn.addEventListener('click', function() {
        const photoData = this.getAttribute('data-photo');
        document.getElementById('modalPhoto').src = photoData;
        $('#photoModal').modal('show');
    });
});

// Delete button handler
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        document.getElementById('deleteConfirm').href = `<?= base_url('admin/tamu/delete/') ?>${id}`;
        $('#deleteModal').modal('show');
    });
});

// Export submit handler
document.getElementById('exportSubmit').addEventListener('click', function() {
    document.getElementById('exportForm').submit();
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#dataTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>