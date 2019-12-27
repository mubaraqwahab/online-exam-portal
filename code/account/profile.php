<?php
include '../session.php';

include '../connect.php';

$userID = $_SESSION['userID'];
$profilePicture = $_SESSION['profilePicture'];

$result = getUserById($userID);
$record = $result->fetch_assoc();

$firstName = $record['first_name'];
$lastName = $record['last_name'];
$email = $record['email'];
$level = 300;

if (isset($_POST['update'])) {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Get profile picture name
  $newPic = renameProfilePic($userID);
  if (!empty($newPic)) {
    $profilePicture = $newPic;
    $_SESSION['profilePicture'] = $profilePicture;
    // Save picture
    saveProfilePic($profilePicture);
    // Crop picture
    squareCropPicture(PROFILE_TARGET_DIR . $profilePicture);
  }

  updateUser($userID, $firstName, $lastName, $email, $password, $profilePicture);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Profile</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="../css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

  <?php include '../components/_header.php' ?>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php require '../components/_sidebar.php' ?>

    <!-- Page content wrapper -->
    <div id="page-content-wrapper">

      <!-- Navbar -->
      <?php require '../components/_navbar.php' ?>

      <!-- Page content -->
      <div class="container py-3 px-5">

        <form method="post" class="mt-4" enctype="multipart/form-data">
          <div class="form-group">
            <label for="profilePicture">Profile picture</label>
            <img src="<?php
                echo PROFILE_TARGET_DIR . (empty($profilePicture) || !file_exists(PROFILE_TARGET_DIR . $profilePicture) ? 'blank-square.jpg' : $profilePicture);
                ?>"
              class="rounded-circle img-responsive col-sm-4 col-md-3 mb-2 d-block"
              alt="Profile picture">
            <div class="custom-file col-sm-5">
              <input type="file" class="custom-file-input" name="profilePicture" id="profilePicture" aria-describedby="profilePictureHelp">
              <label class="custom-file-label m-0">No file chosen</label>
            </div>
            <small id="profilePictureHelp" class="form-text text-muted">
              Only JPG, JPEG, PNG & GIF files are allowed.
              Your image size should not exceed 2MB.
              Your image would be square cropped.
            </small>
          </div>

          <div class="form-group">
            <strong class="form-text">
              <span class="">User ID:&nbsp;</span>
              <span><?php echo $userID; ?></span>
            </strong>
            <?php if (isset($level)) {
              echo
              '<strong class="form-text">
                <span class="">Level:&nbsp;</span>
                <span>' . $level . '</span>
              </strong>';
            }
            ?>
          </div>

          <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $firstName; ?>" required>
          </div>

          <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $lastName; ?>" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" required>
          </div>

          <div class="form-group">
            <label for="password">New password</label>
            <input type="password" class="form-control" name="password" id="password">
            <small id="levelHelp" class="form-text text-muted">
              Ignore this field and the next if you don't want to change your password. Password should be 8 to 45 characters.
            </small>
          </div>

          <div class="form-group">
            <label for="confirmPassword">Confirm password</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
          </div>

          <button type="submit" name="update" class="btn btn-success mt-3">Update</button>
          <button type="button" class="btn btn-danger mt-3" onClick="window.location.reload(true)">Reset</button>

        </form>
      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

  <!-- Custom Script -->
  <script src="../js/script.js"></script>
  <script src="../js/show-file-input.js"></script>

</body>

</html>
