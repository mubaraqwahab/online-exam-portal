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
  $status = ASSIGNMENT_READY;       // Ready
  $newNotType = NOTI_ACCEPT;        // Accepted
} else {
  $status = ASSIGNMENT_DECLINED;    // Rejected
  $newNotType = NOTI_DECLINE;       // Declined
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