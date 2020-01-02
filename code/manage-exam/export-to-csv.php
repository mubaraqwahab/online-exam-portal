<?php
include "../connect.php";

// Set the content-type to csv
// And tell it download (basically lol)
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=data.csv");

  // Fetch the file information and Check if the exam is graded
  $sql = "SELECT user.user_id, user.first_name, user.last_name, exam_assignment.total_score
  FROM user INNER JOIN exam_assignment ON user.user_id = exam_assignment.assignee_id
  WHERE exam_assignment.status_id = 6 AND exam_assignment.exam_id = {$_POST['examID']}";
  $result= mysqli_query($conn, $sql);

  // Create the output file (without saving it)
  $dataFile = fopen('php://output', 'w');

  if ($result->num_rows > 0) {

    // Output the header
    fputcsv($dataFile, array("ID", "FIRST NAME", "LAST NAME" ,"SCORE"));

    // Output the data
    while($row = $result->fetch_assoc()) {
      fputcsv($dataFile, $row);
    }
  } else {
    echo "0 results";
  }

?>