$(document).ready(function() {

  // CREATE EXAM PAGE

  $("fieldset:not(:first-child)").hide();

  $("fieldset [data-direction='next']").on('click', function() {
    $(this).parent().hide().next().show();
  });

  function createQuestionGroup(optionGroupContent, formGroupContent, i) {
    var marks = `<div class="form-group form-row">
      <label for="mark" class="col-sm-1 col-form-label">Mark </label>
      <div class="col-sm-2">
        <input type="number" class="form-control" name="mark" id="mark" step="0.1" required>
      </div>
    </div>`;
    $questionGroup = $('<div></div>').addClass('question-group mb-4').append(
      $('<div></div>').addClass('form-group').append(
        $('<label></label>').addClass('h5').prop({ for : 'question' }).text('Question ' + i),
        formGroupContent,
        $('<textarea></textarea>').addClass('form-control mt-1').prop({ id : 'question', name : 'question', required : true })
      ),
      $('<div></div>').addClass('option-group').append(optionGroupContent),
      marks
    );

    $questionGroup.find('*').each(function() {
      if ($(this).prop('id')) { $(this).prop({ id : $(this).prop('id')+i }); }
      if ($(this).prop('name')) { $(this).prop({ name : $(this).prop('name')+i }); }
      if ($(this).prop('for')) { $(this).prop({ for : $(this).prop('for')+i }); }
    });

    return $questionGroup;
  }

  // First 'next' button
  $("#create1 [data-direction='next']").on('click', function() {

    $('#createExamTitle').text('Add ' + $('#examType option:selected').text() + ' Questions');

    var optionGroupContent = '', formGroupContent = '';

    switch ($('#examType').val()) {
      // Show options for multi-choice
      case '1':

        ['A','B','C','D'].forEach(function(opt) {
          optionGroupContent += (
            `<div class="form-group form-row">
              <label for="option` + opt + `" class="col-sm-1 col-form-label">Option ` + opt + `</label>
              <div class="col-sm-11">
                <input type="text" class="form-control" name="option` + opt + `" id="option` + opt + `" required>
              </div>
            </div>`
          )
        });

        optionGroupContent += (
          `<div class="form-group form-row">
            <label for="correctOption" class="col-sm-1 col-form-label">The correct option is </label>
            <div class="col-sm-2">
              <select class="custom-select" name="correctOption" id="correctOption" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
          </div>`
        )

        break;

      // Show help text for fill in
      case '2':

        formGroupContent += (
          `<small id="questionHelp" class="form-text mt-0 text-muted">
            Use three underscores (i.e. '___') to indicate the blanks.
          </small>`
        );

        break;

      // Leave as is for theory
      default:
        break;
    }

    for (var i = 1; i <= $('#noOfQuestions').val(); i++) {
      if (i == 1)
      $('#createQuestion').append(createQuestionGroup(optionGroupContent, formGroupContent, i));
      else
      $('#createQuestion').append(createQuestionGroup(optionGroupContent, '', i));
    }

  });

  // Second 'next' button
  $("#create2 [data-direction='next']").on('click', function() {
    $('#createExamTitle').text('Invite students to take the exam');
  })

  var inviteeCount = 0;
  $('#inviteesList').hide();

  // Invite
  $("#inviteButton").on('click', function() {
    inviteeCount++;
    $('#inviteesList').show();
    $('#inviteesList .list-group').append(
      `<li class="list-group-item py-1">
        <input type="text" readonly class="form-control-plaintext"
        name="invitee` + inviteeCount + `" value="` + $('#inviteByEmail').val() + `">
      </li>`);
    $('#inviteByEmail').val('');
  })

});