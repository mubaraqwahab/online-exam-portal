<?php
require_once '../connect.php';

$userID = $_POST['userID'];
$examID = $_POST['examID'];
$response = $_POST['response'];
$notiID = $_POST['notiID'];
$from = $_POST['from'];

$status = null;
$newNotType = null;

if ($response == 'accept') {
  $status = 3;      // Ready
  $newNotType = 2;  // Accepted
} else {
  $status = 2;      // Rejected
  $newNotType = 3;  // Declined
}

// Update exam status
$sql = "UPDATE exam_assignment SET status_id = {$status} WHERE exam_id = {$examID} AND assignee_id = '$userID'";
$conn->query($sql);

if ($conn->affected_rows != 1) {
  echo false;
  exit;
}


// Send notification to invite sender (about new assignment status)

sendNotification($userID, $to = $from, $examID, $newNotType);


// Delete notification
$sql = "DELETE FROM notification WHERE notification_id = {$notiID}";
$conn->query($sql);

if ($conn->affected_rows != 1) {
  echo false;
  exit;
}


echo true;
exit;

?>