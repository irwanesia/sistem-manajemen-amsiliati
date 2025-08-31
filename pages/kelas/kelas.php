<!-- table kelas -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Jilid Santri</h4>
          <button type="button" class="btn btn-primary btn-rounded " data-bs-toggle="modal" data-bs-target="#add">
            <i class="bi bi-plus-circle"></i> Tambah
          </button>
        </div>
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
                <th> Jilid/Kelas </th>
                <th> Jumlah </th>
                <th> Mu'allim </th>
                <th> Tahun Ajaran </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $nomor = 1;
              foreach (get_kelas_jilid() as $row) : ?>
                <tr data-bs-toggle="collapse" data-bs-target="#collapse<?= $row['jilid_id'] . $row['tahun_ajaran_id'] ?>" aria-expanded="false" aria-controls="collapse<?= $row['jilid_id'] . $row['tahun_ajaran_id'] ?>" style="cursor: pointer;">
                  <td>
                    <i class="bi bi-chevron-down"></i> <?= $nomor++ ?>
                  </td>
                  <td><?= $row['nama_jilid'] ?></td>
                  <td><?= $row['jumlah_santri'] ?></td>
                  <td><?= $row['nama_ustadzah'] ?></td>
                  <td><?= $row['tahun'] ?></td>
                </tr>
                <tr class="collapse-detail">
                        <td colspan="7" class="p-0 border-0">
                            <div class="collapse" id="collapse<?= $row['jilid_id'] . $row['tahun_ajaran_id'] ?>">
                                <div class="card card-body border-0 rounded-0">
                                    <h6 class="mb-3">Detail Jilid: <?= $row['nama_jilid'] ?></h6>
                                    <table class="table mb-0 table-hover" id="table1">
                                      <thead>
                                        <tr>
                                          <th> No </th>
                                          <th> Nama Santri </th>
                                          <th> Aksi </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $no = 1;
                                        foreach (get_santri_by_id_jilid($row['jilid_id'], $row['tahun_ajaran_id']) as $santri) : ?>
                                          <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $santri['nama'] ?></td>
                                            <td>
                                              <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $santri['id_kelas_jilid'] ?>"> 
                                                <i class="bi bi-pencil-square"></i>
                                              </button>
                                              <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $santri['id_kelas_jilid'] ?>">
                                                <i class="bi bi-trash"></i>
                                              </button>
                                            </td>
                                          </tr>
                                        <?php endforeach ?>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal add -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Jilid</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/kelasController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Jilid</label>
                <div class="col-sm-8">
                  <select class="form-select" name="id_jilid">
                    <option value="" selected disabled>-- Pilih jilid --</option>
                    <?php foreach (get_jilid() as $jilid): ?>
                      <option value="<?= $jilid['id_jilid'] ?>"><?= $jilid['nama_jilid'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Santri</label>
                <div class="col-sm-8">
                  <select class="form-select" name="id_santri">
                    <option value="" selected disabled>-- Pilih Santri --</option>
                    <?php foreach (get_santri() as $santri): ?>
                      <option value="<?= $santri['id_santri'] ?>"><?= $santri['nama'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tahun Ajaran</label>
                <div class="col-sm-8">
                  <select class="form-select" name="id_tahun">
                    <option value="" selected disabled>-- Pilih Tahun --</option>
                    <?php foreach (get_tahun_ajaran() as $ust): ?>
                      <option value="<?= $ust['id_tahun'] ?>"><?= $ust['tahun'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Batal</button>
        <button type="submit" name="submit" class="btn btn-primary btn-rounded"><i class="bi bi-save"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- modal edit -->
<?php foreach (get_kelas() as $data) : ?>

  <div class="modal fade" id="edit<?= $data['id_kelas_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data Kelas Jilid</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/kelasController.php" method="POST">
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                
                  <input type="hidden" name="id_kelas_jilid" value="<?= $data['id_kelas_jilid'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Jilid</label>
                  <div class="col-sm-8">
                    <select class="form-select" name="id_jilid">
                      <option value="" selected disabled>-- Pilih jilid --</option>
                      <?php foreach (get_jilid() as $jilid): ?>
                        <option value="<?= $jilid['id_jilid'] ?>" <?= $data['jilid_id'] == $jilid['id_jilid'] ? 'selected' : '' ?>><?= $jilid['nama_jilid'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Nama Santri </label>
                  <div class="col-sm-8">
                    <select class="form-select" name="id_santri">
                      <option value="" selected disabled>-- Pilih Santri --</option>
                      <?php foreach (get_santri() as $santri): ?>
                        <option value="<?= $santri['id_santri'] ?>" <?= $data['santri_id'] == $santri['id_santri'] ? 'selected' : '' ?>><?= $santri['nama'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Tahun Ajaran</label>
                  <div class="col-sm-8">
                    <select class="form-select" name="id_tahun">
                      <option value="" selected disabled>-- Pilih Tahun --</option>
                      <?php foreach (get_tahun_ajaran() as $thn): ?>
                        <option value="<?= $thn['id_tahun'] ?>" <?= $data['tahun_ajaran_id'] == $thn['id_tahun'] ? 'selected' : '' ?>><?= $thn['tahun'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Batal</button>
          <button type="submit" name="update" class="btn btn-primary btn-rounded"><i class="bi bi-save"></i> Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- modal hapus -->
  <div class="modal fade" id="hapus<?= $data['id_kelas_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_jilid'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/kelasController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_kelas_jilid" value="<?= $data['id_kelas_jilid'] ?>">
                yakin akan menghapus data ini?
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal"><i class="bi bi-x-circle"> Batal</i></button>
          <button type="submit" name="delete" class="btn btn-primary btn-rounded"><i class="bi bi-check-circle"></i> Ya</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>