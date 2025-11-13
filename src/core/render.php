<?php
function render(string $component, ?array $g_data = null) {
	global $data;
	if (!is_null($g_data)) { $data = $g_data; }
	require Dirs::COMPONENTS . "/$component.php";
}

function render_links(array $routes) {
	$cur = Request::path();
	foreach ($routes as $url => $disp) {
		$is_cur = (str_starts_with($url, '/') && substr($url, 1) === $cur)?
			' class="current-page"' : '';
		echo "<li><a href=\"$url\"$is_cur>$disp</a></li>";
	}
}

$_input_counter = 0;
function render_input(
	string $label,
	string $name,
	string $type = 'text',
	?string $value = null,
	bool $required = true,
) {
	global $_input_counter;
	$id = 'input-auto-' . ($_input_counter += 1);
	$required = $required? ' required' : '';
	$value = is_null($value)? '' : ' value="' . html_sanitize($value) . '"';

	echo <<<TEXT
		<div class="flex">
			<label for="$id">$label</label>
			<input id="$id" class="fill" type="$type" name="$name"$value$required>
		</div>
	TEXT;
}

function render_page(array|callable|string $content, array $g_data = []) {
	global $data;
	$data = $g_data;

	render('wraps/top');
	if (is_string($content)) { echo "$content"; }
	elseif (is_array($content)) { foreach ($content as $c) { render($c); }}
	else { $content(); }
	render('wraps/bottom');
}
