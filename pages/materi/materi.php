<!-- table materi -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Manajemen Materi</h4>
            <button type="button" class="btn btn-primary btn-rounded " data-bs-toggle="modal" data-bs-target="#add">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>

        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success mt-2" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jilid</th>
                    <th>Nama Materi</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach (get_materi() as $row) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_jilid'] ?></td>
                        <td><?= $row['nama_materi'] ?></td>
                        <td><?= $row['deskripsi'] ?></td>
                        <td><?= $row['urutan'] ?></td>
                        <td><span class="badge bg-success"><?= $row['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></span></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_materi'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_materi'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Materi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./controllers/materiController.php" method="POST">
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Jilid</label>
                        <div class="col-sm-8">
                        <select class="form-select" name="id_jilid">
                            <option value="" selected disabled>-- Pilih Jilid --</option>
                            <?php foreach (get_jilid() as $jilid): ?>
                            <option value="<?= $jilid['id_jilid'] ?>"><?= $jilid['nama_jilid'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="materi" class="col-sm-4 col-form-label">Nama Materi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_materi" placeholder="Masukan nama materi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="deskripsi" placeholder="Masukan deskripsi"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Urutan</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="urutan" placeholder="Masukan urutan"></input>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Status Aktif</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="aktif">
                                <option value="" disabled>-- Pilih Status --</option>
                                <option value="1" selected>Aktif</option>
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
<?php foreach (get_materi() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_materi'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data materi</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/materiController.php" method="POST">
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        
                        <input type="hidden" name="id_materi" value="<?= $data['id_materi'] ?>">
                        <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                        
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Jilid</label>
                            <div class="col-sm-8">
                            <select class="form-select" name="id_jilid">
                                <option value="" selected disabled>-- Pilih Jilid --</option>
                                <?php foreach (get_jilid() as $jilid): ?>
                                <option value="<?= $jilid['id_jilid'] ?>" <?= $jilid['id_jilid'] == $data['id_jilid'] ? 'selected' : '' ?>><?= $jilid['nama_jilid'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="materi" class="col-sm-4 col-form-label">Nama Materi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_materi" value="<?= $data['nama_materi'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Deskripsi</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="deskripsi"><?= $data['deskripsi'] ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Urutan</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="urutan" value="<?= $data['urutan'] ?>"></input>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Status Aktif</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="aktif">
                                    <option value="" selected disabled>-- Pilih Status --</option>
                                    <option value="1" <?= $data['aktif'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= $data['aktif'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
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
  <div class="modal fade" id="hapus<?= $data['id_materi'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_materi'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/materiController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_materi" value="<?= $data['id_materi'] ?>">
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

