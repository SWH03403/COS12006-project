<?php
Session::require_user();
$user = Session::user();


render_page(function() use ($user) {
	$account = $user->account();
	$applicant = $user->applicant();
	$new = is_null($applicant);
	$row = fn($key, $val) => "<span>$key:</span><span>$val</span>";

	$display = html_sanitize($account->display);
	echo "<h1>Hi, $display</h1>";

	echo <<<'TEXT'
	<article id="account-container" class="box flex-y">
		<div class="flex">
			<h2>Account Info</h2>
			<div class="fill"></div>
			<a class="edit-btn flex-y" href="/user/edit">Edit</a>
		</div>
		<div id="account-info">
	TEXT;
	echo $row('Email', html_sanitize($account->email));
	echo $row('Created', $account->created->format(DATETIME_FORMAT));
	echo $row('Updated', $account->updated->format(DATETIME_FORMAT));
	echo $row('Is manager', $account->is_manager? 'Yes' : 'No');
	echo '</div></article>';

	$cmd = $new? 'Apply' : 'Edit';
	echo <<<TEXT
	<article id="applicant-container" class="box flex-y">
		<div class="flex">
			<h2>Applicant Info</h1>
			<div class="fill"></div>
			<a class="edit-btn flex-y" href="/apply/edit">$cmd</a>
		</div>
	TEXT;
	echo $new? <<<'TEXT'
		<span id="no-applicant-message">
			You currently have not created your application profile. To make one, please click the
			<span class="important">"Apply"</span> button above!
		</span>
	TEXT : '<div id="applicant-info"></div>';
	echo '</article>';
},
	title: 'Profile',
	style: 'profile',
);
