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
  . (empty($levelId) ? "NULL" : $levelId) . ","
  . (empty($profilePicture) ? "NULL" : '$profilePicture') . ")";

  global $conn;
  return $conn->query($sql);
}

function getUserById($userId) {
  $sql = "SELECT first_name, last_name, email, password, level_id, profile_picture FROM user WHERE user_id = '$userId'";

  global $conn;
  return $conn->query($sql);
}

function getUserByEmail($email) {
  $sql = "SELECT user_id, first_name, last_name, password, level_id, profile_picture FROM user WHERE email = '$email'";

  global $conn;
  return $conn->query($sql);
}

function updateUser($userId, $firstName, $lastName, $email, $password = null, $profilePicture = null) {
  $sql = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', email = '$email'"
  . (empty($password) ? "" : ", password = '$password'")
  . (empty($profilePicture) ? "" : ", profile_picture = '$profilePicture'") . " WHERE user_id = '$userId'";

  global $conn;
  return $conn->query($sql);
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
  $sql = "INSERT INTO fill_in_question(exam_id, question_no, question, mark)
  VALUES ($examId, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

function addTheoryQuestion(int $examId, int $questionNo, $question, float $mark) {
  $sql = "INSERT INTO theory_question(exam_id, question_no, question, mark)
  VALUES ($examId, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

function assignStudentExam(int $examId, $userId) {
  $sql = "INSERT INTO exam_assignment(exam_id, assignee_id, total_score, status_id)
  VALUES ($examId,'$userId',NULL,1)";

  global $conn;
  return $conn->query($sql);
}

function getInstructorExams($instructorId) {
  $sql = "SELECT exam_id, instructor_id, course_code, title, type_id, no_of_questions FROM exam WHERE instructor_id = '$instructorId'";

  global $conn;
  return $conn->query($sql);
}



function generateRandomString($length, $isNum = false) {
  $characters = '0123456789' . ($isNum ? '' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function generateRandomToken($length = 6) {
  $characters = '01234567892819403817293';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

const PROFILE_TARGET_DIR = '../profile-pic/';

function renameProfilePic($userId) {
  // TODO in frontend:
  // Check if image file is an actual image or fake image
  // Check file size <= 2MB
  // Allow certain file formats (jpg, jpeg, png, gif, bmp)

  if (is_uploaded_file($_FILES["profilePicture"]["tmp_name"])) {
    $target_file = PROFILE_TARGET_DIR . basename($_FILES["profilePicture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Rename
    $profilePicture = $userId . '.' . $imageFileType; //base64_decode(urldecode($userId)) . $imageFileType;
  }

  return isset($profilePicture) ? $profilePicture : '';
}

function saveProfilePic($profilePicture) {
  if (empty($profilePicture)) return false;

  $targetFile = PROFILE_TARGET_DIR . $profilePicture;
  return move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile);
}
?>