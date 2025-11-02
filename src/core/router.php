<?php
class Request {
	public static function uri(): string {
		$path = strtok($_SERVER['REQUEST_URI'], '?');
		return ltrim($path, '/');
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
	public static function catch(int $code): never {
		http_response_code($code);
		render("status/$code.php");
		exit;
	}

	public static function not_found() { self::catch(404); }
}

class Router {
	private const DEFAULT_ROUTE = 'root';

	private static function load_page(string $uri) {
		$root = empty($uri);
		$uri = $root? self::DEFAULT_ROUTE : $uri;
		$path = PAGES_DIR . "/$uri.php";
		if ($root || is_readable($path)) {
			require $path ?? self::DEFAULT_ROUTE;
			exit;
		}
	}

	public static function redirect(string $uri): never {
		if ($uri == self::DEFAULT_ROUTE) { $uri = ''; }
		header("Location: /$uri");
		exit;
	}

	public static function route() {
		$uri = Request::uri();
		self::load_page($uri);
		Catcher::not_found();
	}
}
