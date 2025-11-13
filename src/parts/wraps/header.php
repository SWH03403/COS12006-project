<?php
$main_routes = [
	'/' => 'Home',
	'/jobs' => 'Listings',
	'/apply' => 'Application',
	'/about' => 'About',
];
if (Session::has_user()) {
	$session_routes['/session/logout'] = 'Log out';
} else {
	$session_routes['/session/login'] = 'Log in';
	$session_routes['/session/signup'] = 'Sign up';
} ?>
<header class="flex">
	<nav id="global-navigation" class="fill flex">
		<ul class="fill flex flex-o">
			<?php render_links($main_routes) ?>
			<li class="fill"></li>
			<?php render_links($session_routes) ?>
		</ul>
	</nav>
</header>
