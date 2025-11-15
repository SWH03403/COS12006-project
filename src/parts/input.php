<?php
$label = $D[0] ?? $D['label'];
$name = $D[1] ?? $D['name'];
$type = $D[2] ?? $D['type'] ?? 'text';
$persist = $D['persist'] ?? ($type !== 'password');
$default = $D['default'] ?? null;
$required = $D['required'] ?? true;
$placeholder = $D['placeholder'] ?? null;

$value = (Request::is_post() && $persist)? Request::param($name) : null;
$value = is_null($value)? $default : $value;
$value = is_null($value)? '' : ' value="' . html_sanitize($value) . '"';

global $_input_first;
$id = input_id();
$focus = $_input_first? ' autofocus' : '';
$required = $required? ' required' : '';
$placeholder = is_null($placeholder)? '' : " placeholder=\"$placeholder\"";

echo <<<TEXT
	<div class="flex">
		<label for="$id">$label</label>
		<input id="$id" class="fill" type="$type" name="$name"$value$placeholder$required$focus>
	</div>
TEXT;
?>
