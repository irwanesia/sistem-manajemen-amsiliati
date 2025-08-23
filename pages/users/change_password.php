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
                        <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Ulangi Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password2">
                        </div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary btn-rounded"><i class="fa fa-save"></i> Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>