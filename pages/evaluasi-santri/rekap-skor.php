<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
$id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
$jilid_id = isset($_GET['jilid']) ? $_GET['jilid'] : '';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">Input Absensi Harian</h5>
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
                    <li><strong>Tanggal:</strong> <?= $tgl ?></li>
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
          // $adaDataHariIni = cekSkor($tgl, $kelasJilidId)['total'] ?? 0;
          // var_dump($adaDataHariIni); // Debugging untuk melihat data absensi
          ?>
      
      <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-4">
          <!-- Summary Information -->

          <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Skor Awal</th>
                    <th colspan="15">Tanggal Tidak Masuk</th>
                    <th rowspan="2">Skor Akhir</th>
                    <th rowspan="2">A</th>
                    <th rowspan="2">I</th>
                    <th rowspan="2">S</th>
                    <th rowspan="2">T</th>
                  </tr>
                  <tr>
                    <?php for ($i=1; $i<=15; $i++): ?>
                        <th><?= $i ?></th>
                    <?php endfor; ?>
                  </tr>
            </thead>
            <tbody class="text-center">
                <?php $no=1; foreach (get_rekap_skor($kelasJilidId, $thn, $tgl) as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['skor_awal'] ?></td>
                        <?php 
                          $absensi = array_fill(1, 15, '');
                          if ($row['absensi_harian']) {
                              $items = explode(',', $row['absensi_harian']);
                              foreach ($items as $item) {
                                  list($tgl,$status) = explode(':',$item);
                                  $absensi[(int)$tgl] = $status;
                              }
                          }
                          for ($i=1; $i<=15; $i++) {
                              echo "<td>{$absensi[$i]}</td>";
                          }
                        ?>
                        <td><?= $row['skor_akhir'] ?></td>
                        <td><?= $row['total_A'] ?></td>
                        <td><?= $row['total_I'] ?></td>
                        <td><?= $row['total_S'] ?></td>
                        <td><?= $row['total_T'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
