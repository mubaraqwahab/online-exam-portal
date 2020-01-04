<?php
include '../session.php';

include '../connect.php';

$userID = $_SESSION['userID'];
$profilePicture = $_SESSION['profilePicture'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Notifications</title>

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

        <section>
          <h5 class="mb-3">New</h5>

          <ul class="list-unstyled">

            <!-- Each card is a notification -->
            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has invited you to take Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <button class="btn btn-sm btn-success d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0" data-response="accept">Accept</button>
                  <button class="btn btn-sm btn-danger" data-response="decline">Decline</button>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has accepted your invite to take Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has declined your invite to take Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has joined Web Exam by invite code</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
              </div>
            </li>


          </ul>
        </section>

        <section>
          <h5 class="mb-3">Earlier</h5>

          <ul class="list-unstyled">

            <!-- Each card is a notification -->
            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has started Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has completed Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <a href="#" class="btn btn-sm btn-primary d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0">Grade</a>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has graded your Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
                <div class="mt-2 mt-md-0">
                  <a href="#" class="btn btn-sm btn-primary d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0">View</a>
                </div>
              </div>
            </li>

            <li class="card my-2 small" data-exam-id="12">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">Abdulhakeem Audu has closed Web Exam</span>
                  <span>
                    <small class="mr-2">07:49 28-Dec-19</small>
                  </span>
                </div>
              </div>
            </li>

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

  <script>
    $(document).ready(function() {
      $('[data-response="accept"]').on('click', function() {
        sendInviteResponse($(this), 'Accepted');
      });

      $('[data-response="decline"]').on('click', function() {
        sendInviteResponse($(this), 'Declined');
      });
    });

    function sendInviteResponse(jObj, newText) {
      $.ajax({
        url: '../ajax/_invite-response.php',
        type: 'post',
        data: {
          'userID': $('#uid').text(),
          'response': jObj.data('response')
        },
        success: function(res) {
          if (res) {
            jObj.text(newText);
            jObj.prop('disabled', true);
            jObj.siblings('button').remove();
            jObj.removeClass('btn-success btn-danger').addClass('btn-secondary');
          }
        },
        error: function() {}
      });
    }
  </script>
</body>

</html>
