<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success" role="alert" id="alert-message">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<!-- Form setting user -->
<div class="row">
    <div class="col-md-12">
        <!-- --------------- konten -------------  -->
        <!-- modal edit -->
        <?php
        $id = $_GET['id'];
        $dataUser = get_user_by_id($id);
        ?>
        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title">Rangking</h4> -->
                <form action="./controllers/usersController.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="nama" value="<?= $_SESSION['nama'] ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" name="id" class="form-control" value="<?= $dataUser['id'] ?>">
                    <div class="form-group row">
                        <label for="validationFile1" class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-2">
                            <img src="assets/foto/<?= $dataUser['foto'] ?>" width="150" class="img-thumbnail" alt="<?= $dataUser['foto'] ?>">
                        </div>
                        <div class="col-sm-7">
                            <input class="form-control" name="file" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_user" class="form-control" value="<?= $dataUser['nama'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" value="<?= $dataUser['username'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level" class="col-sm-3 col-form-label">Level</label>
                        <div class="col-sm-9">
                            <select name="role" class="form-select">
                                <option value="">--Pilih--</option>
                                <option value="1" <?= $dataUser['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= $dataUser['role'] == 2 ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="setting_user" class="btn btn-primary btn-rounded mt-3"><i class="bi bi-save"></i> Update </button>
                </form>
            </div>
        </div>
    </div>
</div>