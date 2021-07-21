(function ($) {
  const applicantWrapper = $('#applicant-wrapper');
  const button = $('#has-additional-applicant');

  if (!(button.prop('checked'))) {
    applicantWrapper.hide();
  }

  button.click(function() {
    if ((button.prop('checked'))) {
      applicantWrapper.show();
    } else {
      applicantWrapper.hide();
    }
  });
}(jQuery))
