<?php
// Set the content-type to csv
// And tell it download
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=data.csv");
if(isset($_POST['exportToCsv'])){
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
}
?>


<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
      <form method="POST" action="export-to-csv.php">
        <input type="hidden" name="examID" value="30">
        <button type="submit" name="submit">Click to create file</button><br><br>
        <!-- <button><a href="data.csv">Download after creating</a></button> -->
      </form>
        <script>$(document).ready(function(){
            $("p").click(function(){
              $(this).hide();
            });
          });
        </script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    </body>
    </html>