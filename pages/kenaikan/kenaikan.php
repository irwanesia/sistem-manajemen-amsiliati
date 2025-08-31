
<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$jilid_id = isset($_GET['jilid']) ? $_GET['jilid'] : null; // string, default hari ini
?>
<style>
        .table th, .table td {
            vertical-align: middle;
        }
        .col-kategori {
            width: 150px;
        }
        .col-skor {
            width: 120px;
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
        <h5 class="card-title">Data Kenaikan Jilid</h5>
        <!-- Tanggal -->
         <div class="row">
             <!-- Jilid ID -->
             <div class="col-md-5">
                 <select name="jilid_id" class="form-select jilidId" onchange="updateFilter()">
                     <option value="">-- Pilih Jilid --</option>
                     <?php foreach (get_jilid() as $jilid): ?>
                         <option value="<?= $jilid['id_jilid']; ?>" <?= ($jilid_id == $jilid['id_jilid']) ? 'selected' : ''; ?>>
                          <?= $jilid['nama_jilid']; ?>
                         </option>
                     <?php endforeach; ?>
                 </select>
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
    
    <script>
            function updateFilter() {
                // Ambil value dari dropdown
                var tahunId = document.querySelector('.tahunSelect').value;
                var jilidId = document.querySelector('.jilidId').value;
                
                // Buat parameter URL
                var params = new URLSearchParams();
                
                if (tahunId) params.append('tahun', tahunId);
                if (jilidId) params.append('jilid', jilidId);
                
                // Update URL dengan mempertahankan base URL yang benar
                var baseUrl = window.location.href.split('?')[0];
                if (params.toString()) {
                    window.location.href = baseUrl + '?' + params.toString();
                } else {
                    window.location.href = baseUrl;
                }
            }
    </script>

    
<div class="card-body">
        
        <!-- Filter -->
        <div class="row mb-4">
            <div class="alert alert-info">
                <?php $get_jilid = get_jilid_by_jilidId($jilid_id) ?>
                <?php $sms = get_tahun_ajaran_by_id($thn)['semester'] ?? '-' ?>
                <?php $tahun = get_tahun_ajaran_by_id($thn)['tahun'] ?? '-'  ?>
                <ul>
                    <li><strong>Ustadzah:</strong> <?= get_nama_ustadzah_by_jilidId($jilid_id) ?? '-' ?></li>
                    <li><strong>Jilid/Kelas:</strong> <?= $get_jilid['nama_jilid'] ?></li>
                    <li><strong>Tahun Ajaran:</strong> Semester <?= $sms . "(" . $tahun ?>)</li>
                </ul>
            </div>


        <!-- Form kenaikan -->
        <?php 
        // Cek apakah parameter tahun dan jilid ada
        $hasFilter = isset($jilid_id);
        // Cek apakah ada data skor
        $kenaikanData = $hasFilter ? get_kenaikan_jilid($jilid_id, $thn) : [];
        $kelasJilidId = $kenaikanData[0]['id_jilid'] ?? null;
        $adaDataHariIni = cekKenaikanData($kelasJilidId)['total'] ?? 0;
        // var_dump($kelasJilidId); // Debugging untuk melihat data skor
        ?>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success mt-2 alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($_GET['message']) ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($hasFilter): ?>
              <?php if (!empty($kenaikanData)): ?>
                <form method="POST" action="./controllers/KenaikanController.php">
                    <input type="hidden" name="tahun_ajaran_id" value="<?= $thn; ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                    <input type="hidden" name="nama" value="<?= $_SESSION['nama']; ?>">
                    <input type="hidden" name="id_kelas_jilid" value="<?= $kelasJilidId; ?>">
                    <input type="hidden" name="dari_jilid" value="<?= $jilid_id; ?>">

                    <table class="table table-striped table-hover" id="table1">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIS</th>
                          <th>Nama Santri</th>
                          <th>Dari Jilid</th>
                          <th>Ke Jilid</th>
                          <th>Tanggal Kenaikan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($kenaikanData as $s): ?>
                          <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($s['nis']); ?></td>
                            <td><?= htmlspecialchars($s['nama']); ?></td>
                            <td><?= htmlspecialchars($s['nama_jilid']); ?></td>
                            <td>
                                <select name="ke_jilid[<?= $s['id_kelas_jilid'] ?>]" class="form-select" required>
                                  <option value="" selected disabled>-- Pilih --</option>
                                  <?php foreach(get_jilid() as $jilid) : ?>
                                    <option value="<?= $jilid['id_jilid'] ?>"><?= $jilid['nama_jilid'] ?></option>
                                  <?php endforeach ?>
                                </select>
                            </td>
                            <td>
                                <input type="date" name="tgl_kenaikan[<?= $s['id_kelas_jilid'] ?>]" class="form-control" required>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>

                    <div class="text-end">
                      <button type="submit" name="submit" class="btn btn-primary">
                          <i class="bi bi-plus-circle"></i> Simpan Kenaikan
                      </button>
                    </div>
                </form>
              <?php else: ?>
                <div class="alert alert-warning">
                  Tidak ada data santri di tahun ajaran dan jilid yang dipilih.
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Silakan pilih <strong>tahun ajaran</strong> dan <strong>jilid</strong> terlebih dahulu untuk menampilkan data skor.
              </div>
            <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>
