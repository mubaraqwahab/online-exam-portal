<?php

// Get no of new notifications
$sql = "SELECT notification_id FROM notification WHERE recipient_id = $userID AND status_id = 1";
$notiCount = ($conn->query($sql))->num_rows;

?>

<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sticky-top pt-2">
    <h5 class="sidebar-heading">Dashboard</h5>
    <div class="list-group list-group-flush">
      <a href="<?php echo ROOT_DIR . 'notifications/' ?>" class="list-group-item list-group-item-action bg-light" id="notifications">
        Notifications
        <?php echo $notiCount == 0 ? "" : " <span class='badge badge-info'>$notiCount</span>"; ?>
      </a>

      <span class="list-group-item bg-light mt-3"><b>For Instructors</b></span>
      <a href="<?php echo ROOT_DIR . 'create-exam/' ?>" class="list-group-item list-group-item-action bg-light" id="create-exam">Create Exam</a>
      <a href="<?php echo ROOT_DIR . 'manage-exam/' ?>" class="list-group-item list-group-item-action bg-light" id="manage-exams">Manage Exams</a>

      <span class="list-group-item bg-light mt-3"><b>For Students</b></span>
      <a href="<?php echo ROOT_DIR . 'take-exams/' ?>" class="list-group-item list-group-item-action bg-light" id="take-exams">Take Exams</a>
      <a href="<?php echo ROOT_DIR . 'submissions/' ?>" class="list-group-item list-group-item-action bg-light" id="submissions">Submissions</a>
    </div>
  </div>
</div>