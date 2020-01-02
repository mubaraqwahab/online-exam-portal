<?php

// Include this file at the top of any main page (i.e. excluding the 'sign' pages)

session_start();

const ROOT_DIR = '/online-exam-portal/code/';

// Go to Sign In if not signed in
// Send redirect link as well
if (!isset($_SESSION['userID'])) {
  $currentFile = basename(dirname($_SERVER["SCRIPT_FILENAME"])) . '/' . basename($_SERVER["SCRIPT_FILENAME"]);
  header("Location: " . ROOT_DIR . "account/sign-in.php?redirectTo=" . urlencode(base64_encode(ROOT_DIR . $currentFile)));
}

// Sign out
if (isset($_POST['signOut'])) {
  session_destroy();

  header("Location: " . ROOT_DIR . "account/sign-in.php");
}

?>