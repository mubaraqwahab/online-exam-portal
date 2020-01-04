<?php
require_once '../connect.php';


function getUserByEmail($email) {
  $sql = "SELECT * FROM user WHERE email = '$email'";

  global $conn;
  return $conn->query($sql);
}


header('Content-Type: application/json');

$result = null;

if (isset($_POST['userID'])) {
  $result = getUserById($_POST['userID']);
} else if (isset($_POST['email'])) {
  $result = getUserByEmail($_POST['email']);
}

$fieldCount = is_null($result) ?: $result->num_rows;

$jsonArr = array( 'isAvailable' => ($fieldCount === 0) );
echo json_encode($jsonArr);
exit;


?>