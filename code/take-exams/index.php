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

        <section id="addByInviteCode" class="mb-4">
          <h5 class="mb-3">Add by invite code</h5>

          <div class="input-group mb-3">
            <input type="text" class="form-control" id="inviteCode" placeholder="Enter invite code here" aria-label="Enter invite code here" aria-describedby="addBtn">
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" id="addBtn">Add</button>
            </div>
          </div>

        </section>

        <!-- Available Exams -->
        <section id="availableExams">
          <h5 class="mb-3">Available</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->

            <li class="card my-2">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                  <span class="mr-md-3">CSC303 (Introduction to Computer Architecture and Organization) Midterm Exam</span>
                  <span>
                    <!-- Replace the exam type and no of questions -->
                    <small class="mr-2">Multi-choice</small>
                    <small>9 Questions</small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <!-- Notice how the href is. It's going to send the examID to the exam.php page through GET -->
                  <a href="multi-exam.php?examID=12" class="btn btn-primary d-md-block d-xl-inline-block my-1">Start</a>
                </div>
              </div>
            </li>

            <li class="card my-2">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">CSC303 (Introduction to Computer Architecture and Organization) Midterm Exam</span>
                  <span>
                    <small class="mr-2">Theory</small>
                    <small>9 Questions</small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <a href="theory-exam.php?examID=34" class="btn btn-primary d-md-block d-xl-inline-block my-1">Start</a>
                </div>
              </div>
            </li>



          </ul>

        </section>

      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Custom Script -->
  <script src="../js/script.js"></script>

  <script>

    $(document).ready(function() {

      // Add an exam by invite code on add button click
      $('#addBtn').on('click', function() {
        var inviteCode = $('#inviteCode').val();

        if (inviteCode.length < <?php echo INVITE_CODE_PREFIX_LENGTH + 1 ?>) {
          return;
        }

        $.ajax({
          url: '_add-by-invite.php',
          method: 'post',
          data: 'userID=<?php echo $userID; ?>&inviteCode=' + inviteCode,
          success: function(response) {
            if (response) {
              window.location.reload(true);
            } else {
              $('#addByInviteCode').append(
                '<?php showError("Unable to join exam. The invite code may be wrong, or the exam has been closed"); ?>'
              );
            }
          },
          error: function() {}
        });

      });

    });
  </script>

</body>
</html>