<!-- table Kepala Kamar -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Kepala Kamar</h4>
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
                <th> Nama Kepala Kamar </th>
                <th> Nama Kamar </th>
                <th> No Hp </th>
                <th> Tgl Diangkat </th>
                <th class=""> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_kepala_kamar() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_kepala'] ?></td>
                  <td><?= $row['nama_kamar'] ?> (<?= $row['nama_asrama'] ?>)</td>
                  <td><?= $row['no_hp'] ?></td>
                  <td><?= $row['tanggal_diangkat'] ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_kepala_kamar'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_kepala_kamar'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Kepala Kamar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/KepalaKamarController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Kepala</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_kepala" placeholder="Masukan Kepala Kamar">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Kamar</label>
                <div class="col-sm-8">
                  <select class="form-select" name="id_kamar">
                    <option value="" selected disabled>-- Pilih Kamar --</option>
                    <?php foreach (get_kamar() as $kamar): ?>
                      <option value="<?= $kamar['id_kamar'] ?>"><?= $kamar['nama_kamar'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">No HP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="no_hp" placeholder="Masukan No HP">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tanggal Diangkat</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="tanggal_diangkat" placeholder="Masukan Tanggal Diangkat">
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
<?php foreach (get_kepala_kamar() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_kepala_kamar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data Kepala Kamar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/KepalaKamarController.php" method="POST">
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                
                  <input type="hidden" name="id_kepala_kamar" value="<?= $data['id_kepala_kamar'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  
                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Nama Kepala</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama_kepala" value="<?= $data['nama_kepala'] ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Nama Kamar</label>
                  <div class="col-sm-8">
                    <select class="form-select" name="id_kamar">
                      <option value="" disabled>-- Pilih kamar --</option>
                      <?php foreach (get_kamar() as $kamar): ?>
                        <option value="<?= $kamar['id_kamar'] ?>" <?= $kamar['id_kamar'] == $data['id_kamar'] ? 'selected' : '' ?>>
                          <?= $kamar['nama_kamar'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">No HP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="no_hp" placeholder="Masukan No HP">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="" class="col-sm-4 col-form-label">Tanggal Diangkat</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" name="tanggal_diangkat" value="<?= $data['tanggal_diangkat'] ?>">
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
  <div class="modal fade" id="hapus<?= $data['id_kepala_kamar'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_kepala'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/KepalaKamarController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_kepala_kamar" value="<?= $data['id_kepala_kamar'] ?>">
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