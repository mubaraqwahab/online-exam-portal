<?php

require_once '../connect.php';

$res = null;

if (isset($_POST['userID']) && isset($_POST['inviteCode'])) {
  $userID = $_POST['userID'];
  $inviteCode = $_POST['inviteCode'];

  $invitePrefix = substr($inviteCode, 0, INVITE_CODE_PREFIX_LENGTH);
  $examID = substr($inviteCode, INVITE_CODE_PREFIX_LENGTH);

  // New assignment if the exam exists and is open
  $sql = "INSERT INTO exam_assignment (exam_id, assignee_id, status_id)
    SELECT exam.exam_id, '$userID', 3 FROM exam
    WHERE exam.exam_id = $examID AND exam.invite_prefix = '$invitePrefix' AND exam.status_id = 1";

  if ($conn->query($sql) && $conn->affected_rows == 1) {
    $res = true;
  } else {
    $res = false;
  }
}

echo $res;

?>