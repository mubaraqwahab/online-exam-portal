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
  $sql = "INSERT INTO user(user_id, first_name, last_name, email, password, level_id, profile_picture)
  VALUES ('$userID','$firstName','$lastName','$email','$password',"
  . (empty($levelId) ? "NULL" : $levelId) . ","
  . (empty($profilePicture) ? "NULL" : '$profilePicture') . ")";

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
  . (empty($password) ? "" : ", password = '$password'")
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

function fillIn(string $question, int $queNo, string $response = null) {
  $replace = '';

  if (is_null($response)) {
    $replace = '<input class="form-control col-3 col-sm-2" type="text" name="response' . $queNo . '">';
  } else {
    $replace = '<>';
  }

  return str_replace('___', $replace, $question);

}

echo '<div class="form-inline">';
echo fillIn("Your ___'s father is your grandfather", 3);
echo '</div>';


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>


  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Custom Script -->
</body>

</html>
