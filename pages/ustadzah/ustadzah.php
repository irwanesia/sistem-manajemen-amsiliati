<!-- table ustadzah -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Ustadzah</h4>
          <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#add">
            <i class="bi bi-plus-circle"></i> Tambah
          </button>
        </div>
        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success my-3" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover" id="table1">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama Ustadzah </th>
                <th> Kamar </th>
                <th> Jabatan </th>
                <th> Alamat </th>
                <th class="<?php ?>"> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_ustadzah_kamar() as $row) :
              ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_ustadzah'] ?></td>
                  <td><?= $row['nama_kamar'] ?></td>
                  <td><?= $row['jabatan'] ?></td>
                  <td class="<?php ?>">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_ustadzah'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_ustadzah'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Ustadzah</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/ustadzahController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Ustadzah</label>
                <div class="col-sm-8">
                  <input type="text" name="nama_ustadzah" class="form-control" placeholder="Masukan nama ustadzah">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Kamar</label>
                <div class="col-sm-8">
                  <select name="id_kamar" class="form-select">
                    <option value="" disabled selected>-- Pilih Kamar --</option>
                    <?php foreach(get_asrama_kamar() as $kmr) :?>
                      <option value="<?= $kmr['id_kamar'] ?>"><?= $kmr['nama_kamar'] . " (". $kmr['nama_asrama'] .")" ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Jabatan</label>
                <div class="col-sm-8">
                  <select name="jabatan" class="form-select">
                    <option value="" selected disabled>-- Pilih Jabatan --</option>
                    <option value="Sekretaris">Sekretaris</option>
                    <option value="Mu'allim">Mu'allim</option>
                    <option value="Bendahara">Bendahara</option>
                  </select>
                </div>
              </div>

              <div class="form-group row" hidden>
                <label for="" class="col-sm-4 col-form-label">No HP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" value="-">
                </div>
              </div>
              
              <div class="form-group row" hidden>
                <label for="" class="col-sm-4 col-form-label">Alamat</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="alamat" placeholder="Masukan alamat">-</textarea>
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

<?php foreach (get_ustadzah_kamar() as $data) : ?>
  <!-- modal edit -->
  <div class="modal fade" id="edit<?= $data['id_ustadzah'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data ustadzah</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./controllers/ustadzahController.php" method="POST">
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                  <input type="hidden" name="id_ustadzah" value="<?= $data['id_ustadzah'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Ustadzah</label>
                <div class="col-sm-8">
                  <input type="text" name="nama_ustadzah" class="form-control" value="<?= $data['nama_ustadzah'] ?>">
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Kamar</label>
                <div class="col-sm-8">
                  <select name="id_kamar" class="form-select">
                    <option value="" disabled selected>-- Pilih Kamar --</option>
                    <?php foreach(get_asrama_kamar() as $kmr) :?>
                      <option value="<?= $kmr['id_kamar'] ?>" <?= $kmr['id_kamar'] == $data['id_kamar'] ? 'selected' : '' ?>><?= $kmr['nama_kamar'] . " (". $kmr['nama_asrama'] .")" ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Jabatan</label>
                <div class="col-sm-8">
                  <select name="jabatan" class="form-select">
                    <option value="" selected disabled>-- Pilih Jabatan --</option>
                    <option value="Sekretaris" <?= $data['jabatan'] == 'Sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
                    <option value="Mu'allim" <?= $data['jabatan'] == "Mu'allim" ? 'selected' : '' ?>>Mu'allim</option>
                    <option value="Bendahara" <?= $data['jabatan'] == 'Bendahara' ? 'selected' : '' ?>>Bendahara</option>
                  </select>
                </div>
              </div>

                <div class="form-group row" hidden>
                  <label for="" class="col-sm-4 col-form-label">No HP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="no_hp" value="<?= $data['no_hp'] ?>">
                  </div>
                </div>
                
                <div class="form-group row" hidden>
                  <label for="" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="alamat"><?= $data['alamat'] ?></textarea>
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
  <div class="modal fade" id="hapus<?= $data['id_ustadzah'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_ustadzah'] ?></h6>
        </div>
        <div class="modal-body">
          <form action="./controllers/ustadzahController.php" method="POST">
            <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="id_ustadzah" value="<?= $data['id_ustadzah'] ?>">
            yakin akan menghapus data ini?
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