<?php
render_page(function() {
	$sections = JobSection::all();
	echo '<aside id="category-navigation" class="flex-y box"><ul>';
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
