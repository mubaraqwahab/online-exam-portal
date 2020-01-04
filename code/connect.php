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


// Add a user to the database
function addUser($userID, $firstName, $lastName, $email, $password, int $levelId = null, $profilePicture = null) {
  $password = md5($password);
  $sql = "INSERT INTO user(user_id, first_name, last_name, email, password, level_id, profile_picture)
  VALUES ('$userID','$firstName','$lastName','$email','$password',"
  . (empty($levelId) ? "NULL" : $levelId) . ","
  . (empty($profilePicture) ? "NULL" : "'$profilePicture'") . ")";

  global $conn;
  return $conn->query($sql);
}

//
function getUserById($userID) {
  $sql = "SELECT * FROM user WHERE user_id = '$userID'";

  global $conn;
  return $conn->query($sql);
}

function getUserByEmail($email) {
  $sql = "SELECT * FROM user WHERE email = '$email'";

  global $conn;
  return $conn->query($sql);
}

// Update details of a user. User ID and Level can't be updated
function updateUser($userID, $firstName, $lastName, $email, $password = null, $profilePicture = null) {
  $sql = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', email = '$email'"
  . (empty($password) ? "" : ", password = '". md5($password) . "'")
  . (empty($profilePicture) ? "" : ", profile_picture = '$profilePicture'") . " WHERE user_id = '$userID'";

  global $conn;
  return $conn->query($sql);
}

// Create an exam
function createExam($instructorId, $courseCode, $title, int $typeId, int $noOfQuestions, $invitePrefix) {
  $sql = "INSERT INTO exam(instructor_id, course_code, title, type_id, no_of_questions, invite_prefix)
  VALUES ('$instructorId','$courseCode','$title',$typeId,$noOfQuestions,'$invitePrefix')";
  global $conn;
  return $conn->query($sql);
}

// Add a multichoice question
function addMultiQuestion(int $examID, int $questionNo, $question, $correctAnswer, $a, $b, $c, $d, float $mark) {
  $sql = "INSERT INTO multi_choice_question(exam_id, question_no, question, correct_answer, a, b, c, d, mark)
  VALUES ($examID, $questionNo, '$question', '$correctAnswer', '$a', '$b', '$c', '$d', $mark)";

  global $conn;
  return $conn->query($sql);
}

// Add a fill in the blank question
function addFillQuestion(int $examID, int $questionNo, $question, float $mark) {
  $sql = "INSERT INTO fill_in_question(exam_id, question_no, question, mark)
  VALUES ($examID, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

// Add a theory question
function addTheoryQuestion(int $examID, int $questionNo, $question, float $mark) {
  $sql = "INSERT INTO theory_question(exam_id, question_no, question, mark)
  VALUES ($examID, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

// Assign an exam to a student
function assignStudentExam(int $examID, $userID) {
  $sql = "INSERT INTO exam_assignment(exam_id, assignee_id, total_score, status_id)
  VALUES ($examID,'$userID',NULL,1)";

  global $conn;
  return $conn->query($sql);
}

// Get all exams owned by an instructor
function getInstructorExams($instructorId) {
  $sql = "SELECT exam_id, instructor_id, course_code, title, type_id, no_of_questions FROM exam WHERE instructor_id = '$instructorId'";

  global $conn;
  return $conn->query($sql);
}

// Length of random invite code prefix
const INVITE_CODE_PREFIX_LENGTH = 5;

// Generate a random string of length $length.
// $isNum specifies whether the string should be numeric.
function generateRandomString($length, $isNum = false) {
  $characters = '0123456789' . ($isNum ? '' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}


// Folder to store profile pictures
const PROFILE_TARGET_DIR = '../profile-pic/';

// Rename an uploaded profile picture to a unique hash.
function renameProfilePic($userID) {
  // TODO in frontend:
  // Check if image file is an actual image or fake image
  // Check file size <= 2MB
  // Allow certain file formats (jpg, jpeg, png, bmp)

  $profilePicture = '';

  if (is_uploaded_file($_FILES["profilePicture"]["tmp_name"])) {
    $targetFile = PROFILE_TARGET_DIR . basename($_FILES["profilePicture"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Rename
    // $profilePicture = $userID . '.' . $imageFileType; //base64_decode(urldecode($userID)) . $imageFileType;
    $profilePicture = md5($userID.$imageFileType) . '.' . $imageFileType;
  }

  return $profilePicture;
}

// Save uploaded profile picture as name given in argument $profilePicture
function saveProfilePic($profilePicture) {
  if (empty($profilePicture)) return false;

  $targetFile = PROFILE_TARGET_DIR . $profilePicture;

  if(file_exists($targetFile)) {
    // Change the file permissions if allowed
    chmod($targetFile, 0755);
    // Remove the file
    unlink($targetFile);
  }

  return move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile);
}

// Crop a picture in the middle to a square (the square is as big as possible)
function squareCropPicture($picturePath) {
  $im = imagecreatefromjpeg($picturePath);

  $crop_width = imagesx($im);
  $crop_height = imagesy($im);

  $size = min($crop_width, $crop_height);

  $imd = abs($crop_width-$crop_height) / 2;

  // Crop image
  $im2 = imagecrop($im,
    ['x' => ($crop_width >= $crop_height) ? $imd : 0,
    'y' => ($crop_width < $crop_height) ? $imd : 0,
    'width' => $size,
    'height' => $size]
  );

  // Replace image
  if ($im2 !== FALSE) {
    imagejpeg($im2, $picturePath);
    imagedestroy($im2);
  }
  imagedestroy($im);
}

function getMIMEType($filePath) {
  $finfo = new finfo(FILEINFO_MIME_TYPE, null);
  return $finfo->file($filePath);
}

function showError($errMsg) {
  echo '<div class="alert alert-danger text-center" role="alert">';
  echo '<strong>Error!</strong>&nbsp;';
  echo $errMsg;
  echo '</div>';
}


// prepare a fill in question for display
// $question is the raw question from the db
// $queNo is the question no (nullable)
// $response is the user's response to the question (nullable)
function prepareFillInQuestion(string $question, int $queNo, string $response = null) {
  $replace = '';

  if (is_null($response)) {
    $replace = '<input class="form-control" type="text" name="response' . $queNo . '">';
  } else {
    $replace = '<span class="px-1"><u>' . $response . '</u></span>';
  }

  return replaceFirstOccurence('___', $replace, $question);

}

// replace the first occurence of $search in $subject with $replace
// and return the result
// if $search doesn't exist in $subject, return $subject unchanged
function replaceFirstOccurence(string $search, string $replace, string $subject) {
  $result = $subject;

  $pos = strpos($subject, $search);
  if ($pos !== false) {
    $result = substr_replace($subject, $replace, $pos, strlen($search));
  }

  return $result;
}

// pluralSuffix(1) returns ''
// pluralSuffix(any other number) returns 's'
function pluralSuffix($count) {
  return $count == 1 ? '' : 's';
}