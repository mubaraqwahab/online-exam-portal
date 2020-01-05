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

// Get exam details
$sql = "SELECT e.*, c.course_name, t.value AS type
  FROM `exam` AS e
  INNER JOIN `course` AS c ON c.course_code = e.course_code
  INNER JOIN exam_type AS t ON t.type_id = e.type_id
  INNER JOIN exam_assignment AS a ON e.exam_id = a.exam_id
  WHERE e.status_id = 1 AND a.assignee_id = ? AND a.status_id = 3
  ORDER BY e.exam_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $userID);
$stmt->execute();
$result = $stmt->get_result();

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
        <!-- An exam is available if:
          * it has been assigned to the student,
          * it is open, and
          * the assignment status is 3 (i.e. ready)
         -->
        <section id="availableExams">
          <h5 class="mb-3">Available</h5>

          <ul class="list-unstyled">

            <!-- Each card represents an exam -->
            <?php
              if ($result->num_rows > 0) {
                while ($exam = $result->fetch_assoc()) {
                  echo "
                  <li class='card my-2'>
                    <div class='card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between'>
                      <div class='d-flex flex-column flex-xl-row align-items-xl-center'>
                        <!-- The format is: [Course Code] ([Course Name]) [Exam Title] -->
                        <span class='mr-md-3'>{$exam['course_code']} ({$exam['course_name']}) {$exam['title']}</span>
                        <span>
                          <!-- Replace the exam type and no of questions -->
                          <small class='mr-2'>{$exam['type']}</small>
                          <small>{$exam['no_of_questions']} Question". pluralSuffix($exam['no_of_questions']) ."</small>
                        </span>
                      </div>
                      <div class='mt-2 mt-md-0'>
                        <!-- Notice how the href is. It\'s going to send the examID to the exam.php page through GET -->
                        <a href='". getDestPage($exam['type_id']) . "?examID={$exam['exam_id']}' class='btn btn-primary d-md-block d-xl-inline-block my-1'>Start</a>
                      </div>
                    </div>
                  </li>
                  ";
                }
              }
            ?>

<?php
            // <!-- <li class="card my-2">
            //   <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
            //     <div class="d-flex flex-column flex-xl-row align-items-xl-center">
            //       <span class="mr-md-3">CSC303 (Introduction to Computer Architecture and Organization) Midterm Exam</span>
            //       <span>
            //         <small class="mr-2">Theory</small>
            //         <small>9 Questions</small>
            //       </span>
            //     </div>
            //     <div class="mt-2 mt-md-0">
            //       <a href="theory-exam.php?examID=34" class="btn btn-primary d-md-block d-xl-inline-block my-1">Start</a>
            //     </div>
            //   </div>
            // </li> -->
?>


          </ul>

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
                ( $('#addByInviteCode').has('.alert-danger').length ? '' :
                `<?php
                  showError("Unable to add exam. You may have added it already, or the invite code is wrong, or the exam has been closed");
                ?>` )
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