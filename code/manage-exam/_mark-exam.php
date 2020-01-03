<?php
include "../connect.php";

$examID = $_POST['examID'];
$assigneeID = $_POST['assigneeID'];

$sql = "SELECT type_id, no_of_questions FROM exam WHERE exam_id = $examID";

$result = mysqli_query($conn, $sql);


$exam = mysqli_fetch_assoc($result);
$typeID = $exam['type_id'];
$noOfQuestion = $exam['no_of_questions'];

$worked = TRUE;
$totalScore = 0;

for ($i=1; $i<=$noOfQuestion; $i++){
  $score = $_POST["score". $i];
  $totalScore += intval($score);
  if($typeID == 3){
    $sql2 = "UPDATE theory_response SET score = $score WHERE exam_id = $examID AND assignee_id = $assigneeID AND question_no = $i";
  }
  else if($typeID == 2){
    $sql2 = "UPDATE fill_in_response SET score = $score WHERE exam_id = $examID AND assignee_id = $assigneeID AND question_no = $i";
    }
  else{
    $worked = FALSE;
  }
  $result2 = mysqli_query($conn, $sql2);

}
if($worked){
  $sql3 = "UPDATE exam_assignment SET status_id = 6, total_score = $totalScore WHERE exam_id = $examID AND assignee_id = $assigneeID";
  $result = mysqli_query($conn, $sql3);
  header ("Location: feedback.php?feedback=success&examID=$examID");
}
else($worked){
  header ("Location: feedback.php?feedback=failure&examID=$examID")

}

?>