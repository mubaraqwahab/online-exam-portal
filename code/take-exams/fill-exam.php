<?php

require_once '../session.php';

require_once '../connect.php';

$userID = $_SESSION['userID'];
$profilePicture = $_SESSION['profilePicture'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Take Exams</title>

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
      <div class="container py-3 px-5">

        <!-- Heading -->
        <header class="mb-4" id="examHeader">
          <!-- Format: Mark [Course Code] ([Course Name]) [Exam Title] (Exam Type) -->
          <h4>Mark CSC303 (Web) Midterm <small class="text-muted">(Theory)</small></h4>
          <div class="d-flex flex-column flex-md-row">
            <div class="mr-md-3">
              <!-- PHP should put ID and Name here -->
              <div>Instructor: Abdulhakeem Audu</div>
              <div>10 Questions</div>
            </div>
          </div>
        </header>

        <!-- Form containing questions list -->
        <form method="POST" action="_submit-exam.php">

          <!-- Each card is a question group -->

          <!-- How a theory question card should look. -->
          <div class="card my-3">
            <div class="card-body">
              <!-- Question no and marks should change -->
              <h5 class="card-title">
                Question 1
                <small>(10 Marks)</small>
              </h5>
              <!-- Question should change as well -->
              <p class="card-text form-inline">
                <?php echo prepareFillInQuestion(
                  "Some quick example text to ___ title and make up the bulk of the card's content.", 1
                ) ?>
              </p>
            </div>
          </div>

          <div class="card my-3">
            <div class="card-body">
              <h5 class="card-title">
                Question 2
                <small>(10 Marks)</small>
              </h5>
              <p class="card-text form-inline">
                <?php echo prepareFillInQuestion(
                  "Some quick example text to ___ title and make up the bulk of the card's content.", 2
                ) ?>
              </p>
            </div>
          </div>


          <!-- Place the user ID and exam ID in the values below -->
          <input type="hidden" name="userID" value="">
          <input type="hidden" name="examID" value="">

          <button type="submit" name="submit" class="btn btn-success">Submit</button>
        </form>

      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/8d40ea811a.js" crossorigin="anonymous"></script>

  <!-- Custom Script -->
  <script src="../js/script.js"></script>

</body>
</html>