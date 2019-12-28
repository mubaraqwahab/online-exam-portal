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

        <!-- Your code goes here -->
        <div class="card">
          <div class="card-body d-flex flex-row justify-content-between">
            <div>
              <div class="card-text d-inline-block mr-2">Abdulhakeem Audu has invited you to take Web Exam</div>
              <button class="btn btn-success" data-response="accept">Accept</button>
              <button class="btn btn-danger" data-response="decline">Decline</button>
            </div>
            <div>
              <small class="text-muted">07:49 28-Dec-19</small>
            </div>
          </div>
        </div>

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
        url: 'invite-response.php',
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
