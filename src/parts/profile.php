<?php
$applicant = $D[0] ?? $D['info'] ?? null;
$cmd = is_null($applicant)? 'Apply' : 'Edit';
render('boxlink', function() use (&$applicant) {
	if (is_null($applicant)) { echo <<<'TEXT'
		<span id="no-applicant-message">
			You currently have not created your application profile. To make one, please click the
			<span class="important">"Apply"</span> button above!
		</span>
		TEXT;
		return;
	}

	$gender = $applicant->gender->label();
	$dob = $applicant->dob->format('j/n/Y');
	$state = $applicant->state->full();
	echo <<<TEXT
	<div class="flex info-basic">
		<span class="important">$applicant->first_name $applicant->last_name</span>
		<span class="info-gender">($gender)</span>
		<span class="fill"></span>
		<span class="info-dob">$dob</span>
	</div>
	<ul>
		<li class="info-address">
			Lives on <span class="important">$applicant->street</span> Street
			in <span class="important">$applicant->town</span> Town,
			in the state of
			<span class="important">$state</span> ($applicant->postcode).
		</li>
		<li class="info-contact">
			Can be reached at <span class="important">$applicant->phone</span>.
		</li>
	</ul>
	TEXT;
}, 'Applicant Info', '/apply/edit', $cmd, id: 'applicant-info');
