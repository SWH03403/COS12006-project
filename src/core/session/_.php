<?php
class Session {
	private static bool $started = false;

	private static function init() {
		if (self::$started) { return; }
		self::$started = true;
		session_start();
	}

	public static function force_new() {
		self::init();
		session_regenerate_id(true);
	}
	public static function reset() {
		self::init();
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(), '', 0, '/');
		self::force_new();
	}

	public static function get(string $key): mixed {
		self::init();
		return $_SESSION[$key] ?? null;
	}
	public static function set(string $key, mixed $val) {
		self::init();
		$_SESSION[$key] = $val;
	}

	public static function pop(string $key): mixed {
		$val = self::get($key);
		unset($_SESSION[$key]);
		return $val;
	}

	public static function user(): ?User { return User::_from_session(); }
	public static function has_user(): bool { return !is_null(self::user()); }
}
