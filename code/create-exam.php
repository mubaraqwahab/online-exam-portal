<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Create Exam</title>
  </head>
  <body>
    <h2>Create Exam</h2>

    <form method="post">
      <fieldset id="create-1">

        <div class="form-group">
          <label for="noOfQuestions">How many questions does the exam have?</label>
          <input type="number" class="form-control" name="noOfQuestions" id="noOfQuestions">
        </div>
          <div class="form-group">
          <label for="examType">What type of exam is it?</label>
          <select class="form-control" name= "examType" id="examType">
            <option value="">Multi-choice</option>
            <option value="">Theory</option>
            <option value="">Fill in the blank</option>
          </select>
        </div>

        <button type="button" data-direction="next" class="btn btn-primary">Next</button>
      </fieldset>
      <fieldset id="create-2">
        <p>This is the first question</p>
        <input type="text" class="form-control">

        <button type="button" data-direction="previous" class="btn btn-primary">Previous</button>
        <button type="button" data-direction="next" class="btn btn-primary">Next</button>
      </fieldset>

      <fieldset id="create-3">
        <p>This is the second question</p>
        <input type="text" class="form-control">

        <button type="button" data-direction="previous" class="btn btn-primary">Previous</button>
        <button type="submit" name="submit" class="btn btn-primary">Finish</button>
      </fieldset>

    </form>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
      $("fieldset:not(:first-child)").hide();

      $("fieldset [data-direction='next']").on('click', function(e) {
        $(this).parent().hide().next().show();
      });

      $("fieldset [data-direction='previous']").on('click', function(e) {
        $(this).parent().hide().prev().show();
      });

    </script>
  </body>
</html>

<?php
if (isset($_POST['submit'])) {
  header("Location:index.html");
}
?>