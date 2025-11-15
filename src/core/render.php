<?php
function input_id(): string {
	global $_input_first, $_input_counter;
	$_input_first = is_null($_input_first);
	$_input_counter = is_null($_input_counter)? 0 : $_input_counter;
	return 'input-auto-' . (++$_input_counter);
}

function render(string $component, ...$_data) {
	global $_g_data; $D = empty($_data)? $_g_data : $_data;
	require Dirs::COMPONENTS . "/$component.php";
}

function render_page(callable $render_content, ...$_data) {
	global $_g_data; $_g_data = $_data;

	render('wraps/top');
	$render_content();
	render('wraps/bottom');
}
