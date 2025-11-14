<?php
declare(strict_types = 1);

const DATABASE_URL = __DIR__ . '/db.sqlite';
const DATETIME_FORMAT = 'Y-m-d H:i:s';
const DATE_FORMAT = 'Y-m-d';
class Dirs {
	public const ASSETS = __DIR__ . '/assets';
	public const COMPONENTS = __DIR__ . '/src/parts';
	public const CORE = __DIR__ . '/src/core';
	public const MIGRATIONS = __DIR__ . '/migrations';
	public const PAGES = __DIR__ . '/src/routes';

	/*
	 * Thanks, @user2226755!
	 * Source: https://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
	 */
	private static function list(string $dir): array {
		$files = [];
		foreach (scandir($dir) as $name) {
			if ($name == '.' || $name == '..') { continue; }
			$path = "$dir/$name";
			if (is_dir($path)) {
				$files = array_merge($files, self::list($path));
			} else {
				if (!str_ends_with($name, '.php')) { continue; }
				$files[] = $path;
			}
		}
		return $files;
	}

	public static function core_modules(): array { return self::list(self::CORE); }
}

foreach (Dirs::core_modules() as $module) { require $module; }

if (!Migration::run_all(Database::get())) {
	echo 'Error while applying migrations!' . PHP_EOL;
	exit(1);
}
Router::route();
