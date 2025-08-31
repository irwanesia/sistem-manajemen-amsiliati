<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Laporan Data Santri</h4>
          <a href="./laporan&action=cetak-lap-data-santri" class="btn btn-primary btn-rounded">
            <i class="bi bi-printer"></i> Cetak
          </a>
        </div>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> NIS </th>
                <th> Nama Lengkap </th>
                <th> Jenis Kelamin </th>
                <th> Tanggal Lahir </th>
                <th> Alamat </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_santri() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nis'] ?></td>
                  <td><?= $row['nama'] ?></td>
                  <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                  <td><?= $row['tanggal_lahir'] ?></td>
                  <td><?= $row['alamat'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>