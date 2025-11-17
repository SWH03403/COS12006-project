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
}, 'Applicant Info', '/apply/edit', $cmd, id: 'applicant-info');
