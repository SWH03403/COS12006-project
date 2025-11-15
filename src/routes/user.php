<?php
Session::require_user();

$user = Session::user();
$applicant = $user->applicant();

render_page(fn() => render('profile'),
	title: 'Profile',
	style: 'profile',
	user: $user,
	applicant: $applicant,
);
