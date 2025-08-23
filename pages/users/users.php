<!-- table User -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Daftar Users</h4>
          <button type="button" class="btn btn-primary btn-rounded <?php ?>" data-bs-toggle="modal" data-bs-target="#add">
            <i class="bi bi-plus-circle"></i> Tambah
          </button>
        </div>
        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success" role="alert" id="alert-message">
            <?php echo htmlspecialchars($_GET['message']); ?>
          </div>
        <?php endif; ?>
        <div class="table-responsive mt-3">
          <table class="table mb-0 table-hover">
            <thead>
              <tr>
                <th> No </th>
                <th> Nama </th>
                <th> Username </th>
                <th> Role </th>
                <th> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach (get_users() as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_lengkap'] == null ? $row['nama_ustadzah'] : $row['nama_lengkap'] ?></td>
                  <td><?= $row['username'] ?></td>
                  <td><?= $row['role'] ?></td>
                  <td class="<?php  ?>">
                    <button type="button" class="btn btn-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_user'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_user'] ?>">
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
        <h1 class="modal-title fs-5" id="addLabel">Tambah Data User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./controllers/usersController.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                
                <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label">Level</label>
                <div class="col-sm-9">
                  <select name="role" id="roleSelect" class="form-select">
                    <option value="">--Pilih--</option>
                    <option value="Admin">Admin</option>
                    <option value="Koordinator">Koordinator</option>
                    <option value="Wali Kelas">Wali Kelas</option>
                    <option value="Ustadzah">Ustadzah</option>
                  </select>
                </div>
              </div>

              <!-- Jika level ustadzah tampilkan select dari data ustadzah -->
              <div class="form-group row" id="ustadzahSelectGroup" style="display:none;">
                <label for="ustadzah_id" class="col-sm-3 col-form-label">Ustadzah</label>
                <div class="col-sm-9">
                  <select name="ustadzah_id" class="form-select">
                    <option value="">--Pilih Ustadzah--</option>
                    <?php foreach (get_ustadzah() as $ustadzah): ?>
                      <option value="<?= $ustadzah['id_ustadzah'] ?>"><?= htmlspecialchars($ustadzah['nama_ustadzah']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row" id="namaLengkapGroup" style="display:none;">
                <label for="validationCustom01" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                  <input type="text" name="nama" class="form-control" placeholder="Masukan nama" autofocus>
                </div>
              </div>

                <div class="form-group row">
                  <label for="username" class="col-sm-3 col-form-label">Username</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="username" placeholder="Masukan username">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" name="password1" placeholder="**********">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Confirm Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" name="password2" placeholder="**********">
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

<script>
document.addEventListener("DOMContentLoaded", function () {
  const roleSelect = document.getElementById("roleSelect");
  const ustadzahGroup = document.getElementById("ustadzahSelectGroup");
  const namaGroup = document.getElementById("namaLengkapGroup");

  function toggleFields() {
    if (roleSelect.value === "Ustadzah") {
      ustadzahGroup.style.display = "flex"; // pakai flex karena row bootstrap
      namaGroup.style.display = "none";
    } else if (roleSelect.value) {
      ustadzahGroup.style.display = "none";
      namaGroup.style.display = "flex";
    } else {
      ustadzahGroup.style.display = "none";
      namaGroup.style.display = "none";
    }
  }

  roleSelect.addEventListener("change", toggleFields);
});
</script>

<!-- modal edit -->
<?php foreach (get_users() as $data) : ?>
  <div class="modal fade" id="edit<?= $data['id_user'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addLabel">Edit Data User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <form action="./controllers/usersController.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="id_user" class="form-control" value="<?= $data['id_user'] ?>">
                <div class="form-group row">
                  <label for="level" class="col-sm-3 col-form-label">Level</label>
                  <div class="col-sm-9">
                    <select name="role" class="form-select">
                      <option value="Admin" <?= $data['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                      <option value="Koordinator" <?= $data['role'] == 'Koordinator' ? 'selected' : '' ?>>Koordinator</option>
                      <option value="Wali Kelas" <?= $data['role'] == 'Wali Kelas' ? 'selected' : '' ?>>Wali Kelas</option>
                      <option value="Ustadzah" <?= $data['role'] == 'Ustadzah' ? 'selected' : '' ?>>Ustadzah</option>
                    </select>
                  </div>
                </div>

                <?php if ($data['role'] == 'Ustadzah'): ?>
                  <div class="form-group row">
                    <label for="ustadzah_id" class="col-sm-3 col-form-label">Ustadzah</label>
                    <div class="col-sm-9">
                      <select name="ustadzah_id" class="form-select">
                        <option value="">--Pilih Ustadzah--</option>
                        <?php foreach (get_ustadzah() as $ust): ?>
                          <option value="<?= $ust['id_ustadzah'] ?>" <?= $data['id_ustadzah'] == $ust['id_ustadzah'] ? 'selected' : '' ?>><?= htmlspecialchars($ust['nama_ustadzah']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="nama" class="form-control" value="<?= $data['nama_lengkap'] ?>">
                    </div>
                  </div>
                <?php endif ?>

                <div class="form-group row">
                  <label for="username" class="col-sm-3 col-form-label">Username</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="username" value="<?= $data['username'] ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" name="password1" placeholder="**********">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Confirm Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" name="password2" placeholder="**********">
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
  <div class="modal fade" id="hapus<?= $data['id_user'] ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h6 class="text-white">Hapus user <?= $data['nama_lengkap'] ?></h6>
        </div>
        <div class="modal-body">
          <form action="./controllers/usersController.php" method="POST">
            <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="id_user" value="<?= $data['id'] ?>">
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