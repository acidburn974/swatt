$('#input-username').on('input', function(event) {
  if ($('#input-username').val().length > 0) {
    $('#input-username').parent().addClass('has-success');
    return $('#input-username').parent().removeClass('has-error');
  } else {
    $('#input-username').parent().addClass('has-error');
    return $('#input-username').parent().removeClass('has-success');
  }
});

$('#input-password').on('input', function(event) {
  if ($('#input-password').val().length > 0) {
    $('#input-password').parent().addClass('has-success');
    return $('#input-password').parent().removeClass('has-error');
  } else {
    $('#input-password').parent().addClass('has-error');
    return $('#input-password').parent().removeClass('has-success');
  }
});
