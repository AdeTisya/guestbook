<?= $this->extend('template/header_footer_auth', ['cssFile' => 'userform.css']); ?>
<?= $this->section('content-auth') ?>

<!-- Flash Message Alert -->
<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-<?= session()->getFlashdata('message_type') === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="main-container">

<div class="head-admin"  ?>
    ADMIN
</div>
    <div class="background-accent"></div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row g-2 g-md-3 align-items-start">
                    
                    <!-- LEFT COLUMN: WELCOME SECTION -->
                    <div class="col-lg-4 col-md-12 order-1 order-lg-1">
                        <div class="welcome-section">
                            <!-- Logo Container -->
                            <div id="logogk" class="text-center mb-3">
                                <img src="<?= base_url('dokumen/icon/logoGK.png') ?>" 
                                     alt="Logo Gunungkidul" 
                                     class="img-fluid">
                            </div>

                            <!-- Icon Container -->
                            <div id="icongk" class="text-center mb-3">
                                <img src="<?= base_url('dokumen/icon/iconGk.png') ?>" 
                                     alt="Icon Gunungkidul" 
                                     class="img-fluid">
                            </div>
                            
                            <h1 class="welcome-title">
                                Selamat Datang di Portal Buku Tamu diskominfo Gunungkidul
                            </h1>
                            <p class="welcome-description">
                                Silakan lengkapi data kunjungan Anda untuk keperluan dokumentasi dan pelayanan.
                            </p>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: FORM SECTION -->
                    <div class="col-lg-8 col-md-12 order-2 order-lg-2">
                        <div class="form-container">
                            <div class="row g-2">
                                
                                <!-- FORM INPUTS -->
                                <div class="col-lg-8 col-md-7 col-12">
                                    <form method="POST" enctype="multipart/form-data" id="tamuForm">
                                        <?= csrf_field() ?>
                                        
                                        <div class="mb-2">
                                            <label for="nama" class="form-label">Nama : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama" name="nama" 
                                                   placeholder="Masukkan nama lengkap" required>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="dari" class="form-label">Dari : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="dari" name="dari" 
                                                   placeholder="Contoh: PT. Handayani (Bapak Alex)" required>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="jam_datang" class="form-label">Jam Datang : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="jam_datang" name="jam_datang" 
                                                placeholder="Loading waktu..." readonly required>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label class="form-label">Alamat/Asal : <span class="text-danger">*</span></label>
                                            <div class="row g-1">
                                                <div class="col-12">
                                                    <input type="text" class="form-control mt-1" id="asal" name="asal" 
                                                           placeholder="Alamat lengkap (jalan, RT/RW)" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="no_telp" class="form-label">No. Telepon : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="no_telp" name="no_telp" 
                                                   placeholder="Contoh: 081390123163" required>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin : <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                <?php foreach ($genders as $gender): ?>
                                                    <option value="<?= $gender ?>"><?= $gender ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="keperluan" class="form-label">Keperluan : <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="keperluan" name="keperluan" rows="2" 
                                                      placeholder="Jelaskan keperluan Anda" required></textarea>
                                        </div>
                                        
                                        <input type="hidden" id="foto_data" name="foto_data" required>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-submit">
                                                <i class="fas fa-paper-plane me-1"></i> KIRIM
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- PHOTO CAPTURE SECTION -->
                                <div class="col-lg-4 col-md-5 col-12">
                                    <div class="photo-section">
                                        <h5 class="text-center mb-2">Foto Tamu <span class="text-danger">*</span></h5>
                                        <img id="photo-preview" class="photo-preview" 
                                             src="data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='%23f8f9fa'/%3E%3Ccircle cx='100' cy='100' r='40' fill='%236c757d'/%3E%3Cpath d='M100 80 L100 120 M80 100 L120 100' stroke='white' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E" 
                                             alt="Photo preview">
                                        <div class="text-center mt-2">
                                            <button type="button" class="btn btn-capture" id="open-camera">
                                                <i class="fas fa-camera me-1"></i> Ambil Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CONTACT INFORMATION -->
    <div class="contact-section">
        <div class="container">
            <div class="row justify-content-center g-1">
                <div class="col-auto">
                    <div class="contact-item">
                        <i class="fab fa-instagram"></i>
                        <span>kominfoGunungkidul</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>kominfo@Gunungkidulkab.go.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CAMERA MODAL -->
<div class="modal fade" id="camera-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-camera me-2"></i> Ambil Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <video id="camera-view" class="camera-view img-fluid" autoplay playsinline></video>
                <canvas id="camera-canvas" style="display:none;"></canvas>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-camera" id="capture-btn">
                    <i class="fas fa-camera me-2"></i> Ambil Foto
                </button>
            </div>
        </div>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
// Inisialisasi variabel kamera
let cameraModal = null;
let cameraStream = null;
let shouldSubmit = false;

// Fungsi untuk memeriksa dukungan kamera
function checkCameraSupport() {
    return !!navigator.mediaDevices && !!navigator.mediaDevices.getUserMedia;
}

// Fungsi untuk menampilkan error kamera
function showCameraError(error) {
    let errorMessage = "Mohon izinkan akses kamera untuk melanjutkan.";
    
    if (error.name === 'NotAllowedError') {
        errorMessage = "Akses kamera ditolak. Mohon berikan izin kamera di pengaturan browser.";
    } else if (error.name === 'NotFoundError') {
        errorMessage = "Tidak ditemukan perangkat kamera.";
    } else if (error.name === 'NotReadableError') {
        errorMessage = "Kamera sedang digunakan oleh aplikasi lain.";
    } else if (error.name === 'OverconstrainedError') {
        errorMessage = "Kamera tidak mendukung resolusi yang diminta.";
    }
    
    Swal.fire({
        icon: 'error',
        title: 'Kamera Tidak Dapat Diakses',
        html: `${errorMessage}<br><br>
              <strong>Pastikan:</strong><br>
              1. Anda menggunakan HTTPS atau localhost<br>
              2. Tidak ada aplikasi lain yang menggunakan kamera<br>
              3. Browser mendukung WebRTC (Chrome/Firefox/Edge terbaru)<br>
              4. Anda telah memberikan izin kamera`,
        confirmButtonColor: '#3085d6',
    });
}

// Fungsi untuk memulai kamera
async function startCamera(videoElement) {
    try {
        // Hentikan stream sebelumnya jika ada
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        
        // Dapatkan stream kamera
        cameraStream = await navigator.mediaDevices.getUserMedia({ 
            video: {
                facingMode: 'user',  // Gunakan kamera depan
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: false
        });
        
        // Hubungkan stream ke video element
        videoElement.srcObject = cameraStream;
        
        // Pastikan video bisa diputar
        return new Promise((resolve) => {
            videoElement.onloadedmetadata = () => {
                videoElement.play()
                    .then(() => resolve(true))
                    .catch(err => {
                        console.error("Gagal memutar video:", err);
                        resolve(false);
                    });
            };
        });
    } catch (err) {
        console.error("Error kamera:", err);
        showCameraError(err);
        return false;
    }
}

// Fungsi untuk mengambil foto
function capturePhoto() {
    if (!cameraStream) {
        console.error("Stream kamera tidak tersedia");
        return;
    }
    
    const video = document.getElementById('camera-view');
    const canvas = document.getElementById('camera-canvas');
    const photoPreview = document.getElementById('photo-preview');
    
    try {
        // Atur ukuran canvas sesuai video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Gambar frame saat ini ke canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Konversi ke base64 (JPEG dengan kualitas 80%)
        const photoData = canvas.toDataURL('image/jpeg', 0.8);
        document.getElementById('foto_data').value = photoData;
        photoPreview.src = photoData;
        
        // Tutup modal kamera
        if (cameraModal) {
            cameraModal.hide();
        }
        
        // Jika form menunggu submit, kirim sekarang
        if (shouldSubmit) {
            document.getElementById('tamuForm').submit();
        }
    } catch (error) {
        console.error("Error mengambil foto:", error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal Mengambil Foto',
            text: 'Terjadi kesalahan saat mencoba mengambil foto',
            confirmButtonColor: '#3085d6',
        });
    }
}

// Fungsi untuk membersihkan stream kamera
function cleanupCamera() {
    if (cameraStream) {
        cameraStream.getTracks().forEach(track => {
            track.stop();
        });
        cameraStream = null;
    }
    
    const video = document.getElementById('camera-view');
    if (video) {
        video.srcObject = null;
    }
}

// Fungsi untuk update jam
function updateRealTimeClock() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    document.getElementById('jam_datang').value = 
        `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}

// Ketika dokumen siap
document.addEventListener('DOMContentLoaded', function() {
    // Periksa dukungan kamera di browser
    if (!checkCameraSupport()) {
        Swal.fire({
            icon: 'error',
            title: 'Browser Tidak Mendukung',
            text: 'Browser Anda tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Edge terbaru.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    // Inisialisasi modal Bootstrap
    try {
        cameraModal = new bootstrap.Modal(document.getElementById('camera-modal'));
    } catch (error) {
        console.error("Gagal inisialisasi modal:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error Sistem',
            text: 'Gagal mempersiapkan kamera. Silakan refresh halaman.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }
    
    // Event ketika modal kamera dibuka
    document.getElementById('camera-modal').addEventListener('shown.bs.modal', async function() {
        const video = document.getElementById('camera-view');
        
        // Kosongkan source sebelumnya
        video.srcObject = null;
        
        // Mulai kamera
        const cameraStarted = await startCamera(video);
        
        if (!cameraStarted) {
            shouldSubmit = false;
            cameraModal.hide();
        }
    });

    // Event ketika modal kamera ditutup
    document.getElementById('camera-modal').addEventListener('hidden.bs.modal', function() {
        // Hentikan kamera ketika modal ditutup
        cleanupCamera();
    });
    
    // Tombol ambil foto
    document.getElementById('capture-btn').addEventListener('click', capturePhoto);
    
    // Tombol buka kamera manual
    document.getElementById('open-camera').addEventListener('click', function() {
        shouldSubmit = false;
        cameraModal.show();
    });
    
    // Update jam secara real-time
    updateRealTimeClock();
    setInterval(updateRealTimeClock, 1000);
    
    // Navigasi admin
    document.querySelector('.head-admin').addEventListener('click', function() {
        window.location.href = "<?= base_url('login') ?>";
    });
    
    // Validasi form sebelum submit
    document.getElementById('tamuForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateRealTimeClock();
        
        // Validasi field wajib
        let isValid = true;
        const fields = ['nama', 'dari', 'asal', 'no_telp', 'jenis_kelamin', 'keperluan'];
        
        fields.forEach(field => {
            const element = document.getElementById(field);
            if (!element.value) {
                element.classList.add('is-invalid');
                isValid = false;
            } else {
                element.classList.remove('is-invalid');
            }
        });

        // Validasi format nomor telepon
        const noTelp = document.getElementById('no_telp').value;
        if (noTelp && !/^[0-9]+$/.test(noTelp)) {
            document.getElementById('no_telp').classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Form Belum Lengkap',
                text: 'Harap lengkapi semua field yang wajib diisi dengan benar',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Cek apakah foto sudah diambil
        if (!document.getElementById('foto_data').value) {
            shouldSubmit = true;
            cameraModal.show();
        } else {
            this.submit();
        }
    });
    
    // Highlight field yang kosong
    document.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Bersihkan kamera saat halaman ditutup
    window.addEventListener('beforeunload', cleanupCamera);
});
</script>

<?= $this->endSection() ?>