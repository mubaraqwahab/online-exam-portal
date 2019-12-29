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
          <h4>CSC303 (Web) Midterm</h4>
          <div class="d-flex flex-column flex-md-row align-items-md-center">
            <div class="mr-md-3 text-muted">
              <span>Theory</span>
              <span>&bull; 10 Questions &bull;</span>
              <span id="status">Invite Code: y6GiQ32</span>
            </div>
            <form method="POST" action="" class="mt-2 mt-md-0">
              <!-- Exam id from $_GET['examID'] should be kept in the value of this input below.
                The JavaScript here uses it to close the exam
              -->
              <input type="hidden" name="examID" value="32">
              <button type="submit" name="exportToCSV" class="btn btn-primary">Export to CSV</button>
              <button type="button" class="btn btn-warning close-exam-btn">Close</button>
            </form>
          </div>
        </header>

        <!-- Assignees list -->
        <div>
          <a class="my-1 d-block" data-toggle="collapse" href="#assignees" role="button" aria-expanded="false" aria-controls="assignees">
            <i class="fas fa-angle-down"></i> Assignees (10)
          </a>
          <div class="collapse" id="assignees">
            <div class="container">
              <div class="row" role="list">
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
                <div class="col-md-6 col-lg-4 p-2">ID - Name Surname</div>
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
              <i class="fas fa-angle-up"></i> Not Graded (2)
            </a>
            <div class="collapse show" id="notGradedList">
              <div class="container">
                <div class="row" role="list">

                  <div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">ID - Name Surname</span>
                          <!-- <span>
                            <small class="mr-2">10 Assignees</small>
                            <small class="mr-2">9 Submissions</small>
                          </span> -->
                        </div>
                        <div class="mt-2 mt-md-0">
                          <!-- Notice how the url is. It's going to send the examID and assigneeID to theory-response.php
                            through GET. The examID value should be set as set above in the input.
                            The value of assigneeID should be the ID of the student.
                            Also note that it links to 'theory-response.php'. So, if the exam is a fill-in exam,
                            the link would be fill-response.php instead. And for a multi-choice exam, multi-response.php
                          -->
                          <a href="theory-response.php?examID=32&assigneeID=171103026" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">ID - Name Surname</span>
                          <!-- <span>
                            <small class="mr-2">10 Assignees</small>
                            <small class="mr-2">9 Submissions</small>
                          </span> -->
                        </div>
                        <div class="mt-2 mt-md-0">
                          <a href="theory-response.php?examID=32&assigneeID=171103018" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


          <!-- Graded exams -->
          <div>
            <a class="my-2 d-block" data-toggle="collapse" href="#gradedList" role="button" aria-expanded="true" aria-controls="gradedList">
              <i class="fas fa-angle-up"></i> Graded (2)
            </a>
            <div class="collapse show" id="gradedList">
              <div class="container">
                <div class="row" role="list">

                  <div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">ID - Name Surname</span>
                          <span>
                            <small class="mr-2">100/100</small>
                          </span>
                        </div>
                        <div class="mt-2 mt-md-0">
                          <a href="theory-response.php?examID=32&assigneeID=171103010" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6 p-1">
                    <div class="card" data-exam-id="" role="listitem">
                      <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                          <!-- The format is: [ID] - [First Name] [Last Name] -->
                          <span class="mr-md-3">ID - Name Surname</span>
                          <span>
                            <small class="mr-2">100/100</small>
                          </span>
                        </div>
                        <div class="mt-2 mt-md-0">
                          <a href="theory-response.php?examID=32&assigneeID=171103007" class="btn btn-primary d-md-block d-xl-inline-block my-1">View</a>
                        </div>
                      </div>
                    </div>
                  </div>

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