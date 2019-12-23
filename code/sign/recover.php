<?php
include "../connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



if(isset($_POST['submit'])) {
  $emailaddress = $_POST["email"];
  $sql = "SELECT password, email, user_id, first_name, last_name FROM user WHERE email='$emailaddress'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $key = generateRandomToken($length = 6);
    
      while($row = mysqli_fetch_assoc($result)) {
          
          //Random key/token generator        
          
          
          $mail = new PHPMailer(true);

          
          //Server settings
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'examportal.group5@gmail.com';                     // SMTP username
          $mail->Password   = 'esat1234';                               // SMTP password
          $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
          $mail->Port       = 587;                                    // TCP port to connect to
        
          //Recipients
          $mail->setFrom($emailaddress, 'Exam Portal(Group 5)');
          $mail->addAddress($emailaddress, 'User');     // Add a recipient
          $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Reset Password';
          $mail->Body    = "The token is:  $key";
          $mail->AltBody = "The token is:  $key";
          
          
          
          
          if($mail->send()){
            //echo 'Reset link has been sent';
            $sql = "UPDATE user SET `key`= $key WHERE email= '$emailaddress'";
            echo $sql;
            $sqlquery = mysqli_query($conn, $sql);

          }
          else{
            echo "ERRORRR";
          }
          
          header("Location: reset.php?email=$emailaddress");
          
        
        }
    }
    
}




?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">

    <title>Recover password</title>
  </head>
  <body>
    <form method="POST">
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-6 mx-auto my-5">
          <div class="card card-sign">
            <div class="card-body p-4 p-md-5">
              <h2 class="mb-5 text-center font-weight-light">Recover Password</h2>
              <form method="post" action="reset.php">
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" required autofocus placeholder="Enter Your Email...">
                    <small id="emailHelp" class="form-text text-muted">
                      We would send a recovery link to your email. Hurry up, the link would expire soon!
                    </small>
                  </div>
                </div>
                  <button class="btn btn-lg btn-primary btn-block mt-4"  name="submit" type="submit">Send Token</button>
                <div class="text-center">
                  <a class="d-inline-block text-center mt-2 small" href="sign-in.php">Sign in</a> &middot;
                  <a class="d-inline-block text-center mt-2 small" href="sign-up.php">Sign up</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script>
      $(document).ready(function () {
        bsCustomFileInput.init()
      })
    </script>
  </body>
</html>