<header class="mt-n3">
  <a href="#" class="burger-btn d-block d-xl-none">
    <i class="bi bi-justify fs-3"></i>
  </a>
</header>

<div class="page-heading d-flex justify-content-between align-items-center">
  <h3><?php // $subtitle ?></h3>
  <ul class="navbar-nav navbar-nav-right" style="margin-top: -10px;">
    <li class="nav-item dropdown">
      <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
        <div class="navbar-profile d-flex justify-content-center align-items-center">
          <p class="mb-0 d-none d-sm-block"><?= $_SESSION['nama'] == '' ? 'Ustadzah' : ucfirst($_SESSION['nama']) . " (".get_role($_SESSION['role']).")" ?></p>
          <i class="bi bi-caret-down-fill" style="margin: -8px 0px 0px 5px;"></i>
        </div>
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="users&action=setting&id=<?= $_SESSION['user_id'] ?>">Account Setting</a></li>
        <li><a class="dropdown-item" href="users&action=change_password&id=<?= $_SESSION['user_id'] ?>">Change Password</a></li>
        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      </ul>
    </li>
  </ul>
</div>