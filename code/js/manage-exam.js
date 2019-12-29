$('document').ready(function() {

  // Close exam from manage exam index page, on close button click
  $('#openExams .close-exam-btn').on('click', function() {
    var examCard = $(this).parents('.card');
    var examID = examCard.data('exam-id');
    closeExam( examID, moveClosedExam, [examCard] );
  });

  // Close exam from manage exam exam page, on close button click
  $('#examHeader .close-exam-btn').on('click', function() {
    var examHeader = $(this).parents('#examHeader');
    var examID = examHeader.find('input').val();
    closeExam( examID, changeExamHeaderStatus, [examHeader] );
  });

  // Change a toggle icon when clicked
  $('[data-toggle="collapse"]').on('click', function() {
    $(this).children('.fas').toggleClass('fa-angle-down fa-angle-up');
  });

});

// Send by AJAX to server to close exam, when a close button is clicked
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

// Move examCard to closed-exams section
function moveClosedExam(examCard) {

  // Move the exam to #closedExam section
  examCard.detach().prependTo('#closedExams > .list-unstyled');

  // Remove the close button
  examCard.children('.close-exam-btn').remove();
}

// Change the exam header status to closed
function changeExamHeaderStatus(examHeader) {
  examHeader.find('#status').text('Closed');
  // console.log(examHeader.children())

  // Remove the close button
  examHeader.find('.close-exam-btn').remove();
}