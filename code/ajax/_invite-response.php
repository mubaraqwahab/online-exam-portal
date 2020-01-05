<?php
include '../connect.php';

$userID = $_POST['userID'];
$examID = $_POST['examID'];
$response = $_POST['response'];
$notiID = $_POST['notiID'];

$status = null;

if ($response == 'accept') {
  $status = 3;      // Ready
} else {
  $status = 2;      // Rejected
}

// Update exam status
$sql = "UPDATE exam_assignment SET status_id = $status WHERE exam_id = $examID AND assignee_id = '$userID'";
$conn->query($sql);

// Update notification status to vi
$notiSql = "UPDATE notification SET status_id = 2 WHERE notification_id = $notiID";
$conn->query($notiSql);


if ($conn->affected_rows == 1) {
  echo true;
} else {
  echo false;
}

exit;

?>