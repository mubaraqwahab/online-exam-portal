<?php
// You'll need this at the top to log the user in
session_start();

require_once '../connect.php';


// Add a user to the database
function addUser($userID, $firstName, $lastName, $email, $password, int $levelId = null, $profilePicture = null) {
  [$userID, $firstName, $lastName, $password] = sanitize([$userID, $firstName, $lastName, $password]);

  $password = md5($password);
  $sql = "INSERT INTO user(user_id, first_name, last_name, email, password, level_id, profile_picture)
  VALUES ('$userID','$firstName','$lastName','$email','$password',"
  . (empty($levelId) ? "NULL" : $levelId) . ","
  . (empty($profilePicture) ? "NULL" : "'$profilePicture'") . ")";

  global $conn;
  return $conn->query($sql);
}


// If the user is already signed in, redirect elsewhere
if (isset($_SESSION['userID'])) {

  if (isset($_GET['redirectTo'])) {
    header('Location: ' . decodeUrlParam($_GET['redirectTo']));
  } else {
    // Redirect to home page (no home page for now tho)
    header('Location: profile.php');
  }

}

// Otherwise sign him up

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


    // We can do some validation here

    addUser($userID, $firstName, $lastName, $email, $password, $level, $profilePicture);
    if ($conn->affected_rows == 1) {

      // Log the user in
      $_SESSION['userID'] = $userID;
      $_SESSION['profilePicture'] = $profilePicture;

      if (isset($_GET['redirectTo'])) {
        header('Location: ' . decodeUrlParam($_GET['redirectTo']));
      } else {
        // Redirect to home page (no home page for now tho)
        header('Location: profile.php');
      }

    } else {
      // Error message
      showError("Unable to register.");
    }
  } else {
    showError("Unable to register.");
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

    <title>Sign up</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-7 mx-auto my-5">
          <div class="card card-sign">
            <div class="card-body p-4 p-md-5">
              <h2 class="mb-5 text-center font-weight-light">Sign Up</h2>
              <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate>

                <div class="form-group row">
                  <label for="userID" class="col-sm-3 col-form-label">User ID<span class="text-danger">*</span></label>
                  <div class="col-sm-9" id="userIDGroup">
                    <input type="text" class="form-control" id="userID" name="userID" minlength="4" maxlength="16" pattern="[0-9a-zA-Z]+" aria-describedby="userIDHelp" required>
                    <div class="invalid-feedback" id="userIDFeedback"></div>
                    <small id="userIDHelp" class="form-text text-muted">
                      Use your student ID if you're a student. User ID should be 4 to 16 characters. Only numbers and letters are valid.
                    </small>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="firstName" class="col-sm-3 col-form-label">First name<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="firstName" name="firstName" maxlength="45" pattern="[a-zA-Z]+" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastName" class="col-sm-3 col-form-label">Last name<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastName" name="lastName" maxlength="45" pattern="[a-zA-Z]+" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" maxlength="45" required>
                    <div class="invalid-feedback" id="emailFeedback"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label">Password<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" minlength="8" maxlength="45" required>
                    <small id="passwordHelp" class="form-text text-muted">
                      Password should be 8 to 45 characters.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm password<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" minlength="8" maxlength="45" required>
                  </div>
                </div>

                <hr class="my-4">

                <div class="form-group row">
                  <label for="level" class="col-sm-3 col-form-label">Level</label>
                  <div class="col-sm-9">
                    <select class="custom-select" name="level" aria-describedby="levelHelp">
                      <option selected></option>
                      <?php
                      while ($level = $levels->fetch_assoc()) {
                        echo '<option value="'. $level['level_id'] .'">'.$level['value'].'</option>';
                      }
                      ?>
                    </select>
                    <small id="levelHelp" class="form-text text-muted">
                      Ignore this if you're not a student.
                    </small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="profilePicture" class="col-sm-3 col-form-label">Profile picture</label>
                  <div class="col-sm-9">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="profilePicture" name="profilePicture" accept="image/jpeg,image/png">
                      <label class="custom-file-label d-inline-block text-truncate m-0">No picture chosen</label>
                      <div class="invalid-feedback" id="profilePictureFeedback"></div>
                      <small id="profilePictureHelp" class="form-text text-muted">
                        Picture size should not exceed 2MB. A square picture is preferred.
                      </small>
                    </div>
                  </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block mt-4" id="signUp" name="signUp" type="submit">Sign up</button>
                <a class="d-block text-center mt-2 small" href="sign-in.php">Log in</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script src="../js/show-file-input.js"></script>

    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>

    <script src="../js/validate-signup.js"></script>
  </body>
</html>