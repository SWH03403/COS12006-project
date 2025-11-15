<?php
function input_id(): string {
	global $_input_first, $_input_counter;
	$_input_first = is_null($_input_first);
	$_input_counter = is_null($_input_counter)? 0 : $_input_counter;
	return 'input-auto-' . (++$_input_counter);
}

function render(string $component, ...$data) {
	global $_g_data;
	if (empty($data)) { $data = $_g_data; }
	extract($data, EXTR_PREFIX_ALL, 'arg_');
	require Dirs::COMPONENTS . "/$component.php";
}

function render_page(string $root, ...$data) {
	global $_g_data; $_g_data = $data;

	render('wraps/top');
	render('root');
	render('wraps/bottom');
}
