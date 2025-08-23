<!-- table santri -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Pendaftar</h4>
          <button type="button" class="btn btn-primary btn-rounded " data-bs-toggle="modal" data-bs-target="#add" hidden>
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
                <th> Nama Lengkap </th>
                <th> Tempat Lahir </th>
                <th> Tanggal Lahir </th>
                <th> Jenis Kelamin </th>
                <th> Alamat </th>
                <th> No HP </th>
                <th> tanggal_daftar </th>
                <th class=""> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_pendaftar() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_lengkap'] ?></td>
                  <td><?= $row['tempat_lahir'] ?></td>
                  <td><?= $row['tanggal_lahir'] ?></td>
                  <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                  <td><?= $row['alamat'] ?></td>
                  <td><?= $row['no_hp'] ?></td>
                  <td><?= $row['tanggal_daftar'] ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_pendaftar'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_pendaftar'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Form Pendaftaran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./controllers/PendaftaranController.php" method="POST">
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukan nama lengkap">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Tempat Lahir</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukan tempat lahir">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tanggal_lahir">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-8">
                  <select name="jk" class="form-select">
                    <option value="">--Pilih--</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="alamat" placeholder="Masukan alamat"></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">No HP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="no_hp" placeholder="Masukan nomor handphone">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tanggal Daftar</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tanggal_daftar">
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
<?php foreach (get_pendaftar() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_pendaftar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Form Pendaftar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/PendaftaranController.php" method="POST">
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
                <input type="hidden" name="id_pendaftar" value="<?= $data['id_pendaftar'] ?>">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Tempat Lahir</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-8">
                  <select name="jk" class="form-select">
                    <option value="L" <?= $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="alamat"><?= $data['alamat'] ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">No HP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="no_hp" value="<?= $data['no_hp'] ?>">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tanggal Daftar</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tanggal_daftar" value="<?= $data['tanggal_daftar'] ?>">
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
  <div class="modal fade" id="hapus<?= $data['id_pendaftar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_lengkap'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/PendaftaranController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_pendaftar" value="<?= $data['id_pendaftar'] ?>">
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