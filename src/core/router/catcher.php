<?php
class Catcher {
	private static function code(int $code, ?string $msg = null): never {
		http_response_code($code);
		if (!is_null($msg)) {
			$text = "$code $msg";
			render_page(
				function() { echo "<h1>$text</h1>"; },
				full_title: $text,
			);
		}
		exit;
	}

	public static function not_modified(): never { self::code(304); }
	public static function not_found(): never { self::code(404, 'Not Found'); }
	public static function internal_error(): never { self::code(500, 'Internal Server Error'); }
}
