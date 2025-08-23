<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
$id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
?>
<style>
        .table th, .table td {
            vertical-align: middle;
        }
        .col-kategori {
            width: 150px;
        }
        .col-skor {
            width: 150px;
        }
        .col-keterangan {
            min-width: 180px;
        }
        .table-container {
            overflow-x: auto;
        }
    </style>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">Input Skor Santri</h5>
        <!-- Tanggal -->
         <div class="row">
             <div class="col-md-5">
                 <input type="date" class="form-control tgl" id="tanggal" name="tanggal" value="<?= htmlspecialchars($tgl) ?>" onchange="updateFilter()">
             </div>
         
             <!-- Tahun Ajaran -->
             <div class="col-md-7">
                 <select name="tahun_ajaran_id" class="form-select tahunSelect" onchange="updateFilter()">
                     <option value="">-- Semester --</option>
                     <?php foreach (get_tahun_ajaran() as $ta): ?>
                         <option value="<?= $ta['id_tahun']; ?>" <?= ($thn == $ta['id_tahun']) ? 'selected' : ''; ?>>
                             <?= $ta['semester']; ?> - <?= $ta['tahun']; ?>
                         </option>
                     <?php endforeach; ?>
                 </select>
             </div>
         </div>
    </div>
    <div class="card-body">
        
        <!-- Filter -->
        <div class="row mb-4">
            <div class="alert alert-info">
                <?php $get_jilid = get_jilid_by_id($id_ustadzah) ?>
                <?php $sms = get_tahun_ajaran_by_id($thn)['semester'] ?? '-' ?>
                <?php $tahun = get_tahun_ajaran_by_id($thn)['tahun'] ?? '-'  ?>
                <ul>
                    <li><strong>Ustadzah:</strong> <?= get_nama_ustadzah_by_id($id_ustadzah) ?? '-' ?></li>
                    <li><strong>Jilid/Kelas:</strong> <?= $get_jilid['nama_jilid'] ?? '-' ?></li>
                    <li><strong>Tahun Ajaran:</strong> Semester <?= $sms . "(" . $tahun ?>)</li>
                    <li hidden><strong>Tanggal:</strong> <?= $tgl ?></li>
                </ul>
            </div>

        <script>
            function updateFilter() {
                // Ambil value dari dropdown
                var tahunId = document.querySelector('.tahunSelect').value;
                var tgl = document.querySelector('.tgl').value;
                
                // Buat parameter URL
                var params = new URLSearchParams();
                
                if (tahunId) params.append('tahun', tahunId);
                if (tgl) params.append('tanggal', tgl);
                
                // Update URL dengan mempertahankan base URL yang benar
                var baseUrl = window.location.href.split('?')[0];
                if (params.toString()) {
                    window.location.href = baseUrl + '?' + params.toString();
                } else {
                    window.location.href = baseUrl;
                }
            }
        </script>

        <!-- Form Absensi -->
        <?php 
        // Cek apakah parameter tahun dan jilid ada
        $hasFilter = isset($thn);
        // Cek apakah ada data absensi
        $skorData = $hasFilter ? get_skor_by_ustadzah($thn, $id_ustadzah) : [];
        $kelasJilidId = $skorData[0]['id_kelas_jilid'] ?? null;
        $adaDataHariIni = cekSkor($tgl, $kelasJilidId)['total'] ?? 0;
        // var_dump($adaDataHariIni); // Debugging untuk melihat data absensi
        ?>

              <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success mt-2 alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($_GET['message']) ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <?php if ($hasFilter): ?>
                <?php if (!empty($skorData)): ?>
                    <form method="POST" action="./controllers/SkorController.php">
                        <input type="hidden" name="tahun_ajaran_id" value="<?= $thn; ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                        <input type="hidden" name="nama" value="<?= $_SESSION['nama']; ?>">
                        <input type="hidden" name="tanggal" value="<?= $tgl; ?>">

                        <table class="table table-striped table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Santri</th>
                                    <th>Asrama | Kamar</th>
                                    <th class="col-kategori">Kategori</th>
                                    <th class="col-skor">Skor Awal</th>
                                    <th class="col-skor">Skor Akhir</th>
                                    <th class="col-keterangan">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($skorData as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['nama']); ?></td>
                                    <td><?= htmlspecialchars($s['nama_asrama'] ." - ". $s['nama_kamar']); ?></td>
                                    <?php if($adaDataHariIni == 1) : ?>
                                        <?php $skor_awal = get_data_skor($s['id_kelas_jilid'], $tgl)['skor_awal'] ?>
                                        <?php $skor_akhir = get_data_skor($s['id_kelas_jilid'], $tgl)['skor_akhir'] ?>
                                        <?php $kategori = get_data_skor($s['id_kelas_jilid'], $tgl)['kategori'] ?>
                                        <?php $keterangan = get_data_skor($s['id_kelas_jilid'], $tgl)['keterangan'] ?>
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>]" class="form-select">
                                                <option value="Ujian Lisan" <?= $kategori == 'Ujian Lisan' ? 'selected' : '' ?>>Ujian Lisan</option>
                                                <option value="Ujian Tulis" <?= $kategori == 'Ujian Tulis' ? 'selected' : '' ?>>Ujian Tulis</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>]" class="form-control" value="<?= $skor_awal ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>]" class="form-control" value="<?= $skor_akhir ?? '-' ?>" placeholder="Skor akhir">
                                        </td>
                                        <td>
                                            <textarea name="keterangan[<?= $s['id_kelas_jilid'] ?>]" class="form-control" ><?= $keterangan ?></textarea>
                                        </td>
                                    <?php else : ?>
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>]" class="form-select">
                                                <option value="" selected disabled>-- Pilih -- </option>
                                                <option value="Ujian Lisan">Ujian Lisan</option>
                                                <option value="Ujian Tulis">Ujian Tulis</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>]" class="form-control" placeholder="Skor awal">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>]" class="form-control" placeholder="Skor akhir">
                                        </td>
                                        <td>
                                            <textarea name="keterangan[<?= $s['id_kelas_jilid'] ?>]" class="form-control" placeholder="Masukan keterangan..."></textarea>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="text-end">
                            <button type="submit" name="<?= $adaDataHariIni == 1 ? 'update' : 'submit' ?>" class="btn <?= $adaDataHariIni == 1 ? 'btn-warning' : 'btn-primary'; ?>">
                                <i class="bi <?= $adaDataHariIni == 1 ? 'bi-pencil-square' : 'bi-save'; ?>"></i> 
                                <?= $adaDataHariIni == 1 ? 'Update Skor' : 'Simpan Skor'; ?>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        Tidak ada data absensi untuk tahun ajaran dan jilid yang dipilih.
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Silakan pilih <strong>tahun ajaran</strong> dan <strong>jilid</strong> terlebih dahulu untuk menampilkan data absensi.
                </div>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="inputSkor" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLabel">
            Input Skor Santri - <?= $get_jilid['nama_jilid'] ?? '-' ?>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/skorController.php" method="POST">
          <div class="modal-body">
            <!-- Hidden Fields -->
            <input type="hidden" name="nama" value="<?= $_SESSION['username'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

            <!-- Input Section -->
            <div class="border p-4 rounded">
              <h5 class="mb-4">
                <i class="bi bi-clipboard2-plus me-2"></i>Form Penilaian 
              </h5>

              <div class="row g-3">
                <!-- Kategori Select -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nama Santri</label>
                  <select name="kelas_jilid_id" class="form-select" required>
                    <option value="">-- Pilih Santri --</option>
                    <?php foreach (get_kelas_santri($get_jilid['id_jilid']) as $row) : ?>
                      <option value="<?= $row['id_kelas_jilid'] ?>">
                        <?= $row['nama'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Materi</label>
                  <select name="materi_id" class="form-select" required>
                    <option value="">-- Pilih Materi --</option>
                    <?php foreach (get_materi_by_jilid_ustadzah($get_jilid['id_jilid']) as $row) : ?>
                      <option value="<?= $row['id_materi'] ?>">
                        <?= $row['nama_materi'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

              <!-- Kategori Select -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Kategori Penilaian</label>
                  <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Ujian Tulis" <?= ($row['kategori'] ?? '' == 'Ujian Tulis') ? 'selected' : '' ?>>
                      Ujian Tulis
                    </option>
                    <option value="Ujian Lisan" <?= ($row['kategori'] ?? '' == 'Ujian Lisan') ? 'selected' : '' ?>>
                      Ujian Lisan
                    </option>
                  </select>
                </div>
              
              
                <!-- Tanggal Input -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Tanggal Penilaian</label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                      <i class="bi bi-calendar-date"></i>
                    </span>
                    <input type="date" name="tanggal" class="form-control" 
                          value="<?= $row['tanggal'] ?? date('Y-m-d') ?>" required>
                  </div>
                </div>
                
                <!-- Poin Input -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nilai Poin (0-100)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                      <i class="bi bi-123"></i>
                    </span>
                    <input type="number" name="poin" class="form-control" 
                          min="0" max="100" value="<?= $row['poin'] ?? '' ?>" 
                          placeholder="Masukkan nilai" required>
                    <span class="input-group-text">/100</span>
                  </div>
                </div>

                <!-- Keterangan Textarea -->
                <div class="col-12">
                  <label class="form-label fw-bold">Catatan Evaluasi</label>
                  <textarea name="keterangan" class="form-control" rows="3" 
                            placeholder="Berikan catatan evaluasi untuk santri..."><?= $row['keterangan'] ?? '' ?></textarea>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
            <button type="submit" name="submit" 
                    class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Simpan Nilai
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php if(is_array(get_skor($thn_id, $materi_id))) : ?>
  <?php foreach (get_skor($thn_id, $materi_id) as $row): ?>
  <div class="modal fade" id="edit<?= $row['id_kelas_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLabel">
            Update Skor Santri - <?= $get_jilid['nama_jilid'] ?? '-' ?>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/skorController.php" method="POST">
          <div class="modal-body">
            <!-- Hidden Fields -->
            <input type="hidden" name="nama" value="<?= $_SESSION['username'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="kelas_jilid_id" value="<?= $row['id_kelas_jilid'] ?>">
            <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
            <input type="hidden" name="tahun_ajaran" value="<?= $thn_id ?>">
            <input type="hidden" name="id_santri" value="<?= $row['id_santri'] ?>">
            <input type="hidden" name="id_skor" value="<?= isset($row['id_skor']) ? $row['id_skor'] : null ?>">
            
            <!-- Information Cards -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="card border">
                  <div class="card-body p-3">
                    <h6 class="card-subtitle mb-1 text-muted small">Jilid</h6>
                    <p class="card-text fw-bold"><?= $row['nama_jilid'] ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border">
                  <div class="card-body p-3">
                    <h6 class="card-subtitle mb-1 text-muted small">Santri</h6>
                    <p class="card-text fw-bold"><?= $row['nama'] ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border">
                  <div class="card-body p-3">
                    <h6 class="card-subtitle mb-1 text-muted small">Materi</h6>
                    <p class="card-text fw-bold"><?= $row['nama_materi'] ?></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Input Section -->
            <div class="border p-4 rounded">
              <h5 class="mb-4">
                <i class="bi bi-clipboard2-plus me-2"></i>Form Penilaian
              </h5>
              
              <div class="row g-3">
                <!-- Tanggal Input -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Tanggal Penilaian</label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                      <i class="bi bi-calendar-date"></i>
                    </span>
                    <input type="date" name="tanggal" class="form-control" 
                          value="<?= $row['tanggal'] ?? date('Y-m-d') ?>" required>
                  </div>
                </div>
                
                <!-- Poin Input -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nilai Poin (0-100)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                      <i class="bi bi-123"></i>
                    </span>
                    <input type="number" name="poin" class="form-control" 
                          min="0" max="100" value="<?= $row['poin'] ?? '' ?>" 
                          placeholder="Masukkan nilai" required>
                    <span class="input-group-text">/100</span>
                  </div>
                </div>
                
                <!-- Kategori Select -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Kategori Penilaian</label>
                  <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Ujian Tulis" <?= ($row['kategori'] ?? '' == 'Ujian Tulis') ? 'selected' : '' ?>>
                      Ujian Tulis
                    </option>
                    <option value="Ujian Lisan" <?= ($row['kategori'] ?? '' == 'Ujian Lisan') ? 'selected' : '' ?>>
                      Ujian Lisan
                    </option>
                  </select>
                </div>
                
                <!-- Keterangan Textarea -->
                <div class="col-12">
                  <label class="form-label fw-bold">Catatan Evaluasi</label>
                  <textarea name="keterangan" class="form-control" rows="3" 
                            placeholder="Berikan catatan evaluasi untuk santri..."><?= $row['keterangan'] ?? '' ?></textarea>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
            <button type="submit" name="update" 
                    class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Update Skor
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- delete skor -->
  <div class="modal fade" id="hapus<?= $row['id_kelas_jilid'] ?>" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hapusLabel">Hapus Skor Santri</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/skorController.php" method="POST">
          <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
          <input type="hidden" name="tahun_ajaran" value="<?= $thn_id ?>">
          <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus skor untuk santri <strong><?= htmlspecialchars($row['nama']) ?></strong>?</p>
            <input type="hidden" name="id_skor" value="<?= $row['id_skor'] ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Batal
            </button>
            <button type="submit" name="delete" class="btn btn-danger">
              <i class="bi bi-trash me-1"></i> Hapus Skor
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>