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

        <!-- Form skor -->
        <?php 
        // Cek apakah parameter tahun dan jilid ada
        $hasFilter = isset($thn);
        // Cek apakah ada data skor
        $skorData = $hasFilter ? get_skor_by_ustadzah($thn, $id_ustadzah) : [];
        $kelasJilidId = $skorData[0]['id_kelas_jilid'] ?? null;
        $adaDataHariIni = cekSkor($tgl, $kelasJilidId)['total'] ?? 0;
        // var_dump($adaDataHariIni); // Debugging untuk melihat data skor
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

                        <table class="table table-hover" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Santri</th>
                                    <th>Asrama | Kamar</th>
                                    <th class="col-kategori">Kategori</th>
                                    <th class="col-skor">Skor Awal</th>
                                    <th class="col-skor">Skor Akhir</th>
                                    <th class="col-skor">Jumlah SP</th>
                                    <th class="col-keterangan">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($skorData as $s): ?>
                                <tr>
                                    <!-- Kolom dengan rowspan -->
                                    <td rowspan="2"><?= htmlspecialchars($s['nama']); ?></td>
                                    <td rowspan="2"><?= htmlspecialchars($s['nama_asrama'] ." - ". $s['nama_kamar']); ?></td>
                                    
                                    <?php if($adaDataHariIni == 1) : ?>
                                        <?php 
                                        $skor_awal = get_data_skor($s['id_kelas_jilid'], $tgl)['skor_awal'] ?? '-';
                                        $skor_akhir = get_data_skor($s['id_kelas_jilid'], $tgl)['skor_akhir'] ?? '-';
                                        $kategori = get_data_skor($s['id_kelas_jilid'], $tgl)['kategori'] ?? '';
                                        $jumlah_sp = get_data_skor($s['id_kelas_jilid'], $tgl)['jumlah_sp'] ?? '-';
                                        $keterangan = get_data_skor($s['id_kelas_jilid'], $tgl)['keterangan'] ?? '';
                                        ?>
                                        
                                        <!-- Baris 1: Ujian Tulis -->
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>][1]" class="form-select">
                                                <option value="Ujian Tulis" selected>Ujian Tulis</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>][1]" class="form-control" value="<?= $kategori == 'Ujian Tulis' ? $skor_awal : '' ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>][1]" class="form-control" value="<?= $kategori == 'Ujian Tulis' ? $skor_akhir : '' ?>">
                                        </td>
                                        <td rowspan="2">
                                            <input type="number" name="jumlahSP[<?= $s['id_kelas_jilid'] ?>]" class="form-control" value="<?= $jumlah_sp ?>">
                                        </td>
                                        <td rowspan="2">
                                            <textarea name="keterangan[<?= $s['id_kelas_jilid'] ?>]" class="form-control"><?= $keterangan ?></textarea>
                                        </td>
                                    <?php else : ?>
                                        <!-- Baris 1: Ujian Tulis (tanpa data) -->
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>][1]" class="form-select">
                                                <option value="Ujian Tulis" selected>Ujian Tulis</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>][1]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>][1]" class="form-control">
                                        </td>
                                        <td rowspan="2">
                                            <input type="number" name="jumlahSP[<?= $s['id_kelas_jilid'] ?>]" class="form-control">
                                        </td>
                                        <td rowspan="2">
                                            <textarea name="keterangan[<?= $s['id_kelas_jilid'] ?>]" class="form-control" placeholder="Keterangan..."></textarea>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <?php if($adaDataHariIni == 1) : ?>
                                        <!-- Baris 2: Ujian Lisan -->
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>][2]" class="form-select">
                                                <option value="Ujian Lisan" selected>Ujian Lisan</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>][2]" class="form-control" value="<?= $kategori == 'Ujian Lisan' ? $skor_awal : '' ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>][2]" class="form-control" value="<?= $kategori == 'Ujian Lisan' ? $skor_akhir : '' ?>">
                                        </td>
                                    <?php else : ?>
                                        <!-- Baris 2: Ujian Lisan (tanpa data) -->
                                        <td> 
                                            <select name="kategori[<?= $s['id_kelas_jilid'] ?>][2]" class="form-select">
                                                <option value="Ujian Lisan" selected>Ujian Lisan</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="skorAwal[<?= $s['id_kelas_jilid'] ?>][2]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="skorAkhir[<?= $s['id_kelas_jilid'] ?>][2]" class="form-control">
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
                        Tidak ada data skor untuk tahun ajaran dan jilid yang dipilih.
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
