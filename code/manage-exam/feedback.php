<?php

require_once '../session.php';

require_once '../connect.php';

$userID = $_SESSION['userID'];
$profilePicture = $_SESSION['profilePicture'];


$examID = $_GET['examID']
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Manage Exams</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
      <div class="container py-4 px-5">

        <div class="d-flex flex-column align-items-center">
          <?php

            if (isset($_GET['feedback'])) {
              $feedback = $_GET['feedback'];

              if ($feedback == 'success') {
                // print big success
                echo '<div class="text-success mb-2"><i class="fas fa-check-circle fa-10x"></i></div>';
                echo '<p class="text-success"><strong>Scores have been saved.</strong></p>';

              } else if ($feedback == 'failure') {
                // print big failure
                echo '<span class="text-danger mb-2 fa-stack fa-5x">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-times fa-stack-1x fa-inverse"></i>
                </span>';
                echo '<p class="text-danger"><strong>Unable to save scores. Please try again later.</strong></p>';
              }
            }

          ?>

          <div class="mt-3">
            <a href="./exam.php?examID=<?php echo $examID; ?>" class="btn btn-primary">Mark another exam</a>
          </div>
        </div>


      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/8d40ea811a.js" crossorigin="anonymous"></script>

  <!-- Custom Script -->
  <script src="../js/script.js"></script>
</body>

</html>
