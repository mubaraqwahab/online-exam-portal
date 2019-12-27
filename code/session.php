<?php

// Include this file at the top of any main page (i.e. excluding the 'sign' pages)

session_start();

// Go to Sign In if not signed in
if (!isset($_SESSION['userID'])) {
  header("Location: /online-exam-portal/code/sign/sign-in.php");
}

// Sign out
if (isset($_POST['signOut'])) {
  session_destroy();

  header('Location: /online-exam-portal/code/sign/sign-in.php');
}

?>