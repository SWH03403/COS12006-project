<?php
Session::require_no_user();

$errors = [];
if (Request::is_post()) {
	$email = Request::param('email');
	$pass = Request::param('password', false);

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($email) > 30) { $errors[] = 'Email is too long'; }
	if (!empty($errors)) { goto end_post; }

	if (is_null(User::login($email, $pass))) { $errors[] = 'Invalid credentials'; }
	else { Router::return(); }
}
end_post:

render_page(function() use ($errors) {
	echo '<form class="box flex-y flex-o" method="post">';
	render('input', 'Email');
	render('input', 'Password', type: 'password');
	render('input/csrf');
	echo '<button type="submit">Login</button></form>';
	render('errors', $errors);
},
	title: 'Login',
);
