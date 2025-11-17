<?php
$msg_code = Request::param('msg') ?? null;
$msg = match ($msg_code) {
	'choose_first' => 'You need to choose a job here first before applying for it.',
	'invalid' => 'The job you have selected is not valid, or it does not exist!',
	'success' => 'Your application is successfully submitted! Please wait for our management team to
		review it.',
	default => null,
};

render_page(function() use (&$msg) {
	$sections = JobSection::all();
	echo '<aside id="category-navigation" class="flex-y box">';
	if (!is_null($msg)) { echo "<p>$msg</p>"; }
	echo '<h1>Jump to</h1><ul>';
	foreach ($sections as $s) {
		$empty = $s->is_empty()? ' class="empty"' : "";
		$cate = $s->category;
		echo "<li$empty><a href=\"#{$cate->section_id()}\">{$cate->name}</a></li>";
	}
	echo '</ul><p class="minor">Click on a job listing to expand/collapse its details</p></aside>';
	echo '<div id="listing-categories" class="fill flex-y">';
	foreach ($sections as $s) { render('jobs/section', $s); }
	echo '</div>';
},
	title: 'Jobs Listing',
	style: 'listing',
);
