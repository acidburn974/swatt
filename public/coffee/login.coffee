$('#input-username').on 'input', (event) ->
	if $('#input-username').val().length > 0
		$('#input-username').parent().addClass('has-success')
		$('#input-username').parent().removeClass('has-error')
	else
		$('#input-username').parent().addClass('has-error')
		$('#input-username').parent().removeClass('has-success')

$('#input-password').on 'input', (event) ->
	if $('#input-password').val().length > 0
		$('#input-password').parent().addClass('has-success')
		$('#input-password').parent().removeClass('has-error')
	else
		$('#input-password').parent().addClass('has-error')
		$('#input-password').parent().removeClass('has-success')