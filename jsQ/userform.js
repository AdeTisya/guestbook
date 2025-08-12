document.addEventListener('DOMContentLoaded', function() {
    // Camera functionality
    let stream = null;
    const cameraModal = new bootstrap.Modal(document.getElementById('camera-modal'));
    const cameraView = document.getElementById('camera-view');
    const cameraCanvas = document.getElementById('camera-canvas');
    const photoPreview = document.getElementById('photo-preview');
    const fotoDataInput = document.getElementById('foto_data');
    const ctx = cameraCanvas.getContext('2d');

    // Open camera modal
    document.getElementById('open-camera').addEventListener('click', async function() {
        try {
            // Stop any existing stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            
            // Get user media
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false 
            });
            
            // Show stream in video element
            cameraView.srcObject = stream;
            cameraModal.show();
        } catch (err) {
            console.error("Error accessing camera: ", err);
            alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
        }
    });

    // Capture photo
    document.getElementById('capture-btn').addEventListener('click', function() {
        // Set canvas dimensions to match video
        cameraCanvas.width = cameraView.videoWidth;
        cameraCanvas.height = cameraView.videoHeight;
        
        // Draw current video frame to canvas
        ctx.drawImage(cameraView, 0, 0, cameraCanvas.width, cameraCanvas.height);
        
        // Convert canvas to data URL and set as photo preview
        const imageDataUrl = cameraCanvas.toDataURL('image/png');
        photoPreview.src = imageDataUrl;
        
        // Store base64 image data in hidden input
        fotoDataInput.value = imageDataUrl;
        
        // Close modal and stop stream
        cameraModal.hide();
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });

    // Clean up when modal is closed
    document.getElementById('camera-modal').addEventListener('hidden.bs.modal', function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraView.srcObject = null;
    });

    // Initialize kabupaten, kecamatan, desa selection
    // Ketika kabupaten dipilih, aktifkan kecamatan
    document.getElementById('kabupaten').addEventListener('change', function() {
        document.getElementById('kecamatan').disabled = false;
        document.getElementById('desa').disabled = true;
        document.getElementById('desa').innerHTML = '<option value="" disabled selected>Pilih Desa</option>';
        
        // Isi dropdown kecamatan
        const kecamatanOptions = document.getElementById('kecamatan');
        kecamatanOptions.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
        
        Object.keys(desaData).forEach(function(kecamatan) {
            const option = document.createElement('option');
            option.value = kecamatan;
            option.textContent = kecamatan;
            kecamatanOptions.appendChild(option);
        });
    });

    // Ketika kecamatan dipilih, isi dropdown desa
    document.getElementById('kecamatan').addEventListener('change', function() {
        const selectedKecamatan = this.value;
        const desaSelect = document.getElementById('desa');
        desaSelect.disabled = false;
        desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa</option>';
        
        if (selectedKecamatan && desaData[selectedKecamatan]) {
            desaData[selectedKecamatan].forEach(function(desa) {
                const option = document.createElement('option');
                option.value = desa;
                option.textContent = desa;
                desaSelect.appendChild(option);
            });
        }
    });

    // Format nomor telepon
    document.getElementById('no_telp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Update jam datang setiap detik
    function updateJamDatang() {
        const now = new Date();
        const formattedDate = `${String(now.getDate()).padStart(2, '0')}/${String(now.getMonth()+1).padStart(2, '0')}/${now.getFullYear()} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
        document.getElementById('jam_datang').value = formattedDate;
    }
    
    updateJamDatang();
    setInterval(updateJamDatang, 60000); // Update setiap menit
});