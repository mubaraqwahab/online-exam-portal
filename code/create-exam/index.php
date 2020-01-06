<?php
require_once '../session.php';

require_once '../connect.php';

$userID = $_SESSION['userID'];
$profilePicture = $_SESSION['profilePicture'];

// Create an exam
function createExam($instructorId, $courseCode, $title, int $typeId, int $noOfQuestions, $invitePrefix) {
  $sql = "INSERT INTO exam(instructor_id, course_code, title, type_id, no_of_questions, invite_prefix)
  VALUES ('$instructorId','$courseCode','$title',$typeId,$noOfQuestions,'$invitePrefix')";
  global $conn;
  return $conn->query($sql);
}

// Add a multichoice question
function addMultiQuestion(int $examID, int $questionNo, $question, $correctAnswer, $a, $b, $c, $d, float $mark) {
  // Sanitize
  [ $question, $a, $b, $c, $d ] = sanitize([ $question, $a, $b, $c, $d ]);

  $sql = "INSERT INTO multi_choice_question(exam_id, question_no, question, correct_answer, a, b, c, d, mark)
  VALUES ($examID, $questionNo, '$question', '$correctAnswer', '$a', '$b', '$c', '$d', $mark)";

  global $conn;

  return $conn->query($sql);
}

// Add a fill in the blank question
function addFillQuestion(int $examID, int $questionNo, $question, float $mark) {
  // Sanitize
  [ $question ] = sanitize([ $question ]);

  $sql = "INSERT INTO fill_in_question(exam_id, question_no, question, mark)
  VALUES ($examID, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

// Add a theory question
function addTheoryQuestion(int $examID, int $questionNo, $question, float $mark) {
  // Sanitize
  [ $question ] = sanitize([ $question ]);

  $sql = "INSERT INTO theory_question(exam_id, question_no, question, mark)
  VALUES ($examID, $questionNo, '$question', $mark)";

  global $conn;
  return $conn->query($sql);
}

// Assign an exam to a student
function assignStudentExam(int $examID, $userID) {
  $sql = "INSERT INTO exam_assignment(exam_id, assignee_id, total_score, status_id)
  VALUES ($examID,'$userID',NULL,1)";

  global $conn;
  return $conn->query($sql);
}

$result = $conn->query("SHOW TABLE STATUS WHERE `Name` = 'Exam'");
$examID = ($result->fetch_assoc())['Auto_increment'];

$inviteCode = generateRandomString(INVITE_CODE_PREFIX_LENGTH) . $examID;

if (isset($_POST['submit'])) {
  $examType = $_POST['examType'];
  $noOfQuestions = $_POST['noOfQuestions'];
  $invitePrefix = substr($_POST['inviteCode'], 0, INVITE_CODE_PREFIX_LENGTH);
  createExam($userID, $_POST['courseCode'], $_POST['examTitle'], $examType, $noOfQuestions, $invitePrefix);

  $totalMark = 0;

  for ($i=1; $i <= $noOfQuestions; $i++) {
    $mark = $_POST['mark'.$i];
    $totalMark += intval($mark);
    switch ($examType) {
      case 1:
        addMultiQuestion($examID, $i, $_POST['question'.$i], $_POST['correctOption'.$i],
          $_POST['optionA'.$i], $_POST['optionB'.$i], $_POST['optionC'.$i], $_POST['optionD'.$i], $mark);
        break;

      case 2:
        addFillQuestion($examID, $i, $_POST['question'.$i], $_POST['mark'.$i]);
        break;

      default:
        addTheoryQuestion($examID, $i, $_POST['question'.$i], $_POST['mark'.$i]);
        break;
    }
  }

  // Add total mark to exam
  $conn->query("UPDATE exam SET total_mark = $totalMark WHERE exam_id = $examID");

  // Assign students
  $noOfInvitees = intval($_POST['noOfInvitees']);
  for ($i=1; $i <= $noOfInvitees; $i++) {
    $assigneeID = $_POST['invitee'.$i];
    assignStudentExam($examID, $assigneeID);

    // Notify each student
    sendNotification($userID, $assigneeID, $examID, $t = NOTI_INVITE);
  }

  header('Location: '.$_SERVER['REQUEST_URI']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Create Exam</title>

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
        <!-- <h2 id="createExamTitle">Create Exam</h2> -->

        <form method="post" class="needs-validation" novalidate>
          <fieldset id="create1" class="mt-4">

            <div class="form-group">
              <label for="course">Course</label>
              <select class="custom-select" name="courseCode" id="courseCode" required>
                <?php
                $courses = $conn->query('SELECT * FROM course');

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
                $examTypes = $conn->query('SELECT * FROM exam_type');
                while ($record = $examTypes->fetch_assoc()) {
                  echo '<option value="' . $record['type_id'] . '">' . $record['value'] . '</option>';
                }
                ?>
              </select>
            </div>

            <button type="button" data-direction="next" class="btn btn-primary mt-3">Next</button>
            <button type="reset" class="btn btn-danger mt-3" onClick="window.location.reload(true)">Reset</button>
          </fieldset>

          <fieldset id="create2" class="mt-4">
            <div id="createQuestion"></div>

            <button type="button" data-direction="next" class="btn btn-primary mt-3">Next</button>
            <button type="reset" class="btn btn-danger mt-3" onClick="window.location.reload(true)">Reset</button>
          </fieldset>

          <fieldset id="create3" class="mt-4">
            <div class="form-group">
              <label for="inviteCode">Share this code to invite students to take the exam:</label>
              <input type="text" readonly class="d-block lead border p-2 col-2 text-center"
              id="inviteCode" name="inviteCode" value="<?php echo $inviteCode; ?>">

            </div>
            <p class="my-3">OR</p>
            <div class="form-group">
              <label for="inviteByID">Invite them by their IDs:</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="inviteByID" aria-describedby="inviteButton">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button" id="inviteButton">Invite</button>
                </div>
              </div>
              <div class="invalid-feedback" id="inviteFeedback"></div>
            </div>
            <div class="form-group" id="inviteesList">
              <h5>Invitees</h5>
              <ul class="list-group"></ul>
              <input type="number" id="noOfInvitees" name="noOfInvitees" value="0" class="d-none" readonly>
            </div>

            <button type="submit" name="submit" class="btn btn-success mt-3">Finish</button>
            <button type="button" class="btn btn-danger mt-3" onClick="window.location.reload(true)">Reset</button>
          </fieldset>

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

  <script src="../js/create-exam.js"></script>
</body>

</html>
