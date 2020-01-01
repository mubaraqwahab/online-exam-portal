<?php
include "../connect.php";

$examID = $_GET['examID'];
$sql = "SELECT * FROM exam WHERE exam_id = $examID";
$result = mysqli_query($conn, $sql);
$exam = mysqli_fetch_assoc($result);

$invitePrefix = $exam['invite_prefix'];
$examTitle = $exam['title'];
$courseCode = $exam['course_code'];
$noOfQuestion = $exam['no_of_questions'];
$examTypeID = $exam['type_id'];

$inviteCode = "$invitePrefix" . "$examID";

$sql2 = "SELECT *
FROM exam
INNER JOIN exam_type ON exam.type_id = exam_type.type_id WHERE exam_id = $examID";
$result2 = mysqli_query($conn, $sql2);
$exam2 = mysqli_fetch_assoc($result2);

$examType = $exam2['value'];

//List of Assignees
$sql3 = "SELECT *
FROM exam_assignment
INNER JOIN user ON exam_assignment.assignee_id = user.user_id WHERE exam_id = $examID";
$result3 = mysqli_query($conn, $sql3);
$noOfAssignees = mysqli_num_rows($result3);

$sql4 = "SELECT *
FROM exam_assignment
INNER JOIN user ON exam_assignment.assignee_id = user.user_id WHERE exam_id = $examID AND status_id = '6'";
$result4 = mysqli_query($conn, $sql4);
$noOfGraded = mysqli_num_rows($result4);


$sql5 = "SELECT *
FROM exam_assignment
INNER JOIN user ON exam_assignment.assignee_id = user.user_id WHERE exam_id = $examID AND status_id = '5'";
$result5 = mysqli_query($conn, $sql5);
$noOfNotGraded = mysqli_num_rows($result5);

switch($examTypeID){
  case 1 :
    $examTypeDestination = "multi-response.php";
  break;
  case 2:
    $examTypeDestination = "fill-response.php";
  break;
  case 3:
    $examTypeDestination = "theory-response.php";
  break;
}
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
          <h4><?php echo $courseCode . " " . "(" . $examTitle . ")"?></h4>
          <div class="d-flex flex-column flex-md-row align-items-md-center">
            <div class="mr-md-3 text-muted">
              <span><?php echo $examType?></span>
              <span>&bull; <?php echo $noOfQuestion . " Question(s)"?> &bull;</span>
              <span id="status">Invite Code: <?php echo $inviteCode?></span>
            </div>
            <form method="POST" action="" class="mt-2 mt-md-0">
              <!-- Exam id from $_GET['examID'] should be kept in the value of this input below.
                The JavaScript here uses it to close the exam
              -->
              <input type="hidden" name="examID" value="<?php echo $examID; ?>">
              <button type="submit" name="exportToCSV" class="btn btn-primary">Export to CSV</button>
              <button type="button" class="btn btn-warning close-exam-btn">Close</button>
            </form>
          </div>
        </header>

        <!-- Assignees list -->
        <div>
          <a class="my-1 d-block" data-toggle="collapse" href="#assignees" role="button" aria-expanded="false" aria-controls="assignees">
            <i class="fas fa-angle-down"></i> Assignees <?php echo "(" . $noOfAssignees . ")"?>
          </a>
          <div class="collapse" id="assignees">
            <div class="container">
              <div class="row" role="list">
              <?php while($row = $result3->fetch_assoc()){
                echo '<div class="col-md-6 col-lg-4 p-2">' . "[" . $row['user_id'] . "] " . $row['first_name'] . " " . $row['last_name'] . "</div>";
              }
              ?>

              </div>
            </div>
          </div>
        </div>

        <!-- Submissions list -->
        <section class="mt-4">
          <h5>Submissions</h5>

          <!-- Not-graded exams -->
          <div>
            <a class="my-2 d-block" data-toggle="collapse" href="#notGradedList" role="button" aria-expanded="true" aria-controls="notGradedList">
              <i class="fas fa-angle-up"></i> <?php echo "Not Graded " . "(" . $noOfNotGraded . ")"?>
            </a>
            <div class="collapse show" id="notGradedList">
              <div class="container">
                <div class="row" role="list">
                <?php
                while($row = $result5->fetch_assoc()){
                  echo '<div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">' . $row['user_id'] . " " . $row['first_name'] . " " . $row['last_name'] . '</span>
                          <!--<span>
                            <small class="mr-2">10 Assignees</small>
                            <small class="mr-2">9 Submissions</small>
                          </span>-->
                        </div>
                        <div class="mt-2 mt-md-0">
                            <!--Notice how the url is. It\'s going to send the examID and assigneeID to theory-response.php
                            through GET. The examID value should be set as set above in the input.
                            The value of assigneeID should be the ID of the student.
                            Also note that it links to theory-response.php. So, if the exam is a fill-in exam,
                            the link would be fill-response.php instead. And for a multi-choice exam, multi-response.php
                            -->
                          <a href="' . $examTypeDestination . '?' . "examID=" . $examID . '&' . "assigneeID=" . $row['user_id'] . '" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>';
                  }?>


                </div>
              </div>
            </div>
          </div>


          <!-- Graded exams -->
          <div>
            <a class="my-2 d-block" data-toggle="collapse" href="#gradedList" role="button" aria-expanded="true" aria-controls="gradedList">
              <i class="fas fa-angle-up"></i> <?php echo "Graded " . "(" . $noOfGraded . ")"?>
            </a>
            <div class="collapse show" id="gradedList">
              <div class="container">
                <div class="row" role="list">

                <?php
                while($row = $result4->fetch_assoc()){
                  echo '<div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">' . "[" . $row['user_id'] . "] " . $row['first_name'] . " " . $row['last_name'] . '</span>
                          <span>
                            <small class="mr-2">' . $row['total_score'] . '/100</small>
                          </span>
                        </div>
                        <div class="mt-2 mt-md-0">
                        <a href="' . $examTypeDestination . '?' . "examID=" . $examID . '&' . "assigneeID=" . $row['user_id'] . '" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>';}
                  ?>



                </div>
              </div>
            </div>
          </div>

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
  <script src="../js/manage-exam.js"></script>

</body>
</html>