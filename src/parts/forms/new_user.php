<form class="box flex-y flex-o" method="post">
	<?php
	render_input('Display Name', 'dname', value: $data['dname'], required: false);
	render_input('Email', 'email', value: $data['email']);
	render_input('Password', 'pass1', 'password');
	render_input('Repeat Password', 'pass2', 'password');
	?>
	<button type="submit">Sign up!</button>
</form>
<?php render('errors', ['messages' => $data['errors']]); ?>
