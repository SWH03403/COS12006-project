<?php
$content = $D[0] ?? null;
$title = $D[1] ?? $D['title'];
$url = $D[2] ?? $D['url'] ?? '';
$link = $D[3] ?? $D['link'] ?? 'Link';
$id = $D['id'] ?? null;

$id = is_null($id)? '' : " id=\"$id\"";
?>
<section<?= $id ?> class="box box-linked flex-y">
	<div class="flex flex-o">
		<h2><?= $title ?></h2>
		<span class="fill"></span>
		<a href="<?= $url ?>"><?= $link ?></a>
	</div>
	<?php if (is_callable($content)) { $content(); } ?>
</section>
