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

function render_page(array|callable|string $content, array $g_data = []) {
	global $data;
	$data = $g_data;

	render('wraps/top');
	if (is_string($content)) { echo "$content"; }
	elseif (is_array($content)) { foreach ($content as $c) { render($c); }}
	else { $content(); }
	render('wraps/bottom');
}
