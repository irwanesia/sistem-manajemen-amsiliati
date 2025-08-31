<?php
$thn_id = isset($_GET['tahun']) ? intval($_GET['tahun']) : null;
$jilid_id = isset($_GET['jilid']) ? $_GET['jilid'] : null; // string, default hari ini
?>
<!-- table Legger -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
          <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Data Legger</h5>
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
                            <option value="<?= $ta['id_tahun']; ?>" <?= ($thn_id == $ta['id_tahun']) ? 'selected' : ''; ?>>
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
          var jilidId = document.querySelector('.jilidId').value;
          var tahunId = document.querySelector('.tahunSelect').value;                
                  
          // Buat parameter URL
          var params = new URLSearchParams();
                  
          if (jilidId) params.append('jilid', jilidId);
          if (tahunId) params.append('tahun', tahunId);
                  
          // Update URL dengan mempertahankan base URL yang benar
          var baseUrl = window.location.href.split('?')[0];
          if (params.toString()) {
              window.location.href = baseUrl + '?' + params.toString();
          } else {
              window.location.href = baseUrl;
          }
        }
      </script>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['error']); ?>
          </div>
        <?php endif; ?>
        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover" id="table1">
            <thead>
              <tr>
                <th> No </th>
                <th> NIS </th>
                <th> Nama Santri </th>
                <th> Nilai Tulis </th>
                <th> Nilai Lisan </th>
                <th> Rata-rata </th>
                <th> Keterangan </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_legger($jilid_id, $thn_id) as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nis'] ?></td>
                  <td><?= $row['nama'] ?></td>
                  <td><?= $row['nilai_tulis'] ?></td>
                  <td><?= $row['nilai_lisan'] ?></td>
                  <td><?= $row['rata_rata'] ?></td>
                  <td><?= $row['rata_rata'] >= 95 ? 'Siswa Terbaik' : 'Lulus' ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
