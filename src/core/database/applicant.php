<?php
enum Gender: string {
	case Male = 'm';
	case Female = 'f';
	case NonBinary = 'x';
	case Other = '?';

	public function label(): string {
		return match($this) {
			self::Male => 'male',
			self::Female => 'female',
			self::NonBinary => 'non-binary',
			self::Other => '?',
		};
	}
}

class Applicant {
	private function __construct(
		public string $first_name,
		public string $last_name,
		public DateTimeImmutable $dob,
		public Gender $gender,
		public bool $can_check_background,
		public bool $is_convict,
		public bool $is_veteran,
		public string $street,
		public string $town,
		public State $state,
		public string $postcode,
		public string $phone,
	) {}

	// NOTE: Hidden method, use `User::applicant` instead
	public static function _from_user(User $user): ?self {
		$db = Database::get();
		$id = $user->account()->id;
		$row = $db->query('SELECT * FROM user_applicant WHERE id = ?', [$id])[0] ?? null;
		if (is_null($row)) { return null; }
		extract($row, EXTR_OVERWRITE); // WARN: Extract SQL row
		$dob = DateTimeImmutable::createFromFormat('Y-m-d', $dob);
		return new self(
			$first_name,
			$last_name,
			$dob,
			Gender::from($gender),
			$can_check_background,
			$is_convict,
			$is_veteran,
			$street,
			$town,
			new State($state),
			$postcode,
			$phone,
		);
	}
}
