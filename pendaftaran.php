<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda - Sistem Pendaftaran Amsilati</title>

  <link rel="stylesheet" href="assets/css/main/app.css">
  <link rel="stylesheet" href="assets/css/main/app-dark.css">
  <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">

  <link rel="stylesheet" href="assets/css/shared/iconly.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  
</head>

<body>
  <div class="container">
    <div class="card mt-3">
      <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0"><i class="bi bi-person-plus me-2"></i> Formulir Pendaftaran Santri Baru</h4>
      </div>
      <div class="card-body">
        <form action="proses_pendaftaran.php" method="POST" class="needs-validation" novalidate>
          <div class="row my-4 mx-2">
            <!-- Nama Lengkap -->
            <div class="col-md-6 mb-3">
              <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required
                    placeholder="Masukkan nama lengkap sesuai KTP">
              <div class="invalid-feedback">
                Harap isi nama lengkap
              </div>
            </div>

            <!-- Tempat Lahir -->
            <div class="col-md-6 mb-3">
              <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required
                    placeholder="Kota/kabupaten tempat lahir">
              <div class="invalid-feedback">
                Harap isi tempat lahir
              </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="col-md-6 mb-3">
              <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required
                    max="<?= date('Y-m-d'); ?>">
              <div class="invalid-feedback">
                Harap pilih tanggal lahir yang valid
              </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
              <select class="form-select" name="jenis_kelamin" required>
                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
              <div class="invalid-feedback">
                Harap pilih jenis kelamin
              </div>
            </div>

            <!-- No HP -->
            <div class="col-md-6 mb-3">
              <label for="no_hp" class="form-label">Nomor HP/WhatsApp <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">+62</span>
                <input type="tel" class="form-control" id="no_hp" name="no_hp" required
                      placeholder="81234567890" pattern="[0-9]{9,13}">
              </div>
              <div class="invalid-feedback">
                Harap isi nomor HP yang valid (9-13 digit)
              </div>
              <small class="text-muted">Contoh: 81234567890 (tanpa 0 di depan)</small>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email"
                    placeholder="nama@contoh.com">
              <div class="invalid-feedback">
                Harap isi email yang valid
              </div>
            </div>

            <!-- Alamat -->
            <div class="col-md-12 mb-3">
              <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
              <textarea class="form-control" id="alamat" name="alamat" rows="3" required
                        placeholder="Jl. Nama Jalan No. X, Kecamatan, Kabupaten/Kota"></textarea>
              <div class="invalid-feedback">
                Harap isi alamat lengkap
              </div>
            </div>

            <!-- Upload Foto -->
            <div class="col-md-6 mb-3">
              <label for="foto" class="form-label">Pas Foto (3x4)</label>
              <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
              <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
            </div>

            <!-- Persyaratan -->
            <div class="col-md-12 mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="persetujuan" required>
                <label class="form-check-label" for="persetujuan">
                  Saya menyatakan bahwa data yang diisi adalah benar dan bersedia mengikuti seluruh proses pembelajaran
                </label>
                <div class="invalid-feedback">
                  Anda harus menyetujui persyaratan
                </div>
              </div>
            </div>

            <!-- Tombol Submit -->
            <div class="col-12 d-flex justify-content-between">
              <button type="reset" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-2"></i> Reset Form
              </button>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-send-fill me-2"></i> Kirim Pendaftaran
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>

  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>
  
  <!-- Need: Apexcharts -->
  <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
  <script src="assets/js/pages/dashboard.js"></script>

    <script>
    // Validasi form client-side
    (() => {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
    </script>
</body>
</html>