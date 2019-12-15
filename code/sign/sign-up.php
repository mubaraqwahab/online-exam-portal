<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/sign.css">

    <title>Sign up</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-6 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <h5 class="card-title text-center">Sign Up</h5>
              <form class="form-signin">
                <div class="form-label-group">
                  <input type="text" id="userID" name="userID" class="form-control" placeholder="User ID" aria-describedby="userIDHelp" required autofocus>
                  <label for="userID">User ID</label>
                  <small id="userIDHelp" class="form-text text-muted ml-3">
                    Use your student ID if you're a student. User ID should be between 8 and 16 characters. Only numbers and letters are valid.
                  </small>
                </div>
                <div class="form-label-group">
                  <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name" required>
                  <label for="firstName">First name</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last name" required>
                  <label for="lastName">Last name</label>
                </div>

                <div class="form-label-group">
                  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
                  <label for="email">Email address</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelp" placeholder="Password" required>
                  <label for="password">Password</label>
                  <small id="passwordHelp" class="form-text text-muted ml-3">
                    Password should be 8 to 45 characters.
                  </small>
                </div>

                <div class="form-label-group">
                  <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Password" required>
                  <label for="confirmPassword">Confirm password</label>
                </div>

                <hr>

                <div class="form-label-group">
                  <!-- <input type="text" id="level" name="level" class="form-control" aria-describedby="levelHelp" placeholder="Level (optional)" required> -->
                  <select id="level" name="level" class="custom-select form-control rounded-pill" aria-describedby="levelHelp">
                    <option value=""></option>
                    <option value="1">100</option>
                    <option value="2">200</option>
                    <option value="3">300</option>
                    <option value="4">400</option>
                  </select>
                  <!-- <label for="level">Level (optional)</label> -->
                  <small id="levelHelp" class="form-text text-muted ml-3">
                    Leave this field blank if you're not a student.
                  </small>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-center">
                    <img src="../img/blank-square.jpg"
                      class="rounded-circle text-center" width="25%" alt="Profile picture">
                  </div>
                  <div class="d-flex justify-content-center">
                    <div class="custom-file mt-2 w-75">
                      <input type="file" class="form-control custom-file-input" placeholder="Profile picture (optional)" id="profilePicture" name="profilePicture">
                      <label class="custom-file-label" for="profilePicture">Profile picture (optional)</label>
                    </div>
                  </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Sign up</button>
                <a class="d-block text-center mt-2 small" href="sign-in.html">Sign in</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>