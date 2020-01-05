<?php
include '../connect.php';
// include 'connect.php';
// $servername = "localhost";
// $username = "root";
// $password = "";
// $db_name = "exam_portal";
// TODO:
// Set the status id to 2 (2 means closed)
// Get the examID. The exam ID would be sent to this file through post
//  So you can do $examID = $_POST['examID'] to get it.
// The WHERE clause in the sql query should be where the exam id = $examID
// And that's all :-)
$examID=$_POST['examID'];
$sql="UPDATE `exam` SET `status_id` = 2 WHERE `exam`.`exam_id` =$examID";
mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn) == 1) {
echo true;
}
else {
  echo false;
}
// Note tho: We can write lines 13 to 18 as below:
// echo mysqli_affected_rows($conn) == 1;
  // closing connection
// mysqli_close($conn);
?>