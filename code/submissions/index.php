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

  <title>Manage Exams</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="../css/simple-sidebar.css" rel="stylesheet">

</head>

<?php

// Query to get not graded exams along with
// course codes, course names, exam titles, total scores and total marks and exam types for currently logged in user

$sql = "SELECT a.*, e.course_code, c.course_name, e.type_id, e.title, e.total_mark, t.value AS type
  FROM exam_assignment a
  INNER JOIN exam e ON a.exam_id = e.exam_id
  INNER JOIN exam_type t ON t.type_id = e.type_id
  INNER JOIN course c ON e.course_code = c.course_code
  WHERE a.status_id = ? AND a.assignee_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $assignmentStatus, $userID); // i for int, s for string


// Get ungraded exams
$assignmentStatus = 5;
$stmt->execute();
$ungradedExams = $stmt->get_result();

// Get graded exams
$assignmentStatus = 6;
$stmt->execute();
$gradedExams = $stmt->get_result();

// Return the destination page for an exam
function getDestPage($examTypeID) {
  $destPage = '';
  switch ($examTypeID) {
    case 1: $destPage = 'multi-exam.php'; break;
    case 2: $destPage = 'fill-exam.php'; break;
    default: $destPage = 'theory-exam.php';
  }
  return $destPage;
}

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

        <!-- Not Graded Exams -->
        <section id="notGradedExams">
          <h5 class="mb-3">Not Graded</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->
            <!-- These would need to repeat, so a loop -->

            <?php
            if ($ungradedExams->num_rows > 0) {
              while ($exam = $ungradedExams->fetch_assoc()) {
            ?>

            <li class="card my-2">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                  <span class="mr-md-3"><?php echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']}"; ?></span>
                  <span>
                    <!-- Replace the exam type -->
                    <small class="mr-2"><?php echo $exam['type'] ?></small>
                  </span>
                </div>
              </div>
            </li>

            <?php
              }
            } else {
              echo "No exams here";
            }
            ?>
          </ul>

        </section>

        <!-- Graded Exams -->
        <section id="gradedExams">
          <h5 class="mb-3">Graded</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->

            <?php
            if ($gradedExams->num_rows > 0) {
              while ($exam = $gradedExams->fetch_assoc()) {
            ?>
            <li class="card my-2">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                  <span class="mr-md-3"><?php echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']}"; ?></span>
                  <span>
                    <!-- Replace the exam type -->
                    <small class="mr-2"><?php echo $exam['type'] ?></small>
                    <small><?php echo "{$exam['total_score']}/{$exam['total_mark']}" ?></small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <!-- Notice how the href is. It's going to send the examID to the theory.php page through GET -->
                  <a href="<?php echo getDestPage($exam['type_id']) . "?examID={$exam['exam_id']}" ?>" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                </div>
              </div>
            </li>
            <?php
              }
            } else {
              echo "No exams here";
            }
            ?>

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

</body>

</html>