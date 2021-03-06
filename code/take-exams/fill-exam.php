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

<?php

// TODO: decode examID
$examID = $_GET['examID'];

$typeID = 2;

// Get the exam details from database
// Validate the student ID, exam ID and type ID, and assignment status as well
$headerSql = "SELECT e.*, c.course_name, t.value AS type, CONCAT(u.first_name, ' ', u.last_name) AS instructor
  FROM `exam` AS e
  INNER JOIN user AS u ON u.user_id = e.instructor_id
  INNER JOIN `course` AS c ON c.course_code = e.course_code
  INNER JOIN exam_type AS t ON t.type_id = e.type_id
  WHERE e.exam_id = ? AND e.type_id = ? AND e.status_id = 1
  AND EXISTS (SELECT 1 FROM exam_assignment WHERE exam_id = ? AND assignee_id = ? AND status_id = 3)";

$headerStmt = $conn->prepare($headerSql);
$headerStmt->bind_param('iisi', $examID, $typeID, $examID, $userID);
$headerStmt->execute();
$headerResult = $headerStmt->get_result();

// If no such exam, give error

if ($headerResult->num_rows != 1) {
  showError('Page not available.');
  exit;
}

$exam = $headerResult->fetch_assoc();

// Get questions from database

$questionSql = "SELECT * FROM `fill_in_question` WHERE exam_id = ? ORDER BY question_no ASC";

$questionStmt = $conn->prepare($questionSql);
$questionStmt->bind_param('i', $examID);
$questionStmt->execute();
$questionResult = $questionStmt->get_result();

// Let the db know the student has started the exam
$statusSql = "UPDATE exam_assignment SET status_id = " . ASSIGNMENT_IN_PROGRESS . " WHERE exam_id = ? AND assignee_id = ?";

$statusStmt = $conn->prepare($statusSql);
$statusStmt->bind_param('is', $examID, $userID);
$statusStmt->execute();

if ($conn->affected_rows != 1) {
  showError('Page currently unavailable. Please try again later.');
  exit;
}

// Send notification to instructor that exam has been started
sendNotification($userID, $exam['instructor_id'], $examID, $t = NOTI_START);
?>

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
          <h4>
            <?php
            echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']}
            <small class='text-muted'>({$exam['type']})</small>";
            ?>
          </h4>
          <div class="d-flex flex-column flex-md-row">
            <div class="mr-md-3">
              <!-- PHP should put ID and Name here -->
              <div>Instructor: <?php echo $exam['instructor']; ?></div>
              <div><?php echo $exam['no_of_questions']; ?> Question<?php echo pluralSuffix($exam['no_of_questions']); ?></div>
            </div>
          </div>
        </header>

        <!-- Form containing questions list -->
        <form method="POST" action="_submit-exam.php">

          <!-- Each card is a question group -->

          <!-- How a theory question card should look. -->
          <?php
          if ($questionResult->num_rows > 0) {
            while ($question = $questionResult->fetch_assoc()) {
              echo "
              <div class='card my-3'>
                <div class='card-body'>
                  <!-- Question no and marks should change -->
                  <h5 class='card-title'>
                    Question {$question['question_no']}
                    <small>({$question['mark']} Mark". pluralSuffix($question['mark']) . ")</small>
                  </h5>
                  <!-- Question should change as well -->
                  <p class='card-text form-inline'>" .
                    prepareFillInQuestion($question['question'], $question['question_no'])
                  . "</p>
                </div>
              </div>";
            }
          }
          ?>


          <!-- Place the user ID and exam ID in the values below -->
          <input type="hidden" name="userID" value="<?php echo $userID; ?>">
          <input type="hidden" name="examID" value="<?php echo $examID; ?>">

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