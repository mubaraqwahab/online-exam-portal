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

// Query to get instructor exams along with
// course codes, course names, exam titles, total scores and total marks and exam types for currently logged in user

$sql = "SELECT e.*, c.course_name,
    (SELECT COUNT(1) FROM exam_assignment a WHERE a.exam_id = e.exam_id) AS no_of_assignees,
    (SELECT COUNT(1) FROM exam_assignment a WHERE a.exam_id = e.exam_id AND (a.status_id = 5 OR a.status_id = 6))
      AS no_of_submissions
  FROM exam e
  INNER JOIN course c ON c.course_code = e.course_code
  WHERE e.instructor_id = ? AND e.status_id = ?
  ORDER BY e.exam_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $userID, $examStatus); // i for int, s for string


// Get open exams
$examStatus = 1;
$stmt->execute();
$openExams = $stmt->get_result();

// Get closed exams
$examStatus = 2;
$stmt->execute();
$closedExams = $stmt->get_result();

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

        <!-- Open Exams -->
        <section id="openExams">
          <h5 class="mb-3">Open</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->

            <!-- The server side should set the value of 'data-exam-id' to the exam id.
              The JavaScript here uses it to close the exam.
            -->
            <?php
            if ($openExams->num_rows > 0) {
              while ($exam = $openExams->fetch_assoc()) {
                $examID = $exam['exam_id'];
            ?>
            <li class="card my-2" data-exam-id="<?php echo $examID; ?>">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                  <span class="mr-md-3"><?php echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']} "; ?></span>
                  <span>
                    <!-- Replace the number of assignees and submissions -->
                    <small class="mr-2"><?php echo $exam['no_of_assignees']; ?> Assignee<?php echo pluralSuffix($exam['no_of_assignees']) ?></small>
                    <small><?php echo $exam['no_of_submissions']; ?> Submission<?php echo pluralSuffix($exam['no_of_submissions']) ?></small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <!-- Notice how the href is. It's going to send the examID to the exam.php page through GET
                    The examID value in the url should be the same as the data-exam-id above -->
                  <a href="exam.php<?php echo '?examID=' . $examID ?>" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                  <button class="btn btn-warning close-exam-btn" type="button">Close</button>
                </div>
              </div>
            </li>
            <?php
              }
            } else {
              echo "<div class='text-muted'>Nothing here.</div>";
            }
            ?>



          </ul>

        </section>

        <!-- Closed Exams -->
        <section id="closedExams">
          <h5 class="mb-3">Closed</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->
            <?php
            if ($closedExams->num_rows > 0) {
              while ($exam = $closedExams->fetch_assoc()) {
                $examID = $exam['exam_id'];
            ?>
            <li class="card my-2" data-exam-id="<?php echo $examID; ?>">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                  <span class="mr-md-3"><?php echo "{$exam['course_code']} ({$exam['course_name']}) {$exam['title']} "; ?></span>
                  <span>
                    <!-- Replace the number of assignees and submissions -->
                    <small class="mr-2"><?php echo $exam['no_of_assignees']; ?> Assignee<?php echo pluralSuffix($exam['no_of_assignees']) ?></small>
                    <small><?php echo $exam['no_of_submissions']; ?> Submission<?php echo pluralSuffix($exam['no_of_submissions']) ?></small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <a href="exam.php<?php echo '?examID=' . $examID ?>" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                </div>
              </div>
            </li>
            <?php
              }
            } else {
              echo "<div class='text-muted'>Nothing here.</div>";
            }
            ?>

          </ul>

        </section>

      </div>

    <!-- </div>

  </div> -->

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/8d40ea811a.js" crossorigin="anonymous"></script>

  <!-- Custom Script -->
  <script src="../js/script.js"></script>
  <script src="../js/manage-exam.js"></script>

</body>
</html>