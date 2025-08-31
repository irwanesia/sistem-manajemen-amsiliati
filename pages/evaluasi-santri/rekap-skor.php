<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
if ($_SESSION['role'] == 'Ustadzah') {
    $id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
} elseif ($_SESSION['role'] == 'Wali Kelas') {
    $id_ustadzah = isset($_GET['jilid']) ? $_GET['jilid'] : null;
}
// $id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
$jilid_id = isset($_GET['jilid']) ? $_GET['jilid'] : '';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">Input Skor Harian</h5>
        <!-- Tanggal -->
         <div class="row">
            <?php if ($_SESSION['role'] == 'Wali Kelas') : ?>
                <div class="col-md-3">
                    <select id="jilid" class="form-select jilidSelect" onchange="updateFilter3()">
                        <option value="">-- Jilid --</option>
                        <?php foreach (get_jilid() as $ta): ?>
                            <option value="<?= $ta['id_ustadzah'] ?>" <?= ($ta['id_ustadzah'] == $id_ustadzah) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ta['nama_jilid']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <input type="date" class="form-control tgl" id="tanggal" name="tanggal" value="<?= htmlspecialchars($tgl) ?>" onchange="updateFilter3()">
                </div>
            
                <!-- Tahun Ajaran -->
                <div class="col-md-5">
                    <select name="tahun_ajaran_id" class="form-select tahunSelect" onchange="updateFilter3()">
                        <option value="">-- Semester --</option>
                        <?php foreach (get_tahun_ajaran() as $ta): ?>
                            <option value="<?= $ta['id_tahun']; ?>" <?= ($thn == $ta['id_tahun']) ? 'selected' : ''; ?>>
                                <?= $ta['semester']; ?> - <?= $ta['tahun']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php else : ?>
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
            <?php endif ?>
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
            function updateFilter3() {
                // Ambil value dari dropdown
                var jilidId = document.querySelector('.jilidSelect').value;
                var tahunId = document.querySelector('.tahunSelect').value;
                var tgl = document.querySelector('.tgl').value;
                
                // Buat parameter URL
                var params = new URLSearchParams();
                
                if (jilidId) params.append('jilid', jilidId);
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

         <!-- Form Skor -->
        <?php 
        // Cek apakah parameter tahun dan jilid ada
          $hasFilter = isset($thn);
          // Cek apakah ada data Skor
          $skorData = $hasFilter ? get_skor_by_ustadzah($thn, $id_ustadzah) : [];
        //   $kelasJilidId = $skorData[0]['id_kelas_jilid'] ?? null;
          $jilid_id = $get_jilid['id_jilid'] ?? null;
          // $adaDataHariIni = cekSkor($tgl, $jilid_id)['total'] ?? 0;
          // var_dump($get_jilid); // Debugging untuk melihat data Skor
          $bln = date('m', strtotime($tgl));
          ?>
      
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
            <!-- Summary Information -->
                <!-- Navigasi Tab -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#awal">Tanggal 1–15</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#akhir">Tanggal 16–Akhir</a>
                    </li>
                </ul>

                <!-- Isi Tab -->
                <div class="tab-content">
                <!-- Tab Awal -->
                <div class="tab-pane fade show active" id="awal">
                    <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
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
                            <th rowspan="2">Jumlah SP</th>
                        </tr>
                        <tr>
                            <?php for ($i=1; $i<=15; $i++): ?>
                            <th><?= $i ?></th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach (get_rekap_skor($jilid_id, $thn, $tgl) as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['skor_awal'] ?></td>
                            <?php 
                            $absensi = array_fill(1, 31, '');
                            if ($row['absensi_harian']) {
                                $items = explode(',', $row['absensi_harian']);
                                foreach ($items as $item) {
                                    list($tglAbs,$status) = explode(':',$item);
                                    $absensi[(int)$tglAbs] = $status;
                                }
                            }
                            for ($i=1; $i<=15; $i++) {
                                echo "<td>{$absensi[$i]}</td>";
                            }
                            ?>
                            <td><?= $row['skor_akhir'] ?? "-" ?></td>
                            <td><?= $row['total_A'] ?></td>
                            <td><?= $row['total_I'] ?></td>
                            <td><?= $row['total_S'] ?></td>
                            <td><?= $row['total_T'] ?></td>
                            <td><?= $row['jumlah_sp'] ?? "-" ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <!-- Tab Akhir -->
                <div class="tab-pane fade" id="akhir">
                    <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Skor Awal</th>
                            <th colspan="16">Tanggal Tidak Masuk</th>
                            <th rowspan="2">Skor Akhir</th>
                            <th rowspan="2">A</th>
                            <th rowspan="2">I</th>
                            <th rowspan="2">S</th>
                            <th rowspan="2">T</th>
                            <th rowspan="2">Jumlah SP</th>
                        </tr>
                        <tr>
                            <?php 
                            $jumlahHari = date('t', strtotime($tgl));
                            for ($i=16; $i<=$jumlahHari; $i++): ?>
                            <th><?= $i ?></th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach (get_rekap_skor($jilid_id, $thn, $bln) as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['skor_awal'] ?></td>
                            <?php 
                            $absensi = array_fill(1, 31, '');
                            if ($row['absensi_harian']) {
                                $items = explode(',', $row['absensi_harian']);
                                foreach ($items as $item) {
                                    list($tglAbs,$status) = explode(':',$item);
                                    $absensi[(int)$tglAbs] = $status;
                                }
                            }
                            for ($i=16; $i<=$jumlahHari; $i++) {
                                echo "<td class='fs-6'>{$absensi[$i]}</td>";
                            }
                            ?>
                            <td><?= $row['skor_akhir'] ?? "-" ?></td>
                            <td><?= $row['total_A'] ?></td>
                            <td><?= $row['total_I'] ?></td>
                            <td><?= $row['total_S'] ?></td>
                            <td><?= $row['total_T'] ?></td>
                            <td><?= $row['jumlah_sp'] ?? "-" ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
  </div>
</div>
