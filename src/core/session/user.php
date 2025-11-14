<?php
class User {
	private const KEY = 'user';
	private const KEY_INFO = 'user_account';

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

	public function account(): Account {
		$info = Session::get(self::KEY_INFO);
		if (!is_null($info)) { return $info; }
		$info = Account::_from_user($this->email);
		Session::set(self::KEY_INFO, $info);
		return $info;
 	}
	public function applicant(): ?Applicant { return Applicant::_from_user($this); }
	public function clear_account_cache() { Session::pop(self::KEY_INFO); }
}
