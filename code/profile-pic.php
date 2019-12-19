<?php

  include 'connect.php';

  $id = base64_decode(urldecode($_GET['id']));
  // do some validation here to ensure id is safe

  $sql = "SELECT profile_picture FROM user WHERE user_id='$id'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  header("Content-type: image/jpeg");
  echo $row['profile_picture'];
?>