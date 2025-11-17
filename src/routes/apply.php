<?php
Session::require_user();
if (is_null(Session::user()->applicant())) { Router::redirect('apply/edit'); }

function to_list(string $type): never { Router::redirect('jobs?msg=' . $type); }
$job_id = Request::param('id');
if (is_null($job_id)) { to_list('choose_first'); }
$job = Job::get($job_id);
if (is_null($job)) { to_list('invalid'); }

$errors = [];
if (Request::is_post()) {
}
end_post:

render_page(function() use (&$job, &$errors) {
	$info = Session::user()?->applicant();

	echo '<div class="fill flex-y">';
	render('boxlink', function() {

	}, 'Job Info', '/jobs', 'Change');
	render('boxlink', function() {

	}, 'Applicant Info', '/apply/edit', 'Edit');
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
