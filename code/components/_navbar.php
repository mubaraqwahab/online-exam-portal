<nav class="navbar navbar-light sticky-top bg-light border-bottom">
  <div class="d-flex align-items-center">
    <button class="btn btn-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
    <h4 class="ml-3 mb-0" id="page-title">Page Title</h4>
  </div>

  <div class="dropdown">
    <button class="btn" id="profileDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="d-none d-md-inline-block mr-1"><?php echo isset($userId) ? $userId : "User ID"; ?></span>
      <img src="<?php
        echo PROFILE_TARGET_DIR . (empty($profilePicture) || !file_exists(PROFILE_TARGET_DIR . $profilePicture) ? 'blank-square.jpg' : $profilePicture); ?>"
        class="rounded-circle" height="30px" width="30px">
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
      <div class="dropdown-item d-md-none"><?php echo isset($userId) ? $userId : "User ID"; ?></div>
      <div class="dropdown-divider d-md-none"></div>
      <a class="dropdown-item" href="/online-exam-portal/code/sign/profile.php">Edit Profile</a>
      <div class="dropdown-divider"></div>
      <form method="post" class="m-0">
        <button name="signOut" type="submit" class="dropdown-item">Sign Out</button>
      </form>
    </div>
  </div>
</nav>