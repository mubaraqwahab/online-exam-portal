<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Manage Exams</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
          <!-- Format: Mark [Course Code] ([Course Name]) [Exam Title] (Exam Type) -->
          <h4>View CSC303 (Web) Midterm <small class="text-muted">(Multi-choice)</small></h4>
          <div class="d-flex flex-column flex-md-row">
            <div class="mr-md-3">
              <!-- PHP should put ID and Name here -->
              <div>Student ID: 0123456789</div>
              <div>Student Name: Abdulhakeem Audu</div>
            </div>
            <div>
              Total Score: <span id="totalScore">100</span>
            </div>
          </div>
        </header>

        <!-- Form containing questions list -->
        <form method="POST">

          <!-- Each card is a question group -->

          <!-- How a multi-choice question should look, if the student got it -->
          <div class="card my-3">
            <div class="card-body">
              <!-- Question no should change -->
              <h5 class="card-title">Question 1</h5>
              <!-- Question should change as well -->
              <p class="card-text form-inline">
                Some quick example text to build on the card title and make up the bulk of the card's content.
              </p>

              <div class="card-text mb-3">
                <div class="px-3 py-2">
                  A. Lorem ipsum dolor sit amet
                </div>
                <!-- Correct answer should have these four extra classes:
                    border, rounded-pill, text-white, bg-success
                If student's response == correct answer, do nothing -->
                <div class="px-3 py-2 border rounded-pill text-white bg-success">
                  B. Lorem ipsum dolor sit amet
                </div>
                <div class="px-3 py-2">
                  C. Lorem ipsum dolor sit amet
                </div>
                <div class="px-3 py-2">
                  D. Lorem ipsum dolor sit amet
                </div>
              </div>

              <strong class="form-inline">
                Score:
                <span class="d-inline-block border rounded p-2 col-1 text-muted">10</span>
                /10
                <!-- The auto generated score, and the mark for the question should be put -->
              </strong>
            </div>
          </div>

          <!-- How a multi-choice question should look, if the student failed it -->
          <div class="card my-3">
            <div class="card-body">
              <!-- Question no should change -->
              <h5 class="card-title">Question 2</h5>
              <!-- Question should change as well -->
              <p class="card-text form-inline">
                Some quick example text to build on the card title and make up the bulk of the card's content.
              </p>

              <div class="card-text mb-3">
                <!-- Correct answer should have these four extra classes:
                    border, rounded-pill, text-white, bg-success
                If student's response != correct answer, add these classes to student's response:
                    border, rounded-pill, text-white, bg-danger
                -->
                <div class="px-3 py-2">
                  A. Lorem ipsum dolor sit amet
                </div>
                <div class="px-3 py-2 border rounded-pill text-white bg-danger">
                  B. Lorem ipsum dolor sit amet
                </div>
                <div class="px-3 py-2">
                  C. Lorem ipsum dolor sit amet
                </div>
                <!-- If correct answer != response,  -->
                <div class="px-3 py-2 border rounded-pill text-white bg-success">
                  D. Lorem ipsum dolor sit amet
                </div>
              </div>

              <strong class="form-inline">
                Score:
                <span class="d-inline-block border rounded p-2 col-1 text-muted">10</span>
                /10
                <!-- The auto generated score, and the mark for the question should be put -->
              </strong>
            </div>
          </div>


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