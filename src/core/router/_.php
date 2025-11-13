<?php
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
		$file = Dirs::ASSETS . $path;
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
		$path = Dirs::PAGES . "/$path.php";
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
	public static function return(): never { self::redirect(self::DEFAULT); }

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
