<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Daftar Kriteria</h4>
          <a href="./laporan&action=cetak-kriteria" class="btn btn-primary btn-rounded">
            <i class="bi bi-printer"></i> Cetak
          </a>
        </div>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> Kode </th>
                <th> Kriteria </th>
                <th> Type </th>
                <th> Bobot </th>
                <th> Sub kriteria </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_kriteria() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['kode'] ?></td>
                  <td><?= $row['nama_kriteria'] ?></td>
                  <td><?= $row['type'] ?></td>
                  <td><?= $row['bobot'] ?></td>
                  <td><?= $row['tipe_penilaian'] == 1 ? 'Sub kriteria' : 'Input langsung' ?></td>
                  
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>