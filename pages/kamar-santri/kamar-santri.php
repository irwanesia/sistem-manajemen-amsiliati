<!-- table kamar -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <h4 class="card-title">Data Asrama Santri</h4>
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
                <th> Nama Santri </th>
                <th> Nama Kamar </th>
                <th> Nama Asrama </th>
                <th> Tgl Masuk </th>
                <th> Tgl Keluar </th>
                <th class=""> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_kamar_santri() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_santri'] ?></td>
                  <td><?= $row['nama_kamar'] ?></td>
                  <td><?= $row['nama_asrama'] ?></td>
                  <td><?= $row['tanggal_masuk'] ?></td>
                  <td><?= $row['tanggal_keluar'] == '0000-00-00' ? '-' : $row['tanggal_keluar'] ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_kamar'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_kamar'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Asrama Santri</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/KamarSantriController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

              <div class="form-group row">
                <label for="kamar" class="col-sm-4 col-form-label">Nama Santri</label>
                <div class="col-sm-8">
                  <select name="id_santri" class="form-select">
                    <option value="" disabled selected>-- Pilih --</option>
                    <?php foreach(get_santri() as $santri) : ?>
                      <option value="<?= $santri['id_santri'] ?>"><?= $santri['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="asrama" class="col-sm-4 col-form-label">Asrama</label>
                <div class="col-sm-8">
                    <select class="form-select" id="asrama" name="id_asrama" required>
                        <option value="" selected disabled>-- Pilih Asrama --</option>
                        <?php foreach (get_asrama() as $asrama): ?>
                            <option value="<?= $asrama['id_asrama'] ?>"><?= $asrama['nama_asrama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="kamar" class="col-sm-4 col-form-label">Kamar</label>
                <div class="col-sm-8">
                    <select class="form-select" id="kamar" name="id_kamar" disabled required>
                        <option value="" selected disabled>-- Pilih Kamar --</option>
                        <!-- Opsi kamar akan dimuat via AJAX -->
                    </select>
                    <div class="mt-2" id="loadingKamar" style="display: none;">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <small>Memuat data kamar...</small>
                    </div>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="kamar" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                <div class="col-sm-8">
                  <input type="date" name="tanggal_masuk" class="form-control">
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
<?php foreach (get_kamar_santri() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_kamar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data kamar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/KamarSantriController.php" method="POST">
                
                  <input type="hidden" name="id_kamar_santri" value="<?= $data['id_kamar_santri'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  
                <div class="form-group row">
                  <label for="kamar" class="col-sm-4 col-form-label">Nama Santri</label>
                  <div class="col-sm-8">
                    <select name="id_santri" class="form-select">
                      <option value="" disabled selected>-- Pilih --</option>
                      <?php foreach(get_santri() as $santri) : ?>
                        <option value="<?= $santri['id_santri'] ?>" <?= $santri['id_santri'] == $data['id_santri'] ? 'selected' : '' ?>><?= $santri['nama'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="asrama" class="col-sm-4 col-form-label">Asrama</label>
                  <div class="col-sm-8">
                      <select class="form-select" id="asrama" name="id_asrama" required>
                          <option value="" selected disabled>-- Pilih Asrama --</option>
                          <?php foreach (get_asrama() as $asrama): ?>
                              <option value="<?= $asrama['id_asrama'] ?>" <?= $asrama['id_asrama'] == $data['id_asrama'] ? 'selected' : '' ?>><?= $asrama['nama_asrama'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="kamar" class="col-sm-4 col-form-label">Kamar</label>
                  <div class="col-sm-8">
                      <select class="form-select" id="kamar" name="id_kamar" required>
                          <?php foreach (get_kamar_by_id_asrama($data['id_asrama']) as $kmr): ?>
                              <option value="<?= $kmr['id_kamar'] ?>" <?= $kmr['id_kamar'] == $data['id_kamar'] ? 'selected' : '' ?>><?= $kmr['nama_kamar'] ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="kamar" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                  <div class="col-sm-8">
                    <input type="date" name="tanggal_masuk" class="form-control" value="<?= $data['tanggal_masuk'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kamar" class="col-sm-4 col-form-label">Tanggal Keluar</label>
                  <div class="col-sm-8">
                    <input type="date" name="tanggal_keluar" class="form-control">
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
  <div class="modal fade" id="hapus<?= $data['id_kamar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_kamar'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/KamarSantriController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_kamar" value="<?= $data['id_kamar'] ?>">
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