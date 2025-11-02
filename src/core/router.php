<?php
class Request {
	public static function path(): string {
		$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
		$path = trim($path, '/');
		return preg_replace(':/+:', '/', $path);
	}
	public static function method(): string { return $_SERVER['REQUEST_METHOD']; }
	public static function is_post(): bool { return self::method() == 'POST'; }

	public static function header(string $key): ?string { return $_SERVER["HTTP_$key"] ?? null; }

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
	private static function code(int $code, bool $msg = true): never {
		http_response_code($code);
		if ($msg) { render("status/$code"); }
		exit;
	}

	public static function not_modified(): never { self::code(304, false); }
	public static function not_found(): never { self::code(404); }
	public static function internal_error(): never { self::code(500); }
}

class Router {
	private const DEFAULT = 'root';
	private const STREAM_BLOCKSIZE = 4096;
	private const CONTENT_TYPES = [
		'css' => 'text/css',
	];

	private static function sniff_mime(string $file): string {
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$mime = self::CONTENT_TYPES[$ext] ?? null;
		if (!is_null($mime)) { return $mime; }

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $file);
		finfo_close($finfo);
		return $mime;
	}
	private static function stream_asset(string $path) {
		$file = ASSETS_DIR . $path;
		if (!is_readable($file)) { return; }
		$fd = fopen($file, 'rb');
		if ($fd === false) { Catcher::internal_error(); }

		// Check if client's cache is valid
		$etag = md5_file($file);
		if (Request::header('IF_NONE_MATCH') === $etag) { Catcher::not_modified(); }

		// Response with file metadata
		$mime = self::sniff_mime($file);
		$size = filesize($file);
		header("Cache-Control: public, max-age=3600");
		header("Content-Length: $size");
		header("Content-Type: $mime");
		header("ETag: $etag");

		// Print file content as chunks.
		while (!feof($fd)) {
			echo fread($fd, self::STREAM_BLOCKSIZE);
			if (ob_get_level() > 0) { ob_flush(); }
			flush();
		}
		fclose($fd);

		exit;
	}
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
		if (str_starts_with($path, 'static/')) {
			$asset_path = substr($path, strpos($path, '/'));
			self::stream_asset($asset_path);
		}
		self::load_page($path);
		Catcher::not_found();
	}
}
