<?php
$external_routes = [
	'https://dueordie.atlassian.net/jira/software/projects/WEBTECHPRJ/summary'
		=> 'Project Management',
	'https://github.com/SWH03303/swh03303.github.io' => 'Github Repo',
	'mailto:info@duoordxe.com.au' => 'Contact us',
]; ?>
<footer class="flex flex-o">
	<nav id="external-navigation" class="fill flex">
		<ul class="fill flex flex-o">
			<?php render_links($external_routes) ?>
		</ul>
	</nav>
</footer>
