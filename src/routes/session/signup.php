<?php
if (Session::has_user()) { Router::return(); }

$dname = null;
$email = null;
$errors = [];
if (Request::is_post()) {
	$dname = Request::param('dname');
	$email = Request::param('email');
	$pass1 = Request::param('pass1', false);
	$pass2 = Request::param('pass2', false);

	if (strlen($dname) > 20) { $errors[] = 'Display name is too long'; }
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) { $errors[] = 'Email is invalid'; }
	if (strlen($email) > 30) { $errors[] = 'Email is too long'; }
	if (strlen($pass1) < 30) { $errors[] = 'Password is too short'; }
	if ($pass1 != $pass2) { $errors[] = 'Password repetition does not match'; }
	if (!empty($errors)) { goto end_post; }

	User::register($email, $pass1, $dname);
	User::login($email, $pass1);
	Router::return();
}
end_post:

render_page(['forms/new_user'], [
	'title' => 'Sign up',
	'dname' => $dname,
	'email' => $email,
	'errors' => $errors,
]);
