$('document').ready(function() {

  // Send by AJAX to server to close exam, when a close button is clicked
  $('#openExams .close-exam-btn').on('click', function() {
    closeExam( $(this).parents('.card').data('exam-id'), moveClosedExam, [$(this)] );
  });


});

// Close exam with examID on database
// Callback is a function specifying what to do if the exam has been closed
// Params is an array of parameters to be passed to callback
function closeExam(examID, callback, params) {
  $.ajax({
    url: 'close-exam.php',
    method: 'post',
    data: "examID=" + examID,
    success: function(response) {
      if (response) {
        callback(...params);
      }
    },
    error: function() {}
  });
}

// Move exam to which closeBtn belongs to closed section
function moveClosedExam(closeBtn) {

  // Move the exam to #closedExam section
  closeBtn.parents('.card').detach().prependTo('#closedExams > .list-unstyled');

  // Remove the close button
  closeBtn.remove();
}