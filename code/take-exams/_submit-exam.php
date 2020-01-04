<?php

include '../connect.php';

if(isset($_POST['submit'])){
  $examID = $_POST['examID'];
  $userID = $_POST['userID'];


  $sql = "SELECT type_id, no_of_questions FROM exam WHERE exam_id = $examID";
  $result = mysqli_query($conn, $sql);
  $exam = mysqli_fetch_assoc($result);
  $typeID = $exam['type_id'];
  $noOfQuestions = $exam['no_of_questions'];

  if($typeID == 1){

    $outputTable = "multi_choice_response";
  }
  else if($typeID == 2){
    $outputTable = "fill_in_response";
  }
  else if($typeID == 3){
    $outputTable = "theory_response";
  }
  
  for($i=1; $i<=$noOfQuestions; $i++){
    $score = 'NULL';
    $response = $_POST['response' . $i];
    if($typeID == 1){
      $sql3 = "SELECT correct_answer, mark FROM multi_choice_question WHERE exam_id = $examID AND question_number = $i";
      $result3 = mysqli_query($conn, $sql3);
      $exam3 = mysqli_fetch_assoc($result3);
      $correctAnswer = $exam3['correct_answer'];

      if($response == $correctAnswer){
        $score = $exam3['mark'];
        

      }
      else{
        $score = 0;
      }
    }
    $sql2 = "INSERT INTO $outputTable (exam_id, question_no, assignee_id, response, score) VALUES ($examID, $i, '$userID', '$response', $score)";
    $result2 = mysqli_query($conn, $sql2);
  }
$sql4 = "UPDATE exam_assignment SET status_id = $newStatus WHERE exam_id = $examID AND assignee_id = $userID";
$result4 = mysqli_query($conn, $sql4);
$newStatus = $typeID == 1 ? 6 : 5;


}

if (mysqli_affected_rows($conn) != 0){
  header("Location: feedback.php?examID=$examID&feedback=success");
}
else{
  header("Location: feedback.php?examID=$examID&feedback=failure");
}

?>