<!-- table kriteria -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Tahun Ajaran</h4>
          <button type="button" class="btn btn-primary btn-rounded " data-bs-toggle="modal" data-bs-target="#add">
            <i class="bi bi-plus-circle"></i> Tambah
          </button>
        </div>
        <div class="table-responsive mt-3">
          <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success" role="alert" id="alert-message">
              <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
          <?php endif; ?>
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> Semester </th>
                <th> Tahun </th>
                <th> Status </th>
                <th> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_tahun_ajaran() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['semester'] ?></td>
                  <td><?= $row['tahun'] ?></td>
                  <td><?= $row['is_aktif'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_tahun'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_tahun'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Tahun Ajaran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/TahunAjaranController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Semester</label>
                <div class="col-sm-8">
                  <select class="form-select" name="semester" required>
                    <option value="" disabled selected>Pilih Semester</option>
                    <option value="Ganjil">Semester Ganjil</option>
                    <option value="Genap">Semester Genap</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tahun</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tahun" placeholder="Contoh: 2024/2025" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <select class="form-select" name="is_aktif" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
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
<?php foreach (get_tahun_ajaran() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_tahun'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data Tahun Ajaran</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/TahunAjaranController.php" method="POST">
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                
                  <input type="hidden" name="id_tahun" value="<?= $data['id_tahun'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  
                  <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Semester</label>
                    <div class="col-sm-8">
                      <select class="form-select" name="semester" required>
                        <option value="Ganjil" <?= $data['semester'] == 'Ganjil' ? 'Selected' : '' ?>>Semester Ganjil</option>
                        <option value="Genap" <?= $data['semester'] == 'Genap' ? 'Selected' : '' ?>>Semester Genap</option>
                      </select>
                    </div>
                  </div>
                  
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Tahun</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="tahun" value="<?= $data['tahun'] ?>" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Status</label>
                  <div class="col-sm-8">
                    <select class="form-select" name="is_aktif" required>
                      <option value="" disabled selected>Pilih Status</option>
                      <option value="1" <?= $data['is_aktif'] == 1 ? 'Selected' : '' ?>>Aktif</option>
                      <option value="0" <?= $data['is_aktif'] == 0 ? 'Selected' : '' ?>>Tidak Aktif</option>
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
  <div class="modal fade" id="hapus<?= $data['id_tahun'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_jilid'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/TahunAjaranController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_tahun" value="<?= $data['id_tahun'] ?>">
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