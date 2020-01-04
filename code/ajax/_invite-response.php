<?php
include '../connect.php';

$userID = $_POST['userID'];
$examID = 32;
$response = $_POST['response'];

$status = null;

if ($response === 'accept') {
  $status = 3;
} else {
  $status = 2;
}

$sql = 'UPDATE exam_assignment SET status_id = '.$status.' WHERE exam_id = '.$examID.' AND assignee_id = '.$userID;
$conn->query($sql);

if ($conn->affected_rows == 1) {
  echo true;
} else {
  echo false;
}

exit;

?>