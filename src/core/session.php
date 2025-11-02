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

	public static function user(): ?User { return User::_from_session(); }
	public static function has_user(): bool { return !is_null(self::user()); }
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

	private function __construct (private string $name) {}

	public function authenticate(#[SensitiveParameter] string $pass): bool {
		$row = $db->query('SELECT hash FROM user WHERE name = ?', [$this->name])[0] ?? [];
		$hash = $row['hash'] ?? null;
		if (is_null($hash)) { return false; }
		return password_verify($pass, $hash);
	}
	public static function login(string $name, #[SensitiveParameter] string $pass): ?self {
		$user = new self($name); // could be non-existent
		if (!$user->authenticate($pass)) { return null; }
		Session::force_new(); // remove userless session
		Session::set(self::KEY, $user->name);
		return $user;
	}
	public function logout() { Session::reset(); }

	// NOTE: Hidden method, use `Session::user` instead
	public static function _from_session(): ?self {
		$name = Session::get(self::KEY);
		return $name? new self($name) : null;
	}
}
