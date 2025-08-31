<!-- table santri -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <h4 class="card-title">Daftar Santri</h4>
          <div class="">
            <button type="button" class="btn btn-primary btn-rounded " data-bs-toggle="modal" data-bs-target="#add">
              <i class="bi bi-plus-circle"></i> Tambah
            </button>
            <!-- import excel -->
            <button type="button" class="btn btn-primary btn-success" data-bs-toggle="modal" data-bs-target="#input">
              <i class="bi bi-box-arrow-up"></i> Import
            </button>

          </div>
        </div>
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
                <th> Nama Lengkap </th>
                <th> Tempat Lahir </th>
                <th> Tanggal Lahir </th>
                <th> JK </th>
                <th> Alamat </th>
                <th> Status </th>
                <th class=""> Aksi </th>
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
                  <td><?= $row['tempat_lahir'] ?></td>
                  <td><?= $row['tanggal_lahir'] ?></td>
                  <td><?= $row['jenis_kelamin'] ?></td>
                  <td><?= $row['alamat'] ?></td>
                  <td><?= $row['status_aktif'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_santri'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_santri'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Santri</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/santriController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">NIS</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nis" placeholder="Masukan NIS">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_santri" placeholder="Masukan nama santri">
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
                <label for="" class="col-sm-4 col-form-label">Tempat Lahir</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tgl_lahir">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="alamat" placeholder="Masukan alamat"></textarea>
                </div>
              </div>
              

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <select name="status" class="form-select">
                    <option value="">-- Pilih --</option>
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

    <div class="modal fade" id="input" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addLabel">Import Data Santri</h1>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- <form action="./controllers/penilaianController.php" method="POST"> -->
          <form method="post" id="import_excel_form" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="card">
                <div class="card-body">
                  <span id="message"></span>
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  <input type="file" name="import_excel" />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
              <!-- <button type="submit" name="import" id="import" class="btn btn-primary btn-rounded"><i class="fa fa-save"></i> Simpan</button> -->
              <input type="submit" name="import" id="import" class="btn btn-primary btn-rounded" value="Import" />
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- modal edit -->
<?php foreach (get_santri() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_santri'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data santri</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/santriController.php" method="POST">
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
                <input type="hidden" name="id_santri" value="<?= $data['id_santri'] ?>">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">NIS</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nis" value="<?= $data['nis'] ?>">
                </div>
              </div>

              <div class="form-group row">
                <label for="santri" class="col-sm-4 col-form-label">Nama Lengkap</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_santri" value="<?= $data['nama'] ?>">
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
                <label for="" class="col-sm-4 col-form-label">Tempat Lahir</label>
                <div class="col-sm-8">
                  <input type="text" name="tempat_lahir" class="form-control" value="<?= $data['tempat_lahir'] ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-8">
                  <input type="date" name="tanggal_lahir" class="form-control" value="<?= $data['tanggal_lahir'] ?>">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="alamat"><?= $data['alamat'] ?></textarea>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <select name="status" class="form-select">
                    <option value="1" <?= $data['status_aktif'] == '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= $data['status_aktif'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
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
  <div class="modal fade" id="hapus<?= $data['id_santri'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/santriController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_santri" value="<?= $data['id_santri'] ?>">
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