<?= $this->extend('template/header_footer_auth', ['cssFile' => 'userform.css']); ?>
<?= $this->section('content-auth') ?>

<!-- Flash Message Alert -->
<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-<?= session()->getFlashdata('message_type') === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Validation Errors -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="main-container">
    <div class="head-admin">
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
                                    <form method="POST" action="<?= base_url('user/form/submit') ?>" enctype="multipart/form-data" id="tamuForm">
                                        <?= csrf_field() ?>
                                        
                                        <div class="mb-2">
                                            <label for="nama" class="form-label">Nama : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama" name="nama" 
                                                   placeholder="Masukkan nama lengkap" 
                                                   value="<?= old('nama') ?>" required>
                                            <div class="invalid-feedback" id="nama-error"></div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="dari" class="form-label">Dari : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="dari" name="dari" 
                                                   placeholder="Contoh: PT. Handayani (Bapak Alex)" 
                                                   value="<?= old('dari') ?>" required>
                                            <div class="invalid-feedback" id="dari-error"></div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="jam_datang" class="form-label">Jam Datang : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="jam_datang" name="jam_datang" 
                                                placeholder="Loading waktu..." readonly required
                                                value="<?= old('jam_datang') ?>">
                                            <div class="invalid-feedback" id="jam_datang-error"></div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label class="form-label">Alamat/Asal : <span class="text-danger">*</span></label>
                                            <div class="row g-1">
                                                <div class="col-12">
                                                    <input type="text" class="form-control mt-1" id="asal" name="asal" 
                                                           placeholder="Alamat lengkap (jalan, RT/RW)" 
                                                           value="<?= old('asal') ?>" required>
                                                    <div class="invalid-feedback" id="asal-error"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="no_telp" class="form-label">No. Telepon : <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="no_telp" name="no_telp" 
                                                   placeholder="Contoh: 081390123163" 
                                                   value="<?= old('no_telp') ?>" required>
                                            <div class="invalid-feedback" id="no_telp-error"></div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin : <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="" disabled <?= !old('jenis_kelamin') ? 'selected' : '' ?>>Pilih Jenis Kelamin</option>
                                                <?php foreach ($genders as $gender): ?>
                                                    <option value="<?= $gender ?>" <?= old('jenis_kelamin') === $gender ? 'selected' : '' ?>>
                                                        <?= $gender ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback" id="jenis_kelamin-error"></div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="keperluan" class="form-label">Keperluan : <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="keperluan" name="keperluan" rows="2" 
                                                      placeholder="Jelaskan keperluan Anda" required><?= old('keperluan') ?></textarea>
                                            <div class="invalid-feedback" id="keperluan-error"></div>
                                        </div>
                                        
                                        <input type="hidden" id="foto_data" name="foto_data" required>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-submit" id="submitBtn">
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
                                            <div id="photo-status" class="mt-1 text-muted small"></div>
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
<div class="modal fade" id="camera-modal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-describedby="cameraModalDescription">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cameraModalLabel">
                    <i class="fas fa-camera me-2"></i> Ambil Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup modal kamera"></button>
            </div>
            <div class="modal-body text-center">
                <div id="cameraModalDescription" class="visually-hidden">
                    Modal untuk mengambil foto tamu menggunakan kamera
                </div>
                <video id="camera-view" class="camera-view img-fluid" autoplay playsinline muted aria-label="Preview kamera"></video>
                <canvas id="camera-canvas" style="display:none;" aria-hidden="true"></canvas>
                <div id="camera-status" class="mt-2 text-muted" role="status" aria-live="polite"></div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-camera" id="capture-btn" aria-describedby="capture-help">
                    <i class="fas fa-camera me-2"></i> Ambil Foto
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Batal mengambil foto">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <div id="capture-help" class="visually-hidden">
                    Klik untuk mengambil foto dari kamera
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loading-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="loadingModalLabel" aria-describedby="loadingModalDescription">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div id="loadingModalDescription" class="visually-hidden">
                    Modal loading untuk menampilkan proses penyimpanan data
                </div>
                <div class="spinner-border text-primary" role="status" aria-label="Loading">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2" id="loadingModalLabel" aria-live="polite">Menyimpan data...</div>
            </div>
        </div>
    </div>
</div>

<script <?= csp_script_nonce() ?>>
// Inisialisasi variabel global
let cameraModal = null;
let loadingModal = null;
let cameraStream = null;
let shouldSubmit = false;
let isSubmitting = false;

// SweetAlert2 CDN (tambahkan di head jika belum ada)
if (typeof Swal === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.js';
    document.head.appendChild(script);
}

// Fungsi untuk memeriksa dukungan kamera
function checkCameraSupport() {
    return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
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
    
    if (typeof Swal !== 'undefined') {
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
    } else {
        alert(errorMessage);
    }
}

// Fungsi untuk memulai kamera
async function startCamera(videoElement) {
    try {
        const statusElement = document.getElementById('camera-status');
        if (statusElement) {
            statusElement.textContent = 'Memulai kamera...';
        }
        
        // Hentikan stream sebelumnya jika ada
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        
        // Dapatkan stream kamera dengan constraint yang lebih fleksibel
        const constraints = {
            video: {
                facingMode: { ideal: 'user' },
                width: { ideal: 1280, max: 1920 },
                height: { ideal: 720, max: 1080 }
            },
            audio: false
        };
        
        cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
        
        // Hubungkan stream ke video element
        videoElement.srcObject = cameraStream;
        
        // Tunggu sampai video siap
        return new Promise((resolve) => {
            videoElement.onloadedmetadata = () => {
                videoElement.play()
                    .then(() => {
                        if (statusElement) {
                            statusElement.textContent = 'Kamera siap. Posisikan wajah Anda dan klik "Ambil Foto"';
                        }
                        resolve(true);
                    })
                    .catch(err => {
                        console.error("Gagal memutar video:", err);
                        if (statusElement) {
                            statusElement.textContent = 'Gagal memulai kamera';
                        }
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
    const photoStatus = document.getElementById('photo-status');
    const captureBtn = document.getElementById('capture-btn');
    
    try {
        // Pastikan video sudah siap
        if (video.videoWidth === 0 || video.videoHeight === 0) {
            alert('Video belum siap. Silakan tunggu sebentar.');
            return;
        }
        
        // Disable tombol sementara
        if (captureBtn) {
            captureBtn.disabled = true;
            captureBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengambil Foto...';
        }
        
        // Atur ukuran canvas sesuai video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Gambar frame saat ini ke canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Konversi ke base64 (JPEG dengan kualitas 80%)
        const photoData = canvas.toDataURL('image/jpeg', 0.8);
        
        // Validasi ukuran foto
        if (photoData.length < 1000) {
            alert('Gagal mengambil foto. Silakan coba lagi.');
            return;
        }
        
        // Simpan foto data
        document.getElementById('foto_data').value = photoData;
        photoPreview.src = photoData;
        
        // Update status
        if (photoStatus) {
            photoStatus.innerHTML = '<i class="fas fa-check text-success"></i> Foto berhasil diambil';
        }
        
        // Restore tombol
        if (captureBtn) {
            captureBtn.disabled = false;
            captureBtn.innerHTML = '<i class="fas fa-camera me-2"></i> Ambil Foto';
        }
        
        // Tutup modal kamera dengan proper cleanup
        if (cameraModal) {
            // Remove focus dari tombol sebelum menutup modal
            if (captureBtn) {
                captureBtn.blur();
            }
            
            setTimeout(() => {
                cameraModal.hide();
            }, 200);
        }
        
        // Jika form menunggu submit, kirim sekarang
        if (shouldSubmit) {
            setTimeout(() => {
                document.getElementById('tamuForm').submit();
            }, 700);
        }
    } catch (error) {
        console.error("Error mengambil foto:", error);
        
        // Restore tombol jika error
        if (captureBtn) {
            captureBtn.disabled = false;
            captureBtn.innerHTML = '<i class="fas fa-camera me-2"></i> Ambil Foto';
        }
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengambil Foto',
                text: 'Terjadi kesalahan saat mencoba mengambil foto',
                confirmButtonColor: '#3085d6',
            });
        } else {
            alert('Gagal mengambil foto. Silakan coba lagi.');
        }
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

// Fungsi untuk update jam real-time
function updateRealTimeClock() {
    const now = new Date();
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    const jamDatangElement = document.getElementById('jam_datang');
    if (jamDatangElement) {
        jamDatangElement.value = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
    }
}

// Fungsi validasi form
function validateForm() {
    let isValid = true;
    const requiredFields = ['nama', 'dari', 'asal', 'no_telp', 'jenis_kelamin', 'keperluan'];
    
    // Reset semua error state
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        
        if (element) {
            element.classList.remove('is-invalid');
        }
        if (errorElement) {
            errorElement.textContent = '';
        }
    });
    
    // Validasi setiap field
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        const errorElement = document.getElementById(field + '-error');
        
        if (!element || !element.value.trim()) {
            if (element) element.classList.add('is-invalid');
            if (errorElement) {
                errorElement.textContent = getFieldErrorMessage(field, 'required');
            }
            isValid = false;
        } else {
            // Validasi spesifik per field
            const fieldValue = element.value.trim();
            
            switch (field) {
                case 'nama':
                    if (fieldValue.length < 3) {
                        element.classList.add('is-invalid');
                        if (errorElement) errorElement.textContent = 'Nama minimal 3 karakter';
                        isValid = false;
                    }
                    break;
                    
                case 'no_telp':
                    if (!/^[0-9]{10,15}$/.test(fieldValue)) {
                        element.classList.add('is-invalid');
                        if (errorElement) errorElement.textContent = 'Nomor telepon harus berupa angka 10-15 digit';
                        isValid = false;
                    }
                    break;
                    
                case 'asal':
                    if (fieldValue.length < 5) {
                        element.classList.add('is-invalid');
                        if (errorElement) errorElement.textContent = 'Alamat minimal 5 karakter';
                        isValid = false;
                    }
                    break;
                    
                case 'keperluan':
                    if (fieldValue.length < 5) {
                        element.classList.add('is-invalid');
                        if (errorElement) errorElement.textContent = 'Keperluan minimal 5 karakter';
                        isValid = false;
                    }
                    break;
            }
        }
    });
    
    return isValid;
}

// Fungsi untuk mendapatkan pesan error
function getFieldErrorMessage(field, type) {
    const messages = {
        'nama': { 'required': 'Nama harus diisi' },
        'dari': { 'required': 'Asal instansi harus diisi' },
        'asal': { 'required': 'Alamat harus diisi' },
        'no_telp': { 'required': 'Nomor telepon harus diisi' },
        'jenis_kelamin': { 'required': 'Jenis kelamin harus dipilih' },
        'keperluan': { 'required': 'Keperluan harus diisi' }
    };
    
    return messages[field] && messages[field][type] ? messages[field][type] : 'Field ini harus diisi';
}

// Fungsi untuk menampilkan loading
function showLoading() {
    if (loadingModal) {
        loadingModal.show();
    }
}

// Fungsi untuk menyembunyikan loading
function hideLoading() {
    if (loadingModal) {
        loadingModal.hide();
    }
}

// Event ketika dokumen siap
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');
    
    // Periksa dukungan kamera di browser
    if (!checkCameraSupport()) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Browser Tidak Mendukung',
                text: 'Browser Anda tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Edge terbaru.',
                confirmButtonColor: '#3085d6',
            });
        } else {
            alert('Browser Anda tidak mendukung akses kamera.');
        }
        return;
    }

    // Inisialisasi modal Bootstrap dengan proper accessibility
    try {
        const cameraModalElement = document.getElementById('camera-modal');
        const loadingModalElement = document.getElementById('loading-modal');
        
        if (cameraModalElement) {
            cameraModal = new bootstrap.Modal(cameraModalElement, {
                backdrop: 'static',
                keyboard: true,
                focus: true
            });
            
            // Set initial aria-hidden
            cameraModalElement.setAttribute('aria-hidden', 'true');
        }
        
        if (loadingModalElement) {
            loadingModal = new bootstrap.Modal(loadingModalElement, {
                backdrop: 'static',
                keyboard: false,
                focus: true
            });
            
            // Set initial aria-hidden
            loadingModalElement.setAttribute('aria-hidden', 'true');
        }
    } catch (error) {
        console.error("Gagal inisialisasi modal:", error);
        alert('Gagal mempersiapkan sistem kamera. Silakan refresh halaman.');
        return;
    }
    
    // Event ketika modal kamera dibuka
    const cameraModalElement = document.getElementById('camera-modal');
    if (cameraModalElement) {
        cameraModalElement.addEventListener('show.bs.modal', function() {
            // Remove aria-hidden sebelum modal ditampilkan
            this.removeAttribute('aria-hidden');
        });
        
        cameraModalElement.addEventListener('shown.bs.modal', async function() {
            const video = document.getElementById('camera-view');
            const captureBtn = document.getElementById('capture-btn');
            
            if (video) {
                // Kosongkan source sebelumnya
                video.srcObject = null;
                
                // Mulai kamera
                const cameraStarted = await startCamera(video);
                
                if (!cameraStarted) {
                    shouldSubmit = false;
                    if (cameraModal) {
                        cameraModal.hide();
                    }
                } else {
                    // Focus ke tombol capture setelah kamera siap
                    setTimeout(() => {
                        if (captureBtn && captureBtn.offsetParent !== null) {
                            captureBtn.focus();
                        }
                    }, 500);
                }
            }
        });

        // Event ketika modal kamera akan ditutup
        cameraModalElement.addEventListener('hide.bs.modal', function() {
            cleanupCamera();
        });
        
        // Event ketika modal kamera sudah ditutup
        cameraModalElement.addEventListener('hidden.bs.modal', function() {
            // Restore aria-hidden setelah modal ditutup
            this.setAttribute('aria-hidden', 'true');
        });
    }
    
    // Event tombol ambil foto
    const captureBtn = document.getElementById('capture-btn');
    if (captureBtn) {
        captureBtn.addEventListener('click', capturePhoto);
    }
    
    // Event tombol buka kamera manual
    const openCameraBtn = document.getElementById('open-camera');
    if (openCameraBtn) {
        openCameraBtn.addEventListener('click', function() {
            shouldSubmit = false;
            if (cameraModal) {
                cameraModal.show();
            }
        });
    }
    
    // Update jam secara real-time
    updateRealTimeClock();
    setInterval(updateRealTimeClock, 1000);
    
    // Event navigasi admin
    const headAdmin = document.querySelector('.head-admin');
    if (headAdmin) {
        headAdmin.addEventListener('click', function() {
            window.location.href = "<?= base_url('login') ?>";
        });
    }
    
    // Event validasi form sebelum submit
    const tamuForm = document.getElementById('tamuForm');
    if (tamuForm) {
        tamuForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Cegah double submit
            if (isSubmitting) {
                return;
            }
            
            console.log('Form submit triggered');
            
            // Update jam terakhir
            updateRealTimeClock();
            
            // Validasi form
            if (!validateForm()) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Form Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi dengan benar',
                        confirmButtonColor: '#3085d6',
                    });
                } else {
                    alert('Harap lengkapi semua field yang wajib diisi dengan benar');
                }
                return;
            }

            // Cek apakah foto sudah diambil
            const fotoData = document.getElementById('foto_data').value;
            if (!fotoData) {
                shouldSubmit = true;
                if (cameraModal) {
                    cameraModal.show();
                }
                return;
            }
            
            // Konfirmasi submit
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah data yang Anda masukkan sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm();
                    }
                });
            } else {
                if (confirm('Apakah data yang Anda masukkan sudah benar?')) {
                    submitForm();
                }
            }
        });
    }
    
    // Fungsi submit form
    function submitForm() {
        isSubmitting = true;
        
        // Disable submit button
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengirim...';
        }
        
        // Tampilkan loading
        showLoading();
        
        console.log('Submitting form...');
        
        // Submit form
        tamuForm.submit();
    }
    
    // Event untuk menghilangkan error saat user mengetik
    const inputFields = ['nama', 'dari', 'asal', 'no_telp', 'keperluan'];
    inputFields.forEach(fieldName => {
        const element = document.getElementById(fieldName);
        if (element) {
            element.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorElement = document.getElementById(fieldName + '-error');
                if (errorElement) {
                    errorElement.textContent = '';
                }
            });
        }
    });
    
    // Event untuk select jenis kelamin
    const jenisKelaminSelect = document.getElementById('jenis_kelamin');
    if (jenisKelaminSelect) {
        jenisKelaminSelect.addEventListener('change', function() {
            this.classList.remove('is-invalid');
            const errorElement = document.getElementById('jenis_kelamin-error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        });
    }
    
    // Bersihkan kamera saat halaman ditutup
    window.addEventListener('beforeunload', function() {
        cleanupCamera();
    });
    
    console.log('Initialization complete');
});

// Fungsi untuk menangani error window
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
});

// Fungsi untuk menangani unhandled promise rejection
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
});
</script>

<?= $this->endSection() ?>