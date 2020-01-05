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


// GLOBAL VARIABLES

// Root dir of project
const ROOT_DIR = '/online-exam-portal/code/';

// Folder to store profile pictures
const PROFILE_TARGET_DIR = '../profile-pic/';

// Length of random invite code prefix
const INVITE_CODE_PREFIX_LENGTH = 5;

// Notification types
const NOTI_INVITE = 1;      // for invite to take exam
const NOTI_ACCEPT = 2;      // for invite acceptance
const NOTI_DECLINE = 3;     // for invite decline
const NOTI_JOIN = 4;        // for join by invite code
const NOTI_START = 5;       // for start exam
const NOTI_COMPLETE = 6;    // for complete exam
const NOTI_GRADE = 7;       // for graded exam
const NOTI_CLOSE = 8;       // for closed exam

// Notification statuses
const NOTI_STATUS_UNVIEWED = 1;
const NOTI_STATUS_VIEWED = 2;

// Exam assignment statuses
const ASSIGNMENT_AWAIT = 1;
const ASSIGNMENT_DECLINED = 2;
const ASSIGNMENT_READY = 3;
const ASSIGNMENT_IN_PROGRESS = 4;
const ASSIGNMENT_TURNED_IN = 5;
const ASSIGNMENT_GRADED = 6;

// Exam statuses
const EXAM_OPEN = 1;
const EXAM_CLOSED = 2;



// FUNCTIONS


// Sanitize input (for strings only)
function sanitize(array $inputs) {
  global $conn;
  return array_map(array($conn, 'real_escape_string'), $inputs);
}


function encodeUrlParam($param) {
  return urlencode(base64_encode($param));
}

function decodeUrlParam($param) {
  return base64_decode(urldecode($param));
}


function getUserById($userID) {
  $sql = "SELECT * FROM user WHERE user_id = '$userID'";

  global $conn;
  return $conn->query($sql);
}

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
function prepareFillInQuestion(string $question, int $queNo = null, string $response = null) {
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

// Return true if a and b are equal, regardless of their cases
// Return false otherwise
function compareStrWithoutCase(string $a, string $b) {
  return strcasecmp($a, $b) == 0;
}

// Send notification

function sendNotification($senderID, $recipientID, $examID, $typeID) {
  $sql = "INSERT INTO `notification` (`recipient_id`, `type_id`, `sender_id`, `exam_id`) VALUES (?,?,?,?)";

  global $conn;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sisi', $recipientID, $typeID, $senderID, $examID);
  $stmt->execute();
  return $stmt->get_result();
}