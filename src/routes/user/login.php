<?php
Session::require_no_user();

$errors = [];
if (Request::is_post()) {
	$email = Request::param('email');
	$pass = Request::param('pass', false);

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($email) > 30) { $errors[] = 'Email is too long'; }
	if (!empty($errors)) { goto end_post; }

	if (is_null(User::login($email, $pass))) { $errors[] = 'Invalid credentials'; }
	else { Router::return(); }
}
end_post:

render_page(fn() => render('forms/auth_user'),
	title: 'Login',
	errors: $errors,
);
