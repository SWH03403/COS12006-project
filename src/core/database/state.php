<?php
// List of all Australia states.
class State {
	private static array $ALL = [];
	private static array $NAMES = [];
	private static function init() {
		if (!empty(self::$ALL)) { return; }
		self::$ALL = [
			'ACT' => [new Range(2600, 2618), new Range(2900, 2914)],
			'NSW' => [new Range(1000, 1999), new Range(2000, 2599)],
			'NT'  => [new Range( 800,  899)],
			'QLD' => [new Range(4000, 4999)],
			'SA'  => [new Range(5000, 5999)],
			'TAS' => [new Range(7000, 7999)],
			'VIC' => [new Range(3000, 3999)],
			'WA'  => [new Range(6000, 6999)],
		];
		self::$NAMES = [
			'ACT' => 'Australian Capital Territory',
			'NSW' => 'New South Wales',
			'NT'  => 'Northern Territory',
			'QLD' => 'Queensland',
			'SA'  => 'South Australia',
			'TAS' => 'Tasmania',
			'VIC' => 'Victoria',
			'WA'  => 'Western Australia',
		];
	}
	public function __construct(private string $abbr) {}

	public static function options(): array {
		self::init();
		foreach (self::$NAMES as $abbr => $full) {
			$opts[$abbr] = $abbr . ' (' . $full . ')';
		}
		return $opts;
	}

	public static function from_abbr(string $abbr): ?self {
		self::init();
		if (!isset(self::$ALL[$abbr])) { return null; }
		return new self($abbr);
	}

	public function abbr(): string { return $this->abbr; }
	public function full(): string {
		self::init();
		return self::$NAMES[$this->abbr];
	}

	public function has_postcode(int $code): bool {
		foreach (self::$ALL[$this->abbr] as $range) {
			if ($range->contains($code)) { return true; }
		}
		return false;
	}
}
