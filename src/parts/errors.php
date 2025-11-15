<?php
$messages = $D[0] ?? $D['messages'] ?? [];

$show = !empty($messages);
if ($show) { echo '<ul class="box errors-box flex-y">'; }
foreach ($messages as $msg) { echo '<li>' . "$msg" . '!</li>'; }
if ($show) { echo '</ul>'; }
?>
