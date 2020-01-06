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

  <title>Notifications</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link href="../css/simple-sidebar.css" rel="stylesheet">

</head>

<?php

function prepareNotificationMsg($template, $sender, $exam) {
  $msg = str_replace('[User]', $sender, $template);
  $msg = str_replace('[Exam]', $exam, $msg);

  return $msg;
}

function getDestPrefix($examType) {
  $dest = '';
  switch ($examType) {
    case 1:
      $dest = 'multi-';
      break;
    case 2:
      $dest = 'fill-';
      break;
    default:
      $dest = 'theory-';
      break;
  }
  return $dest;
}

// function prepareOldNotificationAction($noti) {
//   $action = '';

//   if ($noti['status_id'] == 3 && $noti['type_id'] == 1) {
//       // $action .= '<div class="mt-2 mt-md-0">';
//       // $action .= '<button class="btn btn-secondary d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0" disabled>' . $noti['invite_act'] . '</button>';
//       // $action .= '</div>';

//   }

//   return $action;
// }

function prepareNotificationAction($noti) {
  $action = '';

  switch ($noti['type_id']) {
    case 1:
      $action .= '<div class="mt-2 mt-md-0">';
      $action .= '<button class="btn btn-success d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0" data-response="accept">Accept</button>';
      $action .= '<button class="btn btn-danger ml-1 ml-md-0 ml-lg-1" data-response="decline">Decline</button>';
      $action .= '</div>';

      break;
    case 6:
      $href = '../manage-exam/' . getDestPrefix($noti['exam_type']) . "response.php?examID={$noti['exam_id']}&assigneeID={$noti['sender_id']}";
      $action .= '<div class="mt-2 mt-md-0">';
      $action .= '<a href="'. $href .'" class="btn btn-primary d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0">Grade</a>';
      $action .= '</div>';

      break;
    case 7:
      $href = '../submissions/' . getDestPrefix($noti['exam_type']) . 'exam.php?examID=' . $noti['exam_id'];
      $action .= '<div class="mt-2 mt-md-0">';
      $action .= '<a href="'. $href .'" class="btn btn-primary d-md-block d-xl-inline-block mt-1 mt-md-0 mb-1 my-lg-0">View</a>';
      $action .= '</div>';

      break;

    default:
      break;
  }

  return $action;
}


// QUERY

$sql = "SELECT n.*, CONCAT(u.first_name, ' ', u.last_name) AS sender,
  e.type_id AS exam_type, CONCAT(e.course_code, ' ', e.title) AS exam_name,
  nt.msg_template
  FROM notification n
  INNER JOIN user u ON u.user_id = n.sender_id
  INNER JOIN exam e ON e.exam_id = n.exam_id
  INNER JOIN notification_type nt ON nt.type_id = n.type_id
  WHERE n.recipient_id = ? AND n.status_id = ?
  ORDER BY n.time_stamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $userID, $status);

// Get new notifications
$status = 1;

$stmt->execute();
$newNotifications = $stmt->get_result();


// Get earlier notifications
$status = 2;

$stmt->execute();
$oldNotifications = $stmt->get_result();

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

        <section id="newNotifications" class="mb-4">
          <h5 class="mb-3">New</h5>

          <ul class="list-unstyled">

            <!-- Each card is a notification -->
            <?php
            if ($newNotifications->num_rows > 0) {
              while ($noti = $newNotifications->fetch_assoc()) {

            ?>

            <li class="card my-2" data-noti-id="<?php echo $noti['notification_id']; ?>" data-exam-id="<?php echo $noti['exam_id']; ?>" data-from="<?php echo $noti['sender_id']; ?>">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">
                  <?php echo prepareNotificationMsg($noti['msg_template'], $noti['sender'], $noti['exam_name']) ?>
                  </span>
                  <span>
                    <small class="mr-2"><?php echo $noti['time_stamp']; ?></small>
                  </span>
                </div>

                <?php
                echo prepareNotificationAction($noti);
                ?>
              </div>
            </li>

            <?php
              // Mark each notification as viewed
              $conn->query("UPDATE notification SET status_id = 2 WHERE notification_id = {$noti['notification_id']}");
              }
            } else {
              echo "<p class='text-muted'>Nothing here.</p>";
            }
            ?>


          </ul>
        </section>

        <section>
          <h5 class="mb-3">Earlier</h5>

          <ul class="list-unstyled">

            <!-- Each card is a notification -->
            <?php
            if ($oldNotifications->num_rows > 0) {
              while ($noti = $oldNotifications->fetch_assoc()) {

            ?>

            <li class="card my-2" data-noti-id="<?php echo $noti['notification_id']; ?>" data-exam-id="<?php echo $noti['exam_id']; ?>">
              <div class="card-body py-2 px-3 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex flex-column flex-xl-row align-items-xl-center">
                  <span class="mr-md-3">
                  <?php echo prepareNotificationMsg($noti['msg_template'], $noti['sender'], $noti['exam_name']) ?>
                  </span>
                  <span>
                    <small class="mr-2"><?php echo $noti['time_stamp']; ?></small>
                  </span>
                </div>

                <?php
                echo prepareNotificationAction($noti);
                ?>
              </div>
            </li>

            <?php
              }
            } else {
              echo "<p class='text-muted'>Nothing here.</p>";
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
  <script src="https://kit.fontawesome.com/8d40ea811a.js" crossorigin="anonymous"></script>

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
      var noti = jObj.parents('[data-exam-id]');
      $.ajax({
        url: '../ajax/_invite-response.php',
        type: 'post',
        data: ('notiID=' + noti.data('noti-id')
                + '&from=' + noti.data('from')
                + '&userID=<?php echo $userID; ?>'
                + '&examID=' + noti.data('exam-id')
                + '&response=' + jObj.data('response')),
        success: function(res) {
          if (res) {
            // noti.remove();
            window.location.reload(true);

          }
        },
        error: function() {}
      });
    }
  </script>
</body>

</html>
