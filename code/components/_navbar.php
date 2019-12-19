<nav class="navbar navbar-light sticky-top bg-light border-bottom">
  <div class="d-flex align-items-center">
    <button class="btn btn-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
    <h4 class="ml-3 mb-0" id="page-title">Page Title</h4>
  </div>

  <div class="dropdown">
    <button class="btn" id="profileDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="d-none d-md-inline-block mr-1"><?php echo isset($userId) ? $userId : "User ID"; ?></span>
      <img src="<?php echo "../profile-pic.php?id=".$userId; ?>" class="rounded-circle" height="30px" width="30px"
      onerror="this.onerror=null; this.src='../img/avatar2.png'">
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
      <a class="dropdown-item" href="#">View Profile</a>
      <a class="dropdown-item" href="#">Edit Profile</a>
      <div class="dropdown-divider"></div>
      <form method="post"><button name="signOut" class="dropdown-item">Sign Out</button></form>
    </div>
  </div>
</nav>