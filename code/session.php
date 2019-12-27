<?php

// Include this file at the top of any main page (i.e. excluding the 'sign' pages)

session_start();

const ROOT_DIR = '/online-exam-portal/code/';

// Go to Sign In if not signed in
if (!isset($_SESSION['userID'])) {
  header("Location: " . ROOT_DIR . "account/sign-in.php");
}

// Sign out
if (isset($_POST['signOut'])) {
  session_destroy();

  header("Location: " . ROOT_DIR . "account/sign-in.php");
}

?>