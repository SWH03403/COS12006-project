<!-- PROMPT: give some job categories in the IT departments -->
<aside id="category-navigation" class="flex-y box">
	<ul>
	<?php foreach ($data['sections'] as $section) {
		$empty = empty($section['entries'])? ' class="empty"' : "";
		echo "<li$empty><a href=\"#{$section['id']}\">{$section['name']}</a></li>";
	} ?>
	</ul>
	<p class="minor">Click on a job listing to expand/collapse its details</p>
</aside>
<div id="listing-categories" class="fill flex-y">
	<?php foreach ($data['sections'] as $section) { render('jobs/section', $section); } ?>
</div>
