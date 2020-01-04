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
  showError('page not available');
  exit;
}

$examID = $_GET['examID'];

$sql = "SELECT a.*, e.course_code, e.no_of_questions, c.course_name, e.type_id, e.title, e.total_mark, CONCAT(user.first_name, ' ', user.last_name) AS instructor
FROM exam_assignment a
INNER JOIN exam e ON a.exam_id = e.exam_id
INNER JOIN course c ON e.course_code = c.course_code
INNER JOIN user ON e.instructor_id = user.user_id
WHERE a.status_id = 6 AND a.assignee_id = '$userID' AND a.exam_id = $examID";

$result = mysqli_query($conn, $sql);

if ($result->num_rows != 1 ) {
  showError('Page not available');
  exit;
}

$exam = mysqli_fetch_assoc($result);

$sql2 = "SELECT q.* , r.score, r.response
FROM fill_in_question q
INNER JOIN fill_in_response r ON (q.exam_id = r.exam_id AND q.question_no = r.question_no)
WHERE q.exam_id = $examID AND r.assignee_id = '$userID'";
$result2 = mysqli_query($conn, $sql2);
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

          <!-- How a Fill-in the blank question should look -->
          <?php
          if ($result2->num_rows > 0) {
          for ($i = 1; $i<=$exam['no_of_questions']; $i++) {
            $exam2 = mysqli_fetch_assoc($result2);
          echo 
          '<div class="card my-3">
            <div class="card-body">
              <h5 class="card-title">Question ' . $exam2['question_no'] . '</h5>
              <p class="card-text">'
                 . prepareFillInQuestion($exam2['question'], NULL, $exam2['response'])  . 
              '</p>
            
              <strong>
                Score: ' . $exam2['score'] . "/" . $exam2['mark'] .  
              
              '</strong>
            </div>
          </div>';}}
          
            else {
              echo "No exams here";
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