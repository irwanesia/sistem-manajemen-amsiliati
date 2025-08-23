<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
$id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
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
        $absensiData = $hasFilter ? get_absensi_for_ustadzah($thn, $id_ustadzah, $tgl) : [];
        $kelasJilidId = $absensiData[0]['id_kelas_jilid'] ?? null;
        $adaDataHariIni = cekAbsensi($tgl, $kelasJilidId)['total'] ?? 0;
        // var_dump($adaDataHariIni); // Debugging untuk melihat data absensi
        ?>

        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        
        <small hidden>
            <?= $adaDataHariIni == 1 ? '*sudah dilakukan absensi' : '*belum dilakuan absensi' ?>
        </small> 
        <?php if ($hasFilter): ?>
            <?php if (!empty($absensiData)): ?>
                <form method="POST" action="./controllers/AbsensiController.php">
                    <input type="hidden" name="tahun_ajaran_id" value="<?= $thn; ?>">
                    <input type="hidden" name="jilid_id" value="<?= $jilid; ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                    <input type="hidden" name="nama" value="<?= $_SESSION['nama']; ?>">
                    <input type="hidden" name="tanggal" value="<?= $tgl; ?>">

                    <table class="table table-striped table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Santri</th>
                                <th>Asrama | Kamar</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absensiData as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['nama']); ?></td>
                                <td><?= htmlspecialchars($s['nama_asrama'] ." - ". $s['nama_kamar']); ?></td>
                                <?php if($adaDataHariIni == 1) : ?>
                                    <?php $status = get_status_absensi($s['id_kelas_jilid'], $tgl)['status'] ?>
                                    <?php $keterangan = get_status_absensi($s['id_kelas_jilid'], $tgl)['keterangan'] ?>
                                    <td>
                                    <!-- jika data absensi sudah ada -->
                                        <div class="d-flex gap-2">
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="H" class="form-check-input" <?= $status == 'H' ? 'checked' : ''; ?>> H
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="I" class="form-check-input" <?= $status == 'I' ? 'checked' : ''; ?>> I
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="A" class="form-check-input" <?= $status == 'A' ? 'checked' : ''; ?>> A
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="T" class="form-check-input" <?= $status == 'T' ? 'checked' : ''; ?>> T
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="S" class="form-check-input" <?= $status == 'S' ? 'checked' : ''; ?>> S
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="keterangan[<?= $s['id_kelas_jilid']; ?>]" class="form-control"><?= $keterangan ?></textarea>
                                    </td>
                                <?php else : ?>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="H" class="form-check-input" checked> H
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="I" class="form-check-input"> I
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="A" class="form-check-input"> A
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="T" class="form-check-input"> T
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="S" class="form-check-input"> S
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="keterangan[<?= $s['id_kelas_jilid']; ?>]" class="form-control" placeholder="Masukan keterangan"></textarea>
                                    </td>
                                <?php endif ?>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end">
                        <button type="submit" name="<?= $adaDataHariIni == 1 ? 'update' : 'submit' ?>" class="btn <?= $adaDataHariIni == 1 ? 'btn-warning' : 'btn-primary'; ?>">
                            <i class="bi <?= $adaDataHariIni == 1 ? 'bi-pencil-square' : 'bi-save'; ?>"></i> 
                            <?= $adaDataHariIni == 1 ? 'Update Absensi' : 'Simpan Absensi'; ?>
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
