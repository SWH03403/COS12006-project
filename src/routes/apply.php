<?php
Session::require_user();
if (is_null(Session::user()->applicant())) { Router::redirect('apply/edit'); }

render_page(fn() => render('apply'),
	title: 'Application Submission',
	style: 'apply',
);
