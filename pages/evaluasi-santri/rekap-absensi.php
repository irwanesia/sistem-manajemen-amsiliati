
<?php
$thn = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$tgl = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); // string, default hari ini
$id_ustadzah = isset($_SESSION['id_ustadzah']) ? intval($_SESSION['id_ustadzah']) : null;
?>

<div class="card mt-4">
    <div class="card-body">
            <div class="row d-flex justify-content-between">
                <div class="col-md-9">
                    <h4>Rekap Absensi Santri</h4>
                </div>
            <!-- filter tahun-->
                <div class="col-md-3">
                    <select id="tahun" class="form-select" onchange="location.href='?tahun=' + this.value">
                        <option value="">-- Semester --</option>
                        <?php foreach (get_tahun_ajaran() as $ta): ?>
                            <option value="<?= $ta['id_tahun'] ?>" <?= ($ta['id_tahun'] == $thn) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ta['semester'] ." - ".$ta['tahun']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
             </div>
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
