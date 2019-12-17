<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "exam_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// LOOKUPS
$levels = $conn->query('SELECT * FROM level');
$courses = $conn->query('SELECT * FROM course');
$examTypes = $conn->query('SELECT * FROM exam_type');
$assignmentStatuses = $conn->query('SELECT * FROM assignment_status');


function addUser($userId, $firstName, $lastName, $email, $password, int $levelId = null, $profilePicture = null) {
  $sql = "INSERT INTO user(user_id, first_name, last_name, email, password, level_id, profile_picture)
  VALUES ('$userId','$firstName','$lastName','$email','$password',"
  . (is_null($levelId) ? "null" : $levelId) . ","
  . (is_null($profilePicture) ? "null" : '$profilePicture') . ")";

  global $conn;
  return $conn->query($sql);
}

function getUserById($userId) {
  $sql = "SELECT first_name, last_name, email, password, level_id, profile_picture FROM user WHERE user_id = '$userId'";

  global $conn;
  return $conn->query($sql);
}

function updateUser($userId, $firstName, $lastName, $email, $password, int $levelId = null, $profilePicture = null) {

}

function createExam($instructorId, $courseCode, $title, int $typeId, int $noOfQuestions) {
  $sql = "INSERT INTO exam(instructor_id, course_code, title, type_id, no_of_questions)
  VALUES ('$instructorId','$courseCode','$title',$typeId,$noOfQuestions)";
  global $conn;
  return $conn->query($sql);
}

function addMultiQuestion(int $examId, int $questionNo, $question, $correctAnswer, $a, $b, $c, $d, float $mark) {
  $sql = "INSERT INTO multi_choice_question(exam_id, question_no, question, correct_answer, a, b, c, d, mark)
  VALUES ($examId, $questionNo, '$question', '$correctAnswer', '$a', '$b', '$c', '$d', $mark)";

  global $conn;
  return $conn->query($sql);
}

function addFillQuestion(int $examId, int $questionNo, $question, float $mark) {
  $sql = "INSERT INTO fill_in_question(exam_id, question_no, question, mark) VALUES
  ($examId, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

function addTheoryQuestion(int $examId, int $questionNo, $question, float $mark) {
  $sql = "INSERT INTO theory_question(exam_id, question_no, question, mark) VALUES
  ($examId, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}
?>