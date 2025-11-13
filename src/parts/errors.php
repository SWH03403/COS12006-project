<?php
$messages = $data['messages'] ?? [];
$show_empty = $data['empty'] ?? false;

$show = !empty($messages) || $show_empty;
if ($show) { echo '<ul class="box errors-box flex-y">'; }
foreach ($messages as $msg) { echo '<li>' . "$msg" . '!</li>'; }
if ($show) { echo '</ul>'; }
?>
