<?php
class User {
	private const KEY = 'user';
	private const KEY_ID = 'user_id';
	private const KEY_AUTH = 'user_auth';

	private function __construct (private string $email) {}

	public static function register(
		string $email,
		#[SensitiveParameter] string $pass,
		string $display,
	): bool {
		$db = Database::get();
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$query = 'INSERT INTO user(email, hash, display) VALUES (?, ?, ?)';
		$res = $db->query($query, [$email, $hash, $display]);
		return !is_null($res);
	}

	public function authenticate(#[SensitiveParameter] string $pass): bool {
		$db = Database::get();
		$row = $db->query('SELECT hash FROM user WHERE email = ?', [$this->email])[0] ?? [];
		$hash = $row['hash'] ?? null;
		if (is_null($hash)) { return false; }
		return password_verify($pass, $hash);
	}
	public static function login(string $email, #[SensitiveParameter] string $pass): ?self {
		$user = new self($email); // could be non-existent
		if (!$user->authenticate($pass)) { return null; }
		Session::force_new(); // remove userless session
		Session::set(self::KEY, $user->email);
		return $user;
	}
	public function logout() { Session::reset(); }

	// NOTE: Hidden method, use `Session::user` instead
	public static function _from_session(): ?self {
		$email = Session::get(self::KEY);
		return $email? new self($email) : null;
	}

	public function id(): int {
		$id = Session::get(self::KEY_ID);
		if (!is_null($id)) { return $id; }
		$db = Database::get();
		$id = $db->query('SELECT id FROM user WHERE email = ?', [$this->email])[0]['id'];
		Session::set(self::KEY_ID, $id);
		return $id;
	}
	public function is_manager(): bool {
		$mgr = Session::get(self::KEY_AUTH);
		if (!is_null($mgr)) { return $mgr; }
		$db = Database::get();
		$mgr = !empty($db->query('SELECT 1 FROM user_manager WHERE id = ?', [$this->id()]));
		Session::set(self::KEY_AUTH, $mgr);
		return $mgr;
	}
}
