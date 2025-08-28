$(document).ready(function () {
  ButtonExis();
});
function ButtonExis() {
  $("#loginbtn").on("click", function () {
    login();
  });
}

function login() {
  let data = $("#formLogin").serializeArray();
  let csrfName = $('meta[name="csrf-token-name"]').attr("content");
  let csrfHash = $('meta[name="csrf-token-hash"]').attr("content");
  data.push({ name: csrfName, value: csrfHash });

  //   console.log(data);
  //di variabel data udah ada data array dari inputan user
  //gimana cara data ini masuk ke controler??????
  //kita kirim data array yang ada variabel data menggunakan ajax di bawah ini
  //jangan lupa karena kita di file dengan ekstensi js maka base url dari ci4 harus dibuatkan,maka kita buatkan dulu base url untuk file js
  //di halaman login.php
  //kita beri nama variabel base urlnya di js BaseUrlJsQ
 var errorDiv = $("#login-error-message");
  errorDiv.addClass("d-none");


  //kita kirim data ke controler trxlogin
   $.ajax({
    url: BaseUrlJsQ + "trxlogin",
    type: "POST",
    dataType: "JSON",
    data: $.param(data),
    // data response dari controler ditangkap
    success: function (response) {
      if (response.lock_type) {
        window.location.href = response.redirect_url;
        return;
      }
      $('meta[name="csrf-token-hash"]').attr("content", response.csrf_baru);

      if (response.status) {
        window.location.href = response.redirect_url;
      } else {
        let errorMessage = response.message;
        if (response.failed_count) {
          errorMessage +=
            "<br><small>Percobaan gagal: " +
            response.failed_count +
            " kali.</small>";
        }
 
        errorDiv.html(errorMessage).removeClass("d-none");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Replace printError with proper error handling
      console.error("AJAX Error:", jqXHR.responseText);
      errorDiv.html("Terjadi kesalahan pada server. Silakan coba lagi.").removeClass("d-none");
    },
  });
}


 // Create animated particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.querySelector('input[type="password"], input[type="text"]');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Handle form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate login process
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                // Simulate login failure for demo
                document.getElementById('login-error-message').style.display = 'block';
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Hide error after 3 seconds
                setTimeout(() => {
                    document.getElementById('login-error-message').style.display = 'none';
                }, 3000);
            }, 2000);
        });

        // Add input focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-group-text').style.backgroundColor = '#4CAF50';
                this.parentElement.querySelector('.input-group-text').style.transform = 'scale(1.1)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-group-text').style.backgroundColor = '#000000';
                this.parentElement.querySelector('.input-group-text').style.transform = 'scale(1)';
            });
        });

        // Initialize particles when page loads
        document.addEventListener('DOMContentLoaded', createParticles);

        // Add mouse move effect
        document.addEventListener('mousemove', function(e) {
            const loginCard = document.querySelector('.login-card-body');
            const rect = loginCard.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            loginCard.style.transform = `perspective(1000px) rotateY(${(x - rect.width / 2) / 20}deg) rotateX(${-(y - rect.height / 2) / 20}deg)`;
        });

        document.querySelector('.login-card-body').addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateY(0deg) rotateX(0deg)';
        });