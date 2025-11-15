<?php $D = $D[0]; ?>
<article class="flex-y flex-o box">
	<div class="flex-y listing-front">
		<h2><?= html_sanitize($D['name']) ?></h2>
		<p class="job-location"><?= $D['location'] ?></p>
		<p class="job-salary">
			<?= $D['salary_min'] ?>
			~
			<?= $D['salary_max'] ?>
			<?= $D['salary_currency'] ?>
			/ year
		</p>
	</div>
	<details class="flex-y employment-details">
		<summary></summary><hr>
		<p class="job-ident"><?= $D['id'] ?></p>
		<p class="job-company"><?= html_sanitize($D['company']) ?></p>
		<p class="job-superior"><?= html_sanitize($D['superior']) ?></p>
		<p class="job-description flex-y"><?= html_sanitize($D['description']) ?></p>
		<div class="job-essentials"></div>
		<ul>
			<li class="job-langs"><?= html_sanitize($D['requirements']['langs']) ?>.</li>
			<li class="job-frameworks"><?= html_sanitize($D['requirements']['tools']) ?>.</li>
			<li class="job-experience"><?= $D['exp_min'] ?> ~ <?= $D['exp_max'] ?> years.</li>
		</ul>
		<div class="job-preferences"></div>
		<ul>
			<?php
			foreach ($D['requirements']['opts'] as $opt) {
				$pref = html_sanitize($opt);
				echo "<li>$pref.</li>";
			}
			?>
		</ul>
		<a class="job-apply-btn" href="/apply?id=<?= $D['id'] ?>"></a>
	</details>
</article>
