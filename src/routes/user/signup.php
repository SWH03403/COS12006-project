<?php
Session::require_no_user();

$errors = [];
if (Request::is_post()) {
	$dname = Request::param('dname');
	$email = Request::param('email');
	$pass1 = Request::param('pass1', false);
	$pass2 = Request::param('pass2', false);

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($dname) > 20) { $errors[] = 'Display name is too long'; }
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) { $errors[] = 'Email is invalid'; }
	if (strlen($email) > 30) { $errors[] = 'Email is too long'; }
	if (strlen($pass1) < 1) { $errors[] = 'Password is too short'; }
	if ($pass1 != $pass2) { $errors[] = 'Password repetition does not match'; }
	if (!empty($errors)) { goto end_post; }

	if (!User::register($email, $pass1, $dname)) {
		$errors[] = 'Account with email has already existed';
		goto end_post;
	}

	User::login($email, $pass1);
	Router::redirect('user');
}
end_post:

render_page(function() use ($errors) {
	echo '<form class="box flex-y flex-o" method="post">';
	render('input', 'Display Name', 'dname', required: false);
	render('input', 'Email');
	render('input', 'Password', 'pass1', 'password');
	render('input', 'Repeat Password', 'pass2', 'password');
	render('input/csrf');
	echo '<button type="submit">Sign up!</button></form>';
	render('errors', $errors);
},
	title: 'Sign up',
);
