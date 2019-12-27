<?php
// You'll need this at the top to log the user in
session_start();

include '../connect.php';

if (isset($_POST['signUp'])) {
  $userID = $_POST['userID'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  // Get profile picture name
  $profilePicture = renameProfilePic($userID);
  if (!empty($profilePicture)) {
    // Save picture
    saveProfilePic($profilePicture);
    // Crop picture
    squareCropPicture(PROFILE_TARGET_DIR . $profilePicture);
  }

  // We can do some validation here

  addUser($userID, $firstName, $lastName, $email, $password, $level);

  // Log the user in
  $_SESSION['userID'] = $userID;
  $_SESSION['profilePicture'] = $profilePicture;

  // Redirect to home page (no home page for now tho)
  header('Location: ../create-exam/');
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

    <title>Sign up</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-7 mx-auto my-5">
          <div class="card card-sign">
            <div class="card-body p-4 p-md-5">
              <h2 class="mb-5 text-center font-weight-light">Sign Up</h2>
              <form method="post">
                <div class="form-group row">
                  <label for="userID" class="col-sm-3 col-form-label">User ID<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="userID" name="userID" aria-describedby="userIDHelp" required autofocus>
                    <small id="userIDHelp" class="form-text text-muted">
                      Use your student ID if you're a student. User ID should be 8 to 16 characters. Only numbers and letters are valid.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="firstName" class="col-sm-3 col-form-label">First name<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastName" class="col-sm-3 col-form-label">Last name<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Password<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required>
                    <small id="passwordHelp" class="form-text text-muted">
                      Password should be 8 to 45 characters.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm password<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                  </div>
                </div>

                <hr class="my-4">

                <div class="form-group row">
                  <label for="level" class="col-sm-3 col-form-label">Level</label>
                  <div class="col-sm-9">
                    <select class="custom-select" name="level" aria-describedby="levelHelp">
                      <option selected></option>
                      <option value="1">100</option>
                      <option value="2">200</option>
                      <option value="3">300</option>
                      <option value="4">400</option>
                      <option value="5">500</option>
                    </select>
                    <small id="levelHelp" class="form-text text-muted">
                      Ignore this if you're not a student.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="profilePicture" class="col-sm-3 col-form-label">Profile picture</label>
                  <div class="col-sm-9">
                    <img src="../img/blank-square.jpg"
                      class="rounded-circle w-50 mb-2 d-block" alt="Profile picture">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="profilePicture">
                      <label class="custom-file-label m-0">No file chosen</label>
                    </div>
                  </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block mt-4" name="signUp" type="submit">Sign up</button>
                <a class="d-block text-center mt-2 small" href="sign-in.html">Sign in</a>
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