<?php
// Tangkap pilihan bulan dan tahun dari URL
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$jilid = isset($_GET['jilid']) ? intval($_GET['jilid']) : null;

?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Input Absensi Harian</h5>
    </div>
    <div class="card-body">
        
        <!-- Filter -->
        <div class="row mb-4">
            <!-- Tahun Ajaran -->
            <div class="col-md-4">
                <label class="form-label">Tahun Ajaran</label>
                <select name="tahun_ajaran_id" class="form-select tahunSelect" onchange="updateFilter()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach (get_tahun_ajaran() as $ta): ?>
                        <option value="<?= $ta['id_tahun']; ?>" <?= ($thn == $ta['id_tahun']) ? 'selected' : ''; ?>>
                            <?= $ta['tahun']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Jilid -->
            <div class="col-md-4">
                <label class="form-label">Jilid</label>
                <select name="jilid_id" class="form-select jilidSelect" onchange="updateFilter()">
                    <option value="">-- Pilih Jilid --</option>
                    <?php foreach (get_jilid() as $j): ?>
                        <option value="<?= $j['id_jilid']; ?>" <?= ($jilid == $j['id_jilid']) ? 'selected' : ''; ?>>
                            <?= $j['nama_jilid']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <script>
            function updateFilter() {
                // Ambil value dari dropdown
                var tahunId = document.querySelector('.tahunSelect').value;
                var jilidId = document.querySelector('.jilidSelect').value;
                
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

        <!-- Form Absensi -->
        <?php 
        // Cek apakah parameter tahun dan jilid ada
        $hasFilter = isset($thn) && isset($jilid);
        // Cek apakah ada data absensi
        $absensiData = $hasFilter ? get_absensi($thn, $jilid) : [];
        $kelasJilidId = $absensiData[0]['id_kelas_jilid'] ?? null; 
        $tanggalHariIni = date('Y-m-d');
        $adaDataHariIni = cekAbsensi($tanggalHariIni, $kelasJilidId)['total'] ?? 0;
        // var_dump($adaDataHariIni); // Debugging untuk melihat data absensi
        ?>

        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        
        <small>
            <?= $adaDataHariIni == 1 ? '*sudah dilakukan absensi' : '' ?>
        </small> 
        <?php if ($hasFilter): ?>
            <?php if (!empty($absensiData)): ?>
                <form method="POST" action="./controllers/AbsensiController.php">
                    <input type="hidden" name="tahun_ajaran_id" value="<?= $thn; ?>">
                    <input type="hidden" name="jilid_id" value="<?= $jilid; ?>">

                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width:40%">Nama Santri</th>
                                <th style="width:20%">Asrama</th>
                                <th style="width:40%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($absensiData as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['nama']); ?></td>
                                <td><?= htmlspecialchars($s['nama_asrama']); ?></td>
                                <td>
                                    <!-- jika data absensi sudah ada -->
                                    <?php if($adaDataHariIni == 1) : ?>
                                        <div class="d-flex gap-2">
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="H" class="form-check-input" <?= get_status_absensi($s['id_kelas_jilid']) == 'H' ? 'checked' : ''; ?>> H
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="I" class="form-check-input" <?= get_status_absensi($s['id_kelas_jilid']) == 'I' ? 'checked' : ''; ?>> I
                                            </label>
                                            <label class="form-check-label">
                                                <input type="radio" name="status[<?= $s['id_kelas_jilid']; ?>]" value="A" class="form-check-input" <?= get_status_absensi($s['id_kelas_jilid'] == 'A') ? 'checked' : ''; ?>> A
                                            </label>
                                        </div>
                                    <?php else : ?>
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
                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end">
                        <button type="submit" name="<?= $adaDataHariIni == 1 ? 'update' : 'submit' ?>" class="btn <?= $adaDataHariIni == 1 ? 'btn-warning' : 'btn-success'; ?>">
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
