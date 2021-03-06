<?php
// You'll need this at the top to log the user in
session_start();

require_once '../connect.php';


// If the user is already signed in, redirect elsewhere
if (isset($_SESSION['userID'])) {

  if (isset($_GET['redirectTo'])) {
    header('Location: ' . decodeUrlParam($_GET['redirectTo']));
  } else {
    // Redirect to home page (no home page for now tho)
    header('Location: ../notifications/');
  }

}

// Otherwise sign him in

if (isset($_POST['signIn'])) {
  $userID = $_POST['userID'];
  $password = $_POST['password'];

  // $sql = "SELECT user_id, password FROM user WHERE user_id = '" . $userID . "' AND  password = '" . $password . "'";
  [$userID, $password] = sanitize([$userID, $password]);
  $sql = "SELECT profile_picture FROM user WHERE user_id = '" . $userID . "' AND  password = '" . md5($password) . "'";

  $checkdetails = $conn->query($sql);

  if ($checkdetails->num_rows > 0) {
    // Get the profile pic
    $profilePicture  = $checkdetails->fetch_assoc()['profile_picture'];

    // Log the user in
    $_SESSION['userID'] = $userID;
    $_SESSION['profilePicture'] = $profilePicture;

    if (isset($_GET['redirectTo'])) {
      header('Location: ' . decodeUrlParam($_GET['redirectTo']));
    } else {
      // Redirect to home page (no home page for now tho)
      header('Location: ../notifications/');
    }
  } else {
    showError('The username or password are incorrect!');
  }

}

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link rel="stylesheet" href="../css/sign.css">

  <title>Log in</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-8 col-lg-6 mx-auto my-5">
        <div class="card card-sign">
          <div class="card-body p-4 p-md-5">
            <h2 class="mb-5 text-center font-weight-light">Log In</h2>
            <form method="post">
              <div class="form-group row">
                <label for="userID" class="col-sm-3 col-form-label">User ID</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="userID" name="userID" required autofocus>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
              </div>

              <button class="btn btn-lg btn-primary btn-block mt-4" name="signIn" type="submit">Log in</button>
              <div class="text-center">
                <a class="d-inline-block text-center mt-2 small"
                href="sign-up.php<?php echo isset($_GET['redirectTo']) ? "?redirectTo={$_GET['redirectTo']}" : '' ?>">
                  Sign up
                </a> &middot;
                <a class="d-inline-block text-center mt-2 small" href="recover.php">Forgot password?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

  <script>
    $(document).ready(function() {
      bsCustomFileInput.init()
    })
  </script>
</body>

</html>