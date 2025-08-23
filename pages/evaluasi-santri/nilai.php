<?php
$thn_id = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$jilid_id = isset($_GET['jilid']) ? $_GET['jilid'] : '';
$id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Evaluasi Santri - Nilai Akhir</h4>
          <!-- Tanggal -->
          <div class="row">
          
              <!-- Tahun Ajaran -->
              <div class="col-md-12">
                  <select name="tahun_ajaran_id" class="form-select tahunSelect" onchange="updateFilter()">
                      <option value="">-- Pilih Tahun Ajaran --</option>
                      <?php foreach (get_tahun_ajaran() as $ta): ?>
                          <option value="<?= $ta['id_tahun']; ?>" <?= ($thn_id == $ta['id_tahun']) ? 'selected' : ''; ?>>
                              <?= $ta['tahun']; ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>
      </div>
      
        <script>
          function updateFilter() {
            var tahunId = document.querySelector('.tahunSelect').value;
            var params = new URLSearchParams();
            
            if (tahunId) params.append('tahun', tahunId);
            
            var baseUrl = window.location.href.split('?')[0];
            window.location.href = params.toString() ? baseUrl + '?' + params.toString() : baseUrl;
          }
        </script>
      
      <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-4">


        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success mt-2 alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>


        <!-- Table Section -->
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Nama Jilid</th>
                <th>Nilai Angka</th>
                <th>Predikat</th>
                <th>Status Lulus</th>
                <th>Catatan</th>
                <th>Tanggal Penilaian</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty(get_poin($thn_id))): ?>
                <?php foreach (get_poin($thn_id) as $i => $row): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $row['nama_santri'] ?></td>
                    <td><?= $row['nama_jilid'] ?></td>
                    <td><?= $row['nilai_rata2'] ?></td>
                    <td><?= $row['predikat'] ?? '-' ?></td>
                    <td>
                      <?php if ($row['status_lulus'] == null): ?>
                        -
                      <?php else: ?>
                        <?php if ($row['status_lulus'] == 1): ?>
                            <span class="badge bg-success">Lulus</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Tidak Lulus</span>
                        <?php endif; ?>
                      <?php endif; ?>
                    </td>
                    <td><?= $row['catatan'] ?? '-' ?></td>
                    <td><?= $row['tanggal_penilaian'] ?? '-' ?></td>
                    <td>
                        <?php if ($row['nilai_angka'] === null): ?>
                            <a href="<?= base_url('nilai/input/'.$row['id_santri'].'/'.$kelasJilidTerpilih) ?>" class="btn btn-sm btn-primary">Input</a>
                        <?php else: ?>
                            <a href="<?= base_url('nilai/edit/'.$row['id_nilai']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php endif; ?>
                      </td>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center py-4">
                    <strong>Tidak ada data skor untuk tahun ajaran ini.</strong>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if(is_array(get_poin($thn_id))) : ?>
  <?php foreach (get_poin($thn_id) as $row): ?>
  <div class="modal fade" id="edit<?= $row['id_kelas_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLabel">
            Input Skor Santri
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
                    <option value="hafalan" <?= ($row['kategori'] ?? '' == 'hafalan') ? 'selected' : '' ?>>
                      Hafalan
                    </option>
                    <option value="bacaan" <?= ($row['kategori'] ?? '' == 'bacaan') ? 'selected' : '' ?>>
                      Bacaan
                    </option>
                    <option value="pemahaman" <?= ($row['kategori'] ?? '' == 'pemahaman') ? 'selected' : '' ?>>
                      Pemahaman
                    </option>
                    <option value="tajwid" <?= ($row['kategori'] ?? '' == 'tajwid') ? 'selected' : '' ?>>
                      Tajwid
                    </option>
                    <option value="adab" <?= ($row['kategori'] ?? '' == 'adab') ? 'selected' : '' ?>>
                      Adab
                    </option>
                    <option value="kehadiran" <?= ($row['kategori'] ?? '' == 'kehadiran') ? 'selected' : '' ?>>
                      Kehadiran
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
              <i class="bi bi-x-circle me-1"></i> Tutup <?= isset($row['id_skor']) ? 'update' : 'submit' ?>
            </button>
            <button type="submit" name="<?= isset($row['id_skor']) ? 'update' : 'submit' ?>" 
                    class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Simpan Nilai
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