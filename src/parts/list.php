<?php $depth = $D['depth'] ?? 1; ?>
<?= "<h$depth>" ?><?= $D[0] ?? $D['title'] ?><?= "</h$depth>" ?>
<ul class="flex-y">
	<?php foreach (($D[1] ?? $D['items'] ) as $item) {
		echo '<li>';
		if (is_string($item)) { echo $item; }
		elseif (is_array($item)) {
			$title = $item['title'];
			unset($item['title']);
			render('list', $title, $item, depth: $depth + 1);
		}
		echo '</li>';
	} ?>
</ul>
