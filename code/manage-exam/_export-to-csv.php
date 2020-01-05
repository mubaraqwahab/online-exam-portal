<?php
require_once '../connect.php';

// Set the content-type to csv
// And tell it download (basically lol)
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=data.csv");

  $examID = $_POST['examID'];

  // Fetch the file information and Check if the exam is graded
  $sql = "SELECT user.user_id, user.first_name, user.last_name, exam_assignment.total_score
  FROM user INNER JOIN exam_assignment ON user.user_id = exam_assignment.assignee_id
  WHERE exam_assignment.status_id = 6 AND exam_assignment.exam_id = $examID";
  $result= mysqli_query($conn, $sql);

  // Create the output file (without saving it)
  $dataFile = fopen('php://output', 'w');

  if ($result->num_rows > 0) {

    // Get the total possible mark
    $markResult = $conn->query("SELECT total_mark FROM exam WHERE exam_id = $examID");
    $totalMark = $markResult->fetch_assoc()['total_mark'];

    // Output the header
    fputcsv($dataFile, array("ID", "FIRST NAME", "LAST NAME" ,"SCORE (out of $totalMark)"));

    // Output the data
    while($row = $result->fetch_assoc()) {
      fputcsv($dataFile, $row);
    }
  } else {
    echo "0 results";
  }

?>