<?php
Session::require_user();
$user = Session::user();
$account = $user->account();
$check_email = !$account->is_manager;

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
	$id = $account->id;
	$now = new DateTimeImmutable(timezone: new DateTimeZone('UTC'))->format(DATETIME_FORMAT);
	$res = $db->query(
		'UPDATE user SET display = ?, email = ?, updated = ? WHERE id = ?',
		[$display, $email, $now, $id],
	);
	if (is_null($res)) { $errors[] = 'Failed to update account info'; }
	if (!empty($pass_new)) {
		$hash = password_hash($pass_new, PASSWORD_DEFAULT);
		$res = $db->query('UPDATE user SET hash = ? WHERE id = ?', [$hash, $id]);
		if (is_null($res)) { $errors[] = 'Failed to update account password'; }
	}
	if (!empty($errors)) { goto end_post; }

	if ($email === $account->email && empty($pass_new)) {
		$user->clear_account_cache();
		Router::redirect('user');
	} else {
		$user->logout();
		Router::redirect('user/login');
	}
}
end_post:

render_page(function() use ($errors, $account) {
	echo '<form class="box flex-y flex-o" method="post">';
	render('input',
		'Email', 'email',
		default: $account->email,
		required: false,
	);
	render('input',
		'Display Name', 'display',
		default: $account->display,
		required: false,
	);
	render('input',
		'New Password', 'new-pass',
		type: 'password',
		placeholder: '(unchanged)',
		required: false,
	);
	render('input', 'Repeat New Password', 'new-passrep', type: 'password', required: false);
	render('input', 'Current Password', 'pass', type: 'password');
	render('input/csrf');
	echo '<button type="submit">Update</button></form>';
	render('errors', $errors);
},
	title: 'Edit profile',
);
