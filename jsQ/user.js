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
            html: errorMessage + '<br><br>' +
                  '<strong>Pastikan:</strong><br>' +
                  '1. Anda menggunakan HTTPS atau localhost<br>' +
                  '2. Tidak ada aplikasi lain yang menggunakan kamera<br>' +
                  '3. Browser mendukung WebRTC (Chrome/Firefox/Edge terbaru)<br>' +
                  '4. Anda telah memberikan izin kamera',
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
