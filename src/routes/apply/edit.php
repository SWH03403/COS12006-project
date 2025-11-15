<?php
Session::require_user();

$errors = [];
if (Request::is_post()) {
	$first_name = ucfirst(Request::param('first-name'));
	$last_name = ucfirst(Request::param('last-name'));
	$dob = Request::param('dob');
	$gender = Request::param('gender');
	$street = Request::param('street');
	$town = Request::param('town');
	$state = State::from_abbr(Request::param('state'));
	$postcode = Request::param('postcode');
	$phone = Request::param('phone');
	$background = parse_bool(Request::param('background'));
	$felony = parse_bool(Request::param('felony'));
	$veteran = parse_bool(Request::param('veteran'));

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($first_name) > 20) { $errors[] = 'First name is too long'; }
	elseif (empty($first_name)) { $errors[] = 'First name must not be empty'; }
	if (!ctype_alpha($first_name)) { $errors[] = 'First name must contain only letters'; }
	if (strlen($last_name) > 20) { $errors[] = 'Last name is too long'; }
	elseif (empty($last_name)) { $errors[] = 'Last name must not be empty'; }
	if (!ctype_alpha($last_name)) { $errors[] = 'Last name must contain only letters'; }
	$dt = DateTimeImmutable::createFromFormat(DATE_FORMAT, $dob);
	if ($dt === false) { $errors[] = 'Invalid date of birth'; }
	if (is_null(Gender::tryFrom($gender))) { $errors[] = 'Invalid gender option'; }
	if (strlen($street) > 40) { $errors[] = 'Street name is too long'; }
	elseif (empty($street)) { $errors[] = 'Street name must not be empty'; }
	if (!ctype_graph($street)) { $errors[] = 'Street name contains invalid character'; }
	if (strlen($town) > 40) { $errors[] = 'Town name is too long'; }
	elseif (empty($town)) { $errors[] = 'Town name must not be empty'; }
	$pc_valid = strlen($postcode) == 4 && ctype_digit($postcode);
	if (!$pc_valid) { $errors[] = 'Postcode must contain exactly 4 digits'; }
	if (!ctype_graph($town)) { $errors[] = 'Town name contains invalid character'; }
	if (is_null($state)) { $errors[] = 'Invalid Australian state abbreviation'; }
	elseif ($pc_valid && !$state->has_postcode(intval($postcode)))
		{ $errors[] = "Postcode is outside of the selected state's allocated range"; }
	if (strlen($phone) > 12) { $errors[] = 'Phone number is too long'; }
	if (!ctype_digit(str_replace(' ', '', $phone)))
		{ $errors[] = 'Phone number must contain only digits or spaces'; }
	if (is_null($background)) { $errors[] = 'Background check question must be answered'; }
	if (is_null($felony)) { $errors[] = 'Felony question must be answered'; }
	if (is_null($veteran)) { $errors[] = 'Veteran question must be answered'; }
	if (!empty($errors)) { goto end_post; }

	$db = Database::get();
	$id = Session::user()->account()->id;

	$state = $state->abbr();
	$res = $db->query(<<<'TEXT'
		INSERT OR REPLACE INTO user_applicant(
			id, first_name, last_name, dob, gender,
			street, town, state, postcode, phone,
			can_check_background, is_convict, is_veteran
		) VALUES (
			?, ?, ?, ?, ?,
			?, ?, ?, ?, ?,
			?, ?, ?
		)
		TEXT, [
			$id, $first_name, $last_name, $dob, $gender,
			$street, $town, $state, $postcode, $phone,
			$background, $felony, $veteran,
		]);
	if (is_null($res)) { $errors[] = 'Failed to update database with new information'; }
	else { Router::redirect('user'); }
}
end_post:

function render_header(string $text) { echo "<h2>$text</h2>"; }

render_page(function() use ($errors) {
	echo <<<'TEXT'
	<section class="flex-y flex-o">
		<h1>Personal Info Submission</h1>
		<p>
			Before submitting EOIs, you must first provide some information about yourself,
			which will be reflected on <span class="important">all</span> of your future EOIs.
		</p>
		<p>You can always update these data in the <span class="important">Profile</span> page.</p>
	</section>
	TEXT;
	render('errors', $errors);
	echo '<form id="personal-info" class="box flex-y" method="post">';
	render_header('Identity');
	render('input', 'First Name');
	render('input', 'Last Name');
	render('input', 'Date of Birth', 'dob', type: 'date');
	render('input/select', 'Gender', options: [
		'm' => 'Male (he/him)',
		'f' => 'Female (she/her)',
		'x' => 'Non-binary (they/them)',
		'?' => 'Prefer not to say',
	]);

	render_header('Address');
	render('input', 'Street');
	render('input', 'Town');
	render('input/select', 'State', options: State::options());
	render('input', 'Postcode', type: 'number');

	render_header('Contact');
	render('input', 'Phone No.', 'phone');

	render_header('Questions');
	render('input/binary',
		'Are you willing to submit to a background check if selected for employment?',
		'background',
	);
	render('input/binary', 'Have you ever been convicted of a felony?', 'felony');
	render('input/binary', 'Are you a veteran?', 'veteran');
	render('input/csrf');

	echo '<button type="submit">Submit</button></form>';
},
	title: 'Applicant Personal Info',
	style: 'apply_personal',
);
