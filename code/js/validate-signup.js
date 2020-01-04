$(document).ready(function () {

  $('#userID').on('keyup', function() {
    checkAvailability($(this).attr('id'));
  });

  $('#email').on('keyup', function() {
    checkAvailability($(this).attr('id'));
  });

  $('#confirmPassword').on('keyup', function() {
    if ($(this).val() === $('#password').val()) {
      $(this)[0].setCustomValidity("");
    } else {
      $(this)[0].setCustomValidity("Passwords don't match");
    }
  });

  $('#profilePicture').on('change', function() {
    var file = $(this)[0].files[0]; // get file
    var filesize = ((file.size/1024)/1024).toFixed(4); // MB

    if (filesize <= 2) {
      $(this)[0].setCustomValidity("");
      $('#profilePictureFeedback').empty();
    } else {
      var msg = "The file is too large";
      $(this)[0].setCustomValidity(msg);
      $('#profilePictureFeedback').text(msg);
    }
  });
});

function checkAvailability(inputID) {
  $.ajax({
    url: '../ajax/_check-availability.php',
    type: 'POST',
    data: inputID + '=' + $('#'+inputID).val(),
    dataType: 'json',
    success: function(response) {
      console.log(response);
      if (response['isAvailable'] === false) {
        var msg = 'This is already taken.';
        $('#'+inputID)[0].setCustomValidity(msg);

        $('#'+inputID+'Feedback').text(msg);
      } else {
        $('#'+inputID)[0].setCustomValidity('');

        $('#'+inputID+'Feedback').empty();
      }
    },
    error: function() {}
  });
}