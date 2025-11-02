<?php
class Request {
	public static function path(): string {
		$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
		$path = trim($path, '/');
		return preg_replace(':/+:', '/', $path);
	}
	public static function method(): string { return $_SERVER['REQUEST_METHOD']; }
	public static function is_post(): bool { return self::method() == 'POST'; }

	public static function header(string $key): string { return $_SERVER["HTTP_$key"]; }

	public static function param(string $key, bool $trim = true, bool $html = false): ?string {
		$dict = is_post()? $_POST : $_GET;
		$val = $dict[$key] ?? null;
		if (is_null($val)) { return $val; }
		$val = $trim? trim($val) : $val;
		$val = $html? html_sanitize($val) : $val;
		return $val;
	}
}

class Catcher {
	private static function code(int $code): never {
		http_response_code($code);
		render("status/$code");
		exit;
	}

	public static function not_found(): never { self::code(404); }
	public static function internal_error(): never { self::code(500); }
}

class Router {
	private const DEFAULT = 'root';

	private static function load_page(string $path) {
		$root = empty($path);
		$path = $root? self::DEFAULT : $path;
		$path = PAGES_DIR . "/$path.php";
		if ($root || is_readable($path)) {
			require $path ?? self::DEFAULT;
			exit;
		}
	}

	public static function redirect(string $path): never {
		if ($path == self::DEFAULT) { $path = ''; }
		header("Location: /$path");
		exit;
	}

	public static function route() {
		$path = Request::path();
		self::load_page($path);
		Catcher::not_found();
	}
}
