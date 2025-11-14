<?php
class Csrf {
	private const KEY = 'csrf_token';
	public const FORM_FIELD = '_' . self::KEY;

	public static function new(): string {
		$token = bin2hex(random_bytes(32));
		Session::set(self::KEY, $token);
		return $token;
	}
	public static function check(): bool {
		if (is_null(Session::get(self::KEY))) { return false; }
		return Session::pop(self::KEY) === Request::param(self::FORM_FIELD);
	}
}
