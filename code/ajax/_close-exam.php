<?php
require_once '../connect.php';
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

$worked = mysqli_affected_rows($conn) == 1;

// Also, send notification to assignees that the exam has been closed

// Get instructor id
// $exam = $conn->query("SELECT instructor_id FROM exam WHERE exam_id = $examID");
// if ($exam->num_rows != 1) {
//   $worked = false;
// } else {
//   $instructorID = ($exam->fetch_assoc())['instructor_id'];

//   // Get all assignees
//   $assignSql = "SELECT assignee_id FROM exam_assignment WHERE exam_id = $examID";
//   $assignees = $conn->query($assignSql);

//   if ($assignees->num_rows > 0) {
//     while ($assignee = ($assignees->fetch_assoc())['assignee_id']) {
//       // Send notification to each of them that exam has been closed
//       sendNotification($instructorID, $assignee, $examID, $t = NOTI_CLOSE);
//     }
//   }
// }



echo $worked;
exit;

  // closing connection
// mysqli_close($conn);
?>