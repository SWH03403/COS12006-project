<?php
Session::require_user();
$user = Session::user();


render_page(function() use ($user) {
	$account = $user->account();
	$applicant = $user->applicant();

	$display = html_sanitize($account->display);
	echo "<h1>Hi, $display</h1>";

	render('boxlink', function() use (&$account) {
		$row = fn($key, $val) => "<span>$key:</span><span>$val</span>";
		echo '<div id="account-info">';
		echo $row('Email', html_sanitize($account->email));
		echo $row('Created', $account->created->format(DATETIME_FORMAT));
		echo $row('Updated', $account->updated->format(DATETIME_FORMAT));
		echo $row('Is manager', $account->is_manager? 'Yes' : 'No');
		echo '</div>';
	}, 'Account Info', '/user/edit', 'Edit', id: 'account-container');
	render('profile', $applicant);
},
	title: 'Profile',
	style: 'profile',
);
