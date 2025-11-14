<?php
$label = $data[0] ?? $data['label'];
$name = $data[1] ?? $data['name'];
$type = $data[2] ?? $data['type'] ?? 'text';
$persist = $data['persist'] ?? ($type == 'text');
$default = $data['default'] ?? null;
$required = $data['required'] ?? true;
$placeholder = $data['placeholder'] ?? null;

$value = (Request::is_post() && $persist)? Request::param($name) : null;
$value = is_null($value)? $default : $value;
$value = is_null($value)? '' : ' value="' . html_sanitize($value) . '"';

global $_input_counter;
$_input_counter = is_null($_input_counter)? 0 : $_input_counter;
$id = 'input-auto-' . ($_input_counter += 1);
$focus = ($_input_counter == 1)? ' autofocus' : '';
$required = $required? ' required' : '';
$placeholder = is_null($placeholder)? '' : " placeholder=\"$placeholder\"";

echo <<<TEXT
	<div class="flex">
		<label for="$id">$label</label>
		<input id="$id" class="fill" type="$type" name="$name"$value$placeholder$required$focus>
	</div>
TEXT;
?>
