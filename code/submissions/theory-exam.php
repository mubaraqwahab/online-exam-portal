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

  <title>Submissions</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="../css/simple-sidebar.css" rel="stylesheet">

</head>

<?php

if (!isset( $_GET['examID'])) {
  showError('Page not available');
  exit;
}

$examID = $_GET['examID'];

// You need course code, course name, exam title, instructor name, total score, total mark, no of questions for header
$headerSql = "SELECT a.*, e.*, c.course_name, CONCAT(u.first_name, ' ', u.last_name) AS instructor, t.value AS type
  FROM exam_assignment a
  INNER JOIN exam e ON e.exam_id = a.exam_id
  INNER JOIN exam_type t ON t.type_id = e.type_id
  INNER JOIN course c ON c.course_code = e.course_code
  INNER JOIN user u ON u.user_id = e.instructor_id
  WHERE a.exam_id = ? AND a.assignee_id = ? AND a.status_id = 6 AND e.type_id = 3";

$headerStmt = $conn->prepare($headerSql);
$headerStmt->bind_param('is', $examID, $userID);
$headerStmt->execute();
$headerResult = $headerStmt->get_result();

if ($headerResult->num_rows != 1) {
  showError('Page not available.');
  exit;
}

$exam = $headerResult->fetch_assoc();

// You need question no, question, response, correct answer, score, mark per question

$responseSql = "SELECT r.*, q.question, q.mark
  FROM theory_response r
  INNER JOIN theory_question q
  ON (q.exam_id = r.exam_id AND q.question_no = r.question_no)
  WHERE r.exam_id = ? AND r.assignee_id = ?
  ORDER BY r.question_no ASC";

$responseStmt = $conn->prepare($responseSql);
$responseStmt->bind_param('is', $examID, $userID);
$responseStmt->execute();
$responseResult = $responseStmt->get_result();
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
          <!-- Format: [Course Code] ([Course Name]) [Exam Title] (Exam Type) -->
          <h4><?php echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']}"; ?><small class="text-muted"> (Fill-in the blank)</small></h4>
          <div class="d-flex flex-column flex-md-row">
            <div class="mr-md-3">
              <!-- PHP should put ID and Name here -->
              <div>Instructor: <?php echo $exam['instructor']?></div>
              <div><?php echo $exam['no_of_questions' ]?> Question<?php echo pluralSuffix($exam['no_of_questions' ]) ?></div>
            </div>
            <div>Total Score: <?php echo "{$exam['total_score']}/{$exam['total_mark']}" ?></div>
          </div>
        </header>

        <!-- Form containing questions list -->
        <section>

          <!-- Each card is a question group -->
          <?php
          if ($responseResult->num_rows > 0) {
            while($response = $responseResult->fetch_assoc()) {
          ?>
          <div class="card my-3">
            <div class="card-body">
              <!-- Question no. should change -->
              <h5 class="card-title">Question <?php $response['question_no']; ?></h5>
              <!-- Question should change as well -->
              <p class="card-text">
                <?php echo $response['question']; ?>
              </p>

              <h6 class=" mb-2">Response</h6>
              <!-- Response should change -->
              <p class="card-text">
                <?php echo $response['response']; ?>
              </p>

              <strong>
                Score: <?php echo $response['score'] . '/' . $response['mark']; ?>
              </strong>
            </div>
          </div>
          <?php
            }
          }
          ?>

        </section>

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