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

// TODO: decode examID
$examID = $_GET['examID'];
$assigneeID = $_GET['assigneeID'];

// Get the assignment details from database
// Validate the instructor ID as well

$headerSql = "SELECT a.*, e.course_code, e.title, e.total_mark, c.course_name,
  et.value AS exam_type, CONCAT(u.first_name, ' ', u.last_name) AS assignee
  FROM exam_assignment AS a
  INNER JOIN exam AS e ON e.exam_id = a.exam_id
  INNER JOIN exam_type AS et ON e.type_id = et.type_id
  INNER JOIN course AS c ON c.course_code = e.course_code
  INNER JOIN user AS u ON u.user_id = a.assignee_id
  WHERE a.assignee_id = ? AND a.exam_id = ? AND e.instructor_id = ?";

$headerStmt = $conn->prepare($headerSql);
$headerStmt->bind_param('sis', $assigneeID, $examID, $userID);
$headerStmt->execute();
$headerResult = $headerStmt->get_result();

// If no such exam, give error

if ($headerResult->num_rows != 1) {
  showError('Page not available.');
  exit;
}

$assignment = $headerResult->fetch_assoc();

// Get questions and responses from database

$responseSql = "SELECT r.*, q.question, q.mark, q.correct_answer, q.a, q.b, q.c, q.d
  FROM `multi_choice_response` AS r
  INNER JOIN multi_choice_question AS q
  ON (q.exam_id = r.exam_id AND q.question_no = r.question_no)
  WHERE r.exam_id = ? AND r.assignee_id = ?
  ORDER BY r.question_no ASC";

$responseStmt = $conn->prepare($responseSql);
$responseStmt->bind_param('is', $examID, $assigneeID);
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
          <!-- Format: Mark [Course Code] ([Course Name]) [Exam Title] (Exam Type) -->
          <h4>
            View <?php echo "{$assignment['course_code']} ({$assignment['course_name']}) {$assignment['title']} "; ?>
            <small class="text-muted">
              <?php echo "({$assignment['exam_type']})" ?></small>
          </h4>
          <div class="d-flex flex-column flex-md-row">
            <div class="mr-md-3">
              <!-- PHP should put ID and Name here -->
              <div>Student ID: <?php echo $assignment['assignee_id']; ?></div>
              <div>Student Name: <?php echo $assignment['assignee']; ?></div>
            </div>
            <div>Total Score: <?php echo "{$assignment['total_score']}/{$assignment['total_mark']}"; ?></div>
          </div>
        </header>

        <!-- Form containing questions list -->
        <form method="POST">

          <?php
            if ($responseResult->num_rows > 0) {
              while ($response = $responseResult->fetch_assoc()) {
                echo '
                <div class="card my-3">
                  <div class="card-body">
                    <!-- Question no should change -->
                    <h5 class="card-title">Question '. $response['question_no'] .'</h5>
                    <!-- Question should change as well -->
                    <p class="card-text form-inline">'.
                      $response['question']
                    .'</p>

                    <!-- Correct answer should have these three extra classes:
                        rounded, text-white, bg-success
                    If student\'s response == correct answer, do nothing -->

                    <div class="card-text mb-3">';

                $options = array('a', 'b', 'c', 'd');
                foreach ($options as $opt) {
                  // if he chose a and a is correct, color green
                  // if he chose a and a is wrong, color red
                  // if he didn't choose a and a is correct, color green
                  if (compareStrWithoutCase($response['response'], $opt)
                      && compareStrWithoutCase($response['correct_answer'], $opt)) {
                    // color green
                    echo '<div class="px-3 py-1 my-1 rounded text-white bg-success">'. strtoupper($opt) . '. ' . $response[$opt] . '</div>';
                  } else if (compareStrWithoutCase($response['response'], $opt)
                      && !compareStrWithoutCase($response['correct_answer'], $opt)) {
                    // color red
                    echo '<div class="px-3 py-1 my-1 rounded text-white bg-danger">'. strtoupper($opt) . '. ' . $response[$opt] . '</div>';
                  } else if (!compareStrWithoutCase($response['response'], $opt)
                    && compareStrWithoutCase($response['correct_answer'], $opt)) {
                    // color green
                    echo '<div class="px-3 py-1 my-1 rounded text-white bg-success">'. strtoupper($opt) . '. ' . $response[$opt] . '</div>';
                  } else {
                    echo '<div class="px-3 py-1 my-1 rounded">'. strtoupper($opt) . '. ' . $response[$opt] . '</div>';
                  }
                }

                echo '
                    </div>

                    <strong class="form-inline">
                      Score:
                      <span class="d-inline-block border rounded p-2 col-3 col-sm-2 col-lg-1 text-muted">'.
                        $response['score']
                      .'</span>
                      /'. $response['mark'] .'
                    </strong>
                  </div>
                </div>
                ';
              }
            }
          ?>

          <?php
          // <!-- Each card is a question group -->

          // <!-- How a multi-choice question should look, if the student got it -->
          // <div class="card my-3">
          //   <div class="card-body">
          //     <!-- Question no should change -->
          //     <h5 class="card-title">Question 1</h5>
          //     <!-- Question should change as well -->
          //     <p class="card-text form-inline">
          //       Some quick example text to build on the card title and make up the bulk of the card's content.
          //     </p>

          //     <div class="card-text mb-3">
          //       <div class="px-3 py-2">
          //         A. Lorem ipsum dolor sit amet
          //       </div>
          //       <!-- Correct answer should have these three extra classes:
          //           rounded, text-white, bg-success
          //       If student's response == correct answer, do nothing -->
          //       <div class="px-3 py-2 rounded text-white bg-success">
          //         B. Lorem ipsum dolor sit amet
          //       </div>
          //       <div class="px-3 py-2">
          //         C. Lorem ipsum dolor sit amet
          //       </div>
          //       <div class="px-3 py-2">
          //         D. Lorem ipsum dolor sit amet
          //       </div>
          //     </div>

          //     <strong class="form-inline">
          //       Score:
          //       <span class="d-inline-block border rounded p-2 col-3 col-sm-2 col-lg-1 text-muted">10</span>
          //       /10
          //       <!-- The auto generated score, and the mark for the question should be put -->
          //     </strong>
          //   </div>
          // </div>

          // <!-- How a multi-choice question should look, if the student failed it -->
          // <div class="card my-3">
          //   <div class="card-body">
          //     <!-- Question no should change -->
          //     <h5 class="card-title">Question 2</h5>
          //     <!-- Question should change as well -->
          //     <p class="card-text form-inline">
          //       Some quick example text to build on the card title and make up the bulk of the card's content.
          //     </p>

          //     <div class="card-text mb-3">
          //       <!-- Correct answer should have these three extra classes:
          //           rounded, text-white, bg-success
          //       If student's response != correct answer, add these classes to student's response:
          //           rounded, text-white, bg-danger
          //       -->
          //       <div class="px-3 py-2">
          //         A. Lorem ipsum dolor sit amet
          //       </div>
          //       <div class="px-3 py-2 rounded text-white bg-danger">
          //         B. Lorem ipsum dolor sit amet
          //       </div>
          //       <div class="px-3 py-2">
          //         C. Lorem ipsum dolor sit amet
          //       </div>
          //       <!-- If correct answer != response,  -->
          //       <div class="px-3 py-2 rounded text-white bg-success">
          //         D. Lorem ipsum dolor sit amet
          //       </div>
          //     </div>

          //     <strong class="form-inline">
          //       Score:
          //       <span class="d-inline-block border rounded p-2 col-3 col-sm-2 col-lg-1 text-muted">10</span>
          //       /10
          //       <!-- The auto generated score, and the mark for the question should be put -->
          //     </strong>
          //   </div>
          // </div>
          ?>


          <!-- No finish button for multi-choice exams -->
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
  <script src="../js/manage-exam.js"></script>

</body>
</html>