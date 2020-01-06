<?php
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

// Otherwise ...

$email = decodeUrlParam($_GET['email']);

if(isset($_POST['submitt'])){

  $newpassword = md5($_POST['password']);
  $token = $_POST['token'];

  $sql = "SELECT `recovery_key` FROM user WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

if($token == $row['recovery_key']){
  $sql = "UPDATE user SET password='$newpassword' WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  }

  header("Location: sign-in.php");
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

    <title>Reset Password</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-6 mx-auto my-5">
          <div class="card card-sign">
            <div class="card-body p-4 p-md-5">
              <h2 class="mb-5 text-center font-weight-light">Reset Password</h2>
              <form method="POST">

              <div class="form-group row">
                  <label for="token" class="col-sm-3 col-form-label">Enter token</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="token" name="token" aria-describedby="tokenHelp" required autofocus>
                    <small id="tokenHelp" class="form-text text-muted">
                      Enter the 6-digit token that was sent to your email address.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">New password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required autofocus>
                    <small id="passwordHelp" class="form-text text-muted">
                      Enter a new password. It should not exceed 45 characters.
                    </small>
                  </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block mt-4" name="submitt" type="submit">Reset password</button>
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
      $(document).ready(function () {
        bsCustomFileInput.init()
      })
    </script>
  </body>
</html>