<?php
Session::require_user();
if (is_null(Session::user()->applicant())) { Router::redirect('apply/edit'); }

function to_list(string $type): never { Router::redirect('jobs?msg=' . $type); }
$job_id = Request::param('id');
if (is_null($job_id)) { to_list('choose_first'); }
$job = Job::get($job_id);
if (is_null($job)) { to_list('invalid'); }

enum TimePlan: string {
	case FullTime = 'full';
	case PartTime = 'part';
	case Temporary = 'temp';
}

$errors = [];
if (Request::is_post()) {
	$salary = Request::param('desired-salary');
	$exp = Request::param('experience');
	$start = Request::param('start-date');
	$time = Request::param('time');
	$opts = [];

	foreach ($job->reqs->opts as $idx => $opt) {
		$accept = Request::param("affirm-opt-$idx") ?? 'off';
		$opts[$idx] = parse_bool($accept);
	}

	$salary = str_replace(',', '', $salary);
	if (!ctype_digit($salary)) { $errors[] = 'Salary must be a number'; }
	else {
		$salary = intval($salary);
		if (!new Range($job->salary->min, $job->salary->max)->contains($salary))
			{ $errors[] = 'Salary must be in specified range'; }
	}
	if (!ctype_digit($exp)) { $errors[] = 'Experience must be a number'; }
	else {
		$exp = intval($exp);
		if (!$job->experience->contains($exp))
			{ $errors[] = 'Years of experience must be in specified range'; }
	}
	$dt = DateTimeImmutable::createFromFormat(DATE_FORMAT, $start);
	if ($dt === false) { $errors[] = 'Invalid employment start date'; }
	if (is_null(TimePlan::tryFrom($time))) { $errors[] = 'Invalid time plan'; }
	if (!empty($errors)) { goto end_post; }

	$db = Database::get();
	$user_id = Session::user()->account()->id;
	$job_id = $job->id;
	$res = $db->query(
		'INSERT INTO eoi(user_id, job_id, start_date, desired_salary, timeplan) VALUES (?, ?, ?, ?, ?)',
		[$user_id, $job_id, $start, $salary, $time],
	);
	if (is_null($res)) { $errors[] = 'Failed to create a new EOI'; goto end_post; }
	$eoi_id = $db->last_id();
	foreach ($opts as $idx => $checked) {
		if (!$checked) { continue; }
		$name = "opt-" . ($idx + 1);
		$res = $db->query('INSERT INTO eoi_accept(id, name) VALUES (?, ?)', [$eoi_id, $name]);
		if (is_null($res)) { $errors[] = 'Failed to create a new EOI'; goto end_post; }
	}
	to_list('success');
}
end_post:

render_page(function() use (&$job, &$errors) {
	$applicant = Session::user()?->applicant();

	echo '<div class="fill flex-y">';
	render('boxlink', function() use (&$job) {
		$name = html_sanitize($job->name);
		echo <<<TEXT
		<div class="info-company">$name</div>
		<div class="flex">
			by <span class="important space">$job->company</span>
			<span class="fill"></span>
			<span class="important">$job->id</span>
		</div>
		<div>in <span class="important space">$job->location</span></div>
		<h3>Mandatory Qualifications</h3><ul>
		TEXT;
		foreach ($job->reqs->must as $name => $text) {
			echo '<li class="info-req-' . $name . '">' . html_sanitize($text) . '</li>';
		}
		echo '</ul>';
	}, 'Job Info', '/jobs', 'Change', id: 'job-info');
	render('profile', $applicant);
	echo '</div>';

	echo <<<'TEXT'
	<div class="flex-y">
	<section id="application-header" class="flex-y flex-o">
		<h1>Application Submission</h1>
		<p>To apply for your selected job, please fill the following form.<p>
	</section>
	TEXT;
	render('errors', $errors);
	echo '<form id="application-form" class="flex-y box" method="post" enctype="multipart/form-data">';

	$salary_range = $job->salary->min	. ' ~ ' . $job->salary->max;
	$salary_cur = $job->salary->currency . ' / year';
	$exp_range = $job->experience->begin . ' ~ ' . $job->experience->end;
	$start_date_msg = 'When are you available to start in case you are selected for employment?';
	$affirm_msg = 'I affirm that I possess all mandatory qualifications listed in the job description.';
	render('input', 'Desired Salary', placeholder: $salary_range, suffix: $salary_cur);
	render('input', 'Experience', placeholder: $exp_range, suffix: 'years');
	render('input', $start_date_msg, 'start-date', type: 'date', vertical: true);
	render('input/radio', 'Time', options: [
		'full' => 'Full-time',
		'part' => 'Part-time',
		'temp' => 'Temporary',
	]);
	echo '<h2>Qualifications</h2>';
	render('input/check', $affirm_msg, 'affirm', required: true);
	if (!empty($job->reqs->opts)) { echo '<h3>Optional</h3>'; }
	foreach ($job->reqs->opts as $idx => $opt) {
		render('input/check', $opt.'.', "affirm-opt-$idx");
	}
	render('input', 'Additional supporting documents (resume, certificates, e.t.c.)', 'documents',
		type: 'file',
		vertical: true,
		required: false,
	);
	render('input/hidden', 'id', $job->id);
	render('input/csrf');
	render('input/submit');

	echo '</form></div>';
},
	title: 'Application Submission',
	style: 'apply',
);
