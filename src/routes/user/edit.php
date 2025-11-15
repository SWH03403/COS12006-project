<?php
if (!Session::has_user()) { Router::return(); }
$user = Session::user();
$check_email = !$user->account()->is_manager;

$errors = [];
if (Request::is_post()) {
	$display = Request::param('display');
	$email = Request::param('email');
	$pass_old = Request::param('pass', false);
	$pass_new = Request::param('new-pass', false);
	$pass_rep = Request::param('new-passrep', false);

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($display) > 20) { $errors[] = 'Display name is too long'; }
	if ($check_email && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$errors[] = 'Email is invalid';
	}
	if (strlen($email) > 30) { $errors[] = 'Email is too long'; }
	if (!empty($pass_new)) {
		if (strlen($pass_new) < 1) { $errors[] = 'New password is too short'; }
		if ($pass_new != $pass_rep) { $errors[] = 'Password repetition does not match'; }
	}
	if (!empty($errors)) { goto end_post; }
	if (!$user->authenticate($pass_old)) { $errors[] = 'Incorrect password'; goto end_post; }

	$db = Database::get();
	$id = $user->account()->id;
	$now = new DateTimeImmutable(timezone: new DateTimeZone('UTC'))->format(DATETIME_FORMAT);
	$res = $db->query(
		'UPDATE user SET display = ?, email = ?, updated = ? WHERE id = ?',
		[$display, $email, $now, $id],
	);
	if (is_null($res)) { $errors[] = 'Failed to update account info'; }
	if (!empty($pass_new)) {
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$res = $db->query('UPDATE user SET hash = ? WHERE id = ?', [$hash, $id]);
		if (is_null($res)) { $errors[] = 'Failed to update account password'; }
	}
	if (!empty($errors)) { goto end_post; }

	if ($email === $user->account()->email && empty($pass_new)) {
		$user->clear_account_cache();
		Router::redirect('user');
	} else {
		$user->logout();
		Router::redirect('user/login');
	}
}
end_post:

render_page(['forms/edit_user'], [
	'title' => 'Edit profile',
	'account' => $user->account(),
	'errors' => $errors,
]);
