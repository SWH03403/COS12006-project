<?php
$db = Database::get();

foreach ($db->query('SELECT * FROM job_requirement') as $row) {
	$entry = &$reqs[$row['id']];
	$opts = &$entry['opts'];
	if (str_starts_with($row['name'], 'opt-')) { $opts[] = $row['value']; continue; }
	$entry[$row['name']] = $row['value'];
}
foreach ($db->query('SELECT * FROM job_category') as $row) {
	$entry = &$cates[$row['id']];
	$entry['id'] = "category-" . strtolower(str_replace(' ', '-', $row['name']));
	$entry['name'] = $row['name'];
	$entry['entries'] = [];
}
foreach ($db->query('SELECT * FROM job ORDER BY name') as $row) {
	$row['requirements'] = $reqs[$row['id']] ?? [];
	$cates[$row['category_id']]['entries'][] = $row;
}

// Move empty sections to end of list
foreach ($cates as $section) {
	if (empty($section['entries'])) { $empties[] = $section; } else { $sections[] = $section; }
}
$sections = array_merge($sections, $empties);

render_page(fn() => render('listing'),
	title: 'Jobs Listing',
	style: 'listing',
	sections: $sections,
);
