<form class="box flex-y flex-o" method="post">
	<?php
	render('input', [
		'Email', 'email',
		'default' => $data['account']->email,
		'required' => false,
	]);
	render('input', [
		'Display Name', 'display',
		'default' => $data['account']->display,
		'required' => false,
	]);
	render('input', [
		'New Password', 'new-pass', 'password',
		'placeholder' => '(unchanged)',
		'required' => false,
	]);
	render('input', ['Repeat New Password', 'new-passrep', 'password', 'required' => false]);
	render('input', ['Current Password', 'pass', 'password']);
	?>
	<button type="submit">Update</button>
</form>
<?php render('errors', ['messages' => $data['errors']]); ?>
