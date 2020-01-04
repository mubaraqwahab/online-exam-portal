<?php

include '../connect.php';


// if submit button has been set
// Get examID, userID from post
// Check db for exam type

// If exam is theory, set output table to theory_response
// If exam is fill-in, set output table to fill_in_response
// If exam is obj, set output table to multi_response

// for each question:
  // If exam is obj,
    // Grade response

  // Send response to output table
  // Details: exam id, question no, assignee id, response

if (!isset($_POST['submit'])) exit;

$examID = $_POST['examID'];
$userID = $_POST['userID'];

// Get exam details, if it isn't closed and the student is a valid assignee
$sql = "SELECT e.* FROM exam e WHERE e.exam_id = ? AND e.status_id = 1
  AND EXISTS (SELECT 1 FROM exam_assignment a
    WHERE a.exam_id = ? AND a.assignee_id = ? AND a.status_id = 4)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iis', $examID, $examID, $userID);
$stmt->execute();
$result = $stmt->get_result();

$feedback = 'failure';
if ($result->num_rows == 1) {
  $exam = $result->fetch_assoc();

  // Set the output table and new status
  $outTable = null;
  $newStatus = 5;  // Turned in
  if ($exam['type_id'] == 1) {
    $outTable = 'multi_choice_response';
    $newStatus = 6; // Graded (for obj)

    // Get and correct answers & marks for all questions
    $sql = "SELECT correct_answer, mark FROM multi_choice_question WHERE exam_id = ? ORDER BY question_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $examID);
    $stmt->execute();
    $multiRes = $stmt->get_result();
  }
  else if ($exam['type_id'] == 2) $outTable = 'fill_in_response';
  else $outTable = 'theory_response';

  // Write to db:

  // Prepare sqls
  $sql = "INSERT INTO $outTable (exam_id, question_no, assignee_id, response, score) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iissd', $examID, $i, $userID, $response, $score);

  for ($i = 1; $i <= $exam['no_of_questions']; $i++) {
    $response = $_POST['response'.$i];
    $score = null;

    // For obj, score the response
    if ($exam['type_id'] == 1) {
      $multiQues = $multiRes->fetch_assoc();

      if (strcasecmp($response, $multiQues['correct_answer']) == 0) {
        $score = $multiQues['mark'];
      } else if (strcasecmp($response, $multiQues['correct_answer']) != 0) {
        $score = 0;
      }
    }

    // Execute sql
    $stmt->execute();

    if ($conn->affected_rows == 1) {
      $feedback = 'success';
    } else {
      $feedback = 'failure';
    }
  }


  if ($feedback == 'success') {
    $sql = "UPDATE exam_assignment SET status_id = ? WHERE assignee_id = ? AND exam_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isi', $newStatus, $userID, $examID);
    $stmt->execute();
  }

}




header("Location: feedback.php?examID=$examID&feedback=$feedback");

?>