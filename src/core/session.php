<?php
class Session {
	private static bool $started = false;

	private static function init() {
		if (self::$started) { return; }
		self::$started = true;
		session_start();
	}

	private static function force_new() {
		self::init();
		session_regenerate_id(true);
	}
	private static function reset() {
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
}

class Csrf {
	private const KEY = 'csrf_token';

	public static function new() { Session::set(self::KEY, bin2hex(random_bytes(32))); }
	public static function get(): ?string { Session::get(self::KEY); }
	public static function check(string $token): bool {
		if (is_null(self::get())) { return false; }
		return Session::pop(self::KEY) === $token;
	}
}

class User {
	private const KEY = 'user';

	private function __construct (
		private string $name,
	) {}
	public static function from_session(): ?self {
		$name = Session::get(self::KEY);
		return $name? new self($name) : null;
	}
	// NOTE: Should be `has_logged_in`, but I'm obsessed with short function names. =~="
	public static function has_login(): bool { return !is_null(self::from_session()); }

	public function authorize(string $pass): bool {
		return false; // TODO: Query database & check hash
	}
	public static function login(string $name, string $pass): ?self {
		$user = new self($name); // could be non-existent.
		if (!$user->authorize($pass)) { return null; }
		return $user;
	}
	public function logout() { Session::reset(); }
}
