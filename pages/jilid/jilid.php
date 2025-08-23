<!-- table kriteria -->
<div class="row">
  <div class="col-md-12">
    <!-- --------------- konten -------- -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Data Jilid</h4>
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
          <table class="table mb-0 table-hover" id="table1">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama Jilid </th>
                <th> Deskripsi </th>
                <th> Ustadzah/Pengajar </th>
                <th> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_jilid() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_jilid'] ?></td>
                  <td><?= $row['deskripsi'] ?></td>
                  <td><?= $row['nama_ustadzah'] ?></td>
                  <td class="">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_jilid'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_jilid'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data Jilid</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <form action="./controllers/jilidController.php" method="POST">
              <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Jilid</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama_jilid" placeholder="Masukan nama jilid">
                </div>
              </div>
              
              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Deskripsi</label>
                <div class="col-sm-8">
                  <textarea class="form-control" name="deskripsi" placeholder="Masukan deskripsi"></textarea>
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
<?php foreach (get_jilid() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data jilid</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/jilidController.php" method="POST">
                
                  <input type="hidden" name="id_jilid" value="<?= $data['id_jilid'] ?>">
                  <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  
                <div class="form-group row">
                  <label for="jilid" class="col-sm-4 col-form-label">Nama Jilid</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama_jilid" value="<?= $data['nama_jilid'] ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="jilid" class="col-sm-4 col-form-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="deskripsi" placeholder="Masukan deskripsi"><?= $data['deskripsi'] ?></textarea>
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
  <div class="modal fade" id="hapus<?= $data['id_jilid'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus data <?= $data['nama_jilid'] ?></h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/jilidController.php" method="POST">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_jilid" value="<?= $data['id_jilid'] ?>">
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