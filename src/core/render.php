<?php
function input_id(): array {
	global $_input_counter;
	$_input_counter = is_int($_input_counter)? $_input_counter : 0;
	$first = $_input_counter == 0;
	return [$first, 'input-auto-' . (++$_input_counter)];
}

function render(string $component, ...$_data) {
	global $_g_data; $D = empty($_data)? $_g_data : $_data;
	require Dirs::COMPONENTS . "/$component.php";
}

function render_page(?callable $_r = null, ...$_data) {
	global $_g_data; $_g_data = $_data;

	render('wraps/top');
	if (!is_null($_r)) { $_r(); }
	render('wraps/bottom');
}
