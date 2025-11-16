<?php $D = $D[0]; ?>
<h1 id="<?= $D->category->section_id() ?>" class="flex box">
	<?= $D->category->name ?>
	<span class="fill"></span>
	<span class="minor"><?= count($D->entries)?: 'None' ?></span>
</h1>
<div class="flex categorized-listing<?= $D->is_empty()? ' empty' : '' ?>">
	<?php foreach ($D->entries as $item) { render('jobs/entry', $item); } ?>
</div>
