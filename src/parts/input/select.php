<?php
$label = $D[0] ?? $D['label'];
$name = $D[1] ?? $D['name'];
$options = $D[2] ?? $D['options'];
$persist = $D['persist'] ?? true;
$required = $D['required'] ?? true;

$selected = (Request::is_post() && $persist)? Request::param($name) : null;
$unselected = is_null(array_find($options, fn($_, $k) => $k === $selected));

$id = input_id();
$required = $required? ' required' : '';

echo <<<TEXT
	<div class="flex">
		<label for="$id">$label</label>
		<select id="$id" class="fill" name="$name"$required>
TEXT;
if ($unselected) { echo '<option value="">(choose one)</option>'; }
foreach ($options as $value => $text) {
	$default = ($value === $selected)? ' selected' : '';
	echo "<option value=\"$value\"$default>$text</option>";
}
echo <<<TEXT
		</select>
	</div>
TEXT;
?>
