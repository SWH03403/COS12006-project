<h1 id="<?= $data['id'] ?>" class="flex box">
	<?= $data['name'] ?>
	<span class="fill"></span>
	<span class="minor"><?= count($data['entries'])?: 'None' ?></span>
</h1>
<div class="flex categorized-listing<?= empty($data['entries'])? ' empty' : '' ?>">
	<?php foreach ($data['entries'] as $entry) { render('jobs/entry', $entry); } ?>
</div>
