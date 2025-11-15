<?php $D = $D[0]; ?>
<h1 id="<?= $D['id'] ?>" class="flex box">
	<?= $D['name'] ?>
	<span class="fill"></span>
	<span class="minor"><?= count($D['entries'])?: 'None' ?></span>
</h1>
<div class="flex categorized-listing<?= empty($D['entries'])? ' empty' : '' ?>">
	<?php foreach ($D['entries'] as $entry) { render('jobs/entry', $entry); } ?>
</div>
