<?php
include 'connect.php';

if (isset($_POST['submit'])) {
  $examType = $_POST['examType'];
  $noOfQuestions = $_POST['noOfQuestions'];
  createExam('171103026', $_POST['courseCode'], $_POST['examTitle'], $examType, $noOfQuestions);

  $examId = $conn->insert_id;

  for ($i=1; $i <= $noOfQuestions; $i++) {
    switch ($examType) {
      case 1:
        addMultiQuestion($examId, $i, $_POST['question'.$i], $_POST['correctAnswer'.$i],
          $_POST['optionA'.$i], $_POST['optionB'.$i], $_POST['optionC'.$i], $_POST['optionD'.$i], $_POST['mark'.$i]);
        break;

      case 2:
        addFillQuestion($examId, $i, $_POST['question'.$i], $_POST['mark'.$i]);
        break;

      default:
        addTheoryQuestion($examId, $i, $_POST['question'.$i], $_POST['mark'.$i]);
        break;
    }
  }

  header("Location:index.html");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Create Exam</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

  <?php include 'components/_header.php' ?>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php require 'components/_sidebar.php' ?>

    <!-- Page content wrapper -->
    <div id="page-content-wrapper">

      <!-- Navbar -->
      <?php require 'components/_navbar.php' ?>

      <!-- Page content -->
      <div class="container py-3 px-5">
        <!-- <h2 id="createExamTitle">Create Exam</h2> -->

        <form method="post">
          <fieldset id="create1" class="mt-4">

            <div class="form-group">
              <label for="course">Course</label>
              <select class="custom-select" name="courseCode" id="courseCode" required>
                <?php
                while ($record = $courses->fetch_assoc()) {
                  $courseCode = $record['course_code'];
                  echo '<option value="' . $courseCode . '">' . $courseCode . ' - ' . $record['course_name'] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="examTitle">Title</label>
              <input type="text" class="form-control" name="examTitle" id="examTitle" placeholder="e.g. Mid-term Exam" required>
            </div>

            <div class="form-group">
              <label for="noOfQuestions">How many questions does the exam have?</label>
              <input type="number" class="form-control" name="noOfQuestions" id="noOfQuestions" value="1" required>
            </div>

            <div class="form-group">
              <label for="examType">What type of exam is it?</label>
              <select class="custom-select" name="examType" id="examType" required>
                <?php
                while ($record = $examTypes->fetch_assoc()) {
                  echo '<option value="' . $record['type_id'] . '">' . $record['value'] . '</option>';
                }
                ?>
              </select>
            </div>

            <button type="button" data-direction="next" class="btn btn-primary mt-3">Next</button>
            <button type="reset" class="btn btn-danger mt-3" onClick="history.go(0);">Reset</button>
          </fieldset>

          <fieldset id="create2" class="mt-4">
            <div id="createQuestion"></div>

            <button type="button" data-direction="next" class="btn btn-primary mt-3">Next</button>
            <button type="reset" class="btn btn-danger mt-3" onClick="history.go(0);">Reset</button>
          </fieldset>

          <fieldset id="create3" class="mt-4">
            <div class="form-group">
              <p>Share this link to invite students to take the exam:</p>
              <p class="h5 border p-2 d-inline-block">qS31kUil</p>
            </div>
            <p class="my-3">OR</p>
            <div class="form-group">
              <label for="inviteByEmail">Invite them by their emails:</label>
              <div class="input-group mb-3">
                <input type="email" class="form-control" id="inviteByEmail" aria-describedby="inviteButton">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" id="inviteButton">Invite</button>
                </div>
              </div>
            </div>
            <div class="form-group" id="inviteesList">
              <h5>Invitees</h5>
              <ul class="list-group"></ul>
            </div>

            <button type="submit" name="submit" class="btn btn-success mt-3">Finish</button>
            <button type="button" class="btn btn-danger mt-3" onClick="history.go(0);">Reset</button>
          </fieldset>

        </form>
      </div>

    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Custom Script -->
  <script src="js/script.js"></script>
</body>

</html>