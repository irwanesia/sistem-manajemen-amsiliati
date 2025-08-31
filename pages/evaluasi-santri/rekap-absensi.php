
<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
if ($_SESSION['role'] == 'Ustadzah') {
    $id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
} elseif ($_SESSION['role'] == 'Wali Kelas') {
    $id_ustadzah = isset($_GET['jilid']) ? $_GET['jilid'] : null;
}
?>

<div class="card mt-4">
    <div class="card-body">
            <div class="row d-flex justify-content-between">
                <div class="col-md-8">
                    <h4>Rekap Absensi Santri</h4>
                </div>
            
                <?php if ($_SESSION['role'] == 'Wali Kelas') : ?>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-5">
                                <select id="jilid" class="form-select jilidSelect" onchange="updateFilter()">
                                    <option value="">-- Jilid --</option>
                                    <?php foreach (get_jilid() as $ta): ?>
                                        <option value="<?= $ta['id_ustadzah'] ?>" <?= ($ta['id_ustadzah'] == $id_ustadzah) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ta['nama_jilid']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <select id="tahun" class="form-select tahunSelect" onchange="updateFilter()">
                                    <option value="">-- Semester --</option>
                                    <?php foreach (get_tahun_ajaran() as $ta): ?>
                                        <option value="<?= $ta['id_tahun'] ?>" <?= ($ta['id_tahun'] == $thn) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ta['semester'] ." - ".$ta['tahun']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-md-4">
                         <select id="tahun" class="form-select tahunSelect" onchange="location.href='?tahun=' + this.value">
                            <option value="">-- Semester --</option>
                            <?php foreach (get_tahun_ajaran() as $ta): ?>
                                <option value="<?= $ta['id_tahun'] ?>" <?= ($ta['id_tahun'] == $thn) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ta['semester'] ." - ".$ta['tahun']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif ?>
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

        <div class="mt-4 mb-5">
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-md-4">
                    <strong>Nama Ustadzah:</strong> <?= get_nama_ustadzah_by_id($id_ustadzah) ?? '-' ?>
                    </div>
                    <div class="col-md-4">
                    <strong>Tanggal:</strong> <?= htmlspecialchars($tgl) ?? '-' ?></li>
                    </div>
                    <div class="col-md-4">
                    <strong>Tahun Ajaran:</strong> <?= get_tahun_ajaran_by_id($thn)['tahun'] ?? '-' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover" id="table1">
                <thead class="">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>Asrama</th>
                        <th>Jilid</th>
                        <th>Total Pertemuan</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>Terlambat</th>
                        <th>Sakit</th>
                        <th>% Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty(get_rekap_absensi_for_ustadzah($id_ustadzah, $thn))): ?>
                        <?php foreach (get_rekap_absensi_for_ustadzah($id_ustadzah, $thn) as $i => $row): ?>
                            <?php
                                // Hitung persentase, cek agar tidak bagi nol
                                $persentase = ($row['total_pertemuan'] > 0) 
                                    ? round(($row['total_hadir'] / $row['total_pertemuan']) * 100, 2) 
                                    : 0;
                            ?>
                            <tr class="text-center">
                                <td><?= $i + 1 ?></td>
                                <td class="text-start"><?= htmlspecialchars($row['nama_santri']) ?></td>
                                <td><?= htmlspecialchars($row['nama_asrama'] ." | " . $row['nama_kamar']) ?></td>
                                <td><?= htmlspecialchars($row['nama_jilid']) ?></td>
                                <td><?= $row['total_pertemuan'] ?></td>
                                <td><?= $row['total_hadir'] ?></td>
                                <td><?= $row['total_izin'] ?></td>
                                <td><?= $row['total_alfa'] ?></td>
                                <td><?= $row['total_terlambat'] ?></td>
                                <td><?= $row['total_sakit'] ?></td>
                                <td><?= $persentase ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data absensi</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
