<?php
$db = Database::get();
if (!Migration::run_all($db)) {
	echo 'Error while applying migrations!' . PHP_EOL;
	exit(1);
}
