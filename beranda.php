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
  
  <style>
    .hero-section {
      background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
      color: white;
      border-radius: 10px;
      padding: 2rem;
      margin-bottom: 2rem;
    }
    
    .feature-card {
      transition: transform 0.3s ease;
      height: 100%;
    }
    
    .feature-card:hover {
      transform: translateY(-5px);
    }
    
    .btn-register {
      font-size: 1.1rem;
      padding: 0.75rem 2rem;
      font-weight: 600;
    }
    
    .contact-card {
      border-left: 4px solid #4b6cb7;
    }
    
    .timeline {
      position: relative;
      padding-left: 1.5rem;
    }
    
    .timeline:before {
      content: '';
      position: absolute;
      left: 7px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #4b6cb7;
    }
    
    .timeline-item {
      position: relative;
      padding-bottom: 1.5rem;
    }
    
    .timeline-item:before {
      content: '';
      position: absolute;
      left: 0;
      top: 3px;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      background: white;
      border: 3px solid #4b6cb7;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Hero Section -->
    <div class="hero-section text-center mt-3">
      <h1 class="display-5 fw-bold text-white">Sistem Pendaftaran Program Amsilati</h1>
      <p class="lead">Metode Cepat Membaca Kitab Kuning Tanpa Harakat</p>
      <a href="pendaftaran.php" class="btn btn-light btn-lg btn-register mt-3">
        <i class="bi bi-pencil-square me-2"></i> Daftar Sekarang
      </a>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-8">
          <!-- About Amsilati -->
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <h4 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i> Tentang Program Amsilati</h4>
            </div>
            <div class="card-body">
              <p class="card-text">
                Amsilati adalah metode pembelajaran inovatif yang dirancang khusus untuk memudahkan santri dalam membaca kitab kuning tanpa harakat (gundul). 
                Program intensif ini mengajarkan dasar-dasar nahwu dan shorof dengan pendekatan praktis yang telah terbukti efektif.
              </p>
              
              <div class="row mt-4">
                <div class="col-md-6 mb-3">
                  <div class="card feature-card border-primary">
                    <div class="card-body">
                      <h5 class="card-title text-primary"><i class="bi bi-speedometer2 me-2"></i> Cepat & Efektif</h5>
                      <p class="card-text">Hanya dalam 4 bulan, peserta akan mampu membaca kitab kuning dasar.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="card feature-card border-success">
                    <div class="card-body">
                      <h5 class="card-title text-success"><i class="bi bi-people me-2"></i> Pengajar Berpengalaman</h5>
                      <p class="card-text">Dibimbing oleh ustadz/ustadzah yang telah tersertifikasi metode Amsilati.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Requirements & Timeline -->
          <div class="row">
            <div class="col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-header bg-success text-white">
                  <h5 class="card-title mb-0"><i class="bi bi-check-circle me-2"></i> Syarat Pendaftaran</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-check2-circle text-success me-3"></i>
                      Sudah lancar membaca Al-Qur'an
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-check2-circle text-success me-3"></i>
                      Usia minimal 12 tahun
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-check2-circle text-success me-3"></i>
                      Bersedia mengikuti program secara intensif
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                      <i class="bi bi-check2-circle text-success me-3"></i>
                      Mengisi formulir pendaftaran dengan benar
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-header bg-info text-white">
                  <h5 class="card-title mb-0"><i class="bi bi-calendar-event me-2"></i> Timeline Program</h5>
                </div>
                <div class="card-body">
                  <div class="timeline">
                    <div class="timeline-item">
                      <h6 class="fw-bold">Pendaftaran</h6>
                      <p>1 - 31 Agustus 2025</p>
                    </div>
                    <div class="timeline-item">
                      <h6 class="fw-bold">Seleksi Administrasi</h6>
                      <p>1 - 5 September 2025</p>
                    </div>
                    <div class="timeline-item">
                      <h6 class="fw-bold">Pengumuman</h6>
                      <p>7 September 2025</p>
                    </div>
                    <div class="timeline-item">
                      <h6 class="fw-bold">Pelaksanaan Program</h6>
                      <p>September - Desember 2025</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <!-- Contact Card -->
          <div class="card contact-card mb-4">
            <div class="card-header bg-warning text-dark">
              <h5 class="card-title mb-0"><i class="bi bi-headset me-2"></i> Kontak Panitia</h5>
            </div>
            <div class="card-body">
              <div class="d-flex mb-3">
                <div class="flex-shrink-0">
                  <i class="bi bi-telephone text-primary fs-4"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="fw-bold">Telepon</h6>
                  <p class="mb-0">0812-3456-7890 (Ustadzah Anisa)</p>
                </div>
              </div>
              
              <div class="d-flex mb-3">
                <div class="flex-shrink-0">
                  <i class="bi bi-geo-alt text-danger fs-4"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="fw-bold">Lokasi</h6>
                  <p class="mb-0">Pondok Pesantren Darul Ilmi, Kudus</p>
                </div>
              </div>
              
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <i class="bi bi-clock text-success fs-4"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="fw-bold">Jam Operasional</h6>
                  <p class="mb-0">Senin - Jumat: 08.00 - 16.00 WIB</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Action -->
          <div class="card border-primary">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0"><i class="bi bi-lightning me-2"></i> Mulai Pendaftaran</h5>
            </div>
            <div class="card-body text-center">
              <p>Daftarkan diri Anda sekarang untuk mengikuti program Amsilati</p>
              <a href="pendaftaran.php" class="btn btn-primary btn-lg w-100 btn-register">
                <i class="bi bi-pencil-square me-2"></i> Daftar Sekarang
              </a>
              <p class="text-muted small mt-2">Pendaftaran ditutup pada 31 Agustus 2025</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>
  
  <!-- Need: Apexcharts -->
  <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
  <script src="assets/js/pages/dashboard.js"></script>
</body>
</html>