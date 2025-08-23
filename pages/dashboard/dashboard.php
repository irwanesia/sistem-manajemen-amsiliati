<div class="page-heading">
    <h3>Dashboard Amsilati</h3>
    <p class="text-subtitle text-muted">Monitoring Program Pembelajaran Kitab Kuning</p>
</div>

<div class="row">
    <!-- ROW 1: Summary Cards -->
    <div class="col-12">
        <div class="row">
            <!-- Card 1: Total Santri -->
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card card-stat">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-light-primary p-50 me-2">
                                <span class="avatar-content">
                                    <i class="bi bi-people-fill fs-2"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold">Total Santri</h6>
                                <h4 class="fw-extrabold mb-0">1,240</h4>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="badge bg-success">+12% dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Santri Aktif -->
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card card-stat">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-light-success p-50 me-2">
                                <span class="avatar-content">
                                    <i class="bi bi-person-check fs-2"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold">Santri Aktif</h6>
                                <h4 class="fw-extrabold mb-0">1,012</h4>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-2" style="height: 6px">
                            <div class="progress-bar bg-success" style="width: 82%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Tingkat Kelulusan -->
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card card-stat">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-light-warning p-50 me-2">
                                <span class="avatar-content">
                                    <i class="bi bi-award fs-2"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold">Tingkat Kelulusan</h6>
                                <h4 class="fw-extrabold mb-0">87%</h4>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-muted">Target: 90%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Ustadzah -->
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card card-stat">
                    <div class="card-body px-4 py-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-light-info p-50 me-2">
                                <span class="avatar-content">
                                    <i class="bi bi-person-workspace fs-2"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold">Pengajar</h6>
                                <h4 class="fw-extrabold mb-0">42</h4>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="text-muted">12 Asrama</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Grafik Utama -->
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Progress Pembelajaran per Jilid</h4>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Semester 1 2024
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Semester 1 2024</a></li>
                        <li><a class="dropdown-item" href="#">Semester 2 2023</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="jilid-progress-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Distribusi Santri per Asrama</h4>
            </div>
            <div class="card-body">
                <div id="asrama-distribution-chart"></div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm btn-outline-primary">Lihat Detail</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: Tabel & Info -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Santri dengan Progress Terbaik</h4>
                <p class="text-muted mb-0">Top 5 pekan ini</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Asrama</th>
                                <th>Jilid</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Aisyah Nurul</td>
                                <td>Al-Farabi</td>
                                <td>Jilid 4</td>
                                <td><span class="badge bg-success">98</span></td>
                            </tr>
                            <!-- Data lainnya... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Aktivitas Terkini</h4>
                <button class="btn btn-sm btn-outline-primary">Lihat Semua</button>
            </div>
            <div class="card-body activity-feed">
                <div class="d-flex mb-3">
                    <div class="avatar bg-light-primary p-50 me-3 rounded">
                        <span class="avatar-content">
                            <i class="bi bi-journal-check"></i>
                        </span>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Ujian Jilid 3 Dimulai</p>
                        <small class="text-muted">2 jam yang lalu · 42 santri mengikuti</small>
                    </div>
                </div>
                <!-- Aktivitas lainnya... -->
            </div>
        </div>
    </div>
</div>