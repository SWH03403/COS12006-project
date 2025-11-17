<?php
class Database {
	private static ?self $instance = null;

	public static function get(): self { return (self::$instance = self::$instance ?? new self()); }

	private function __construct(public SQLite3 $inner = new SQLite3(DATABASE_URL)) {}
	public function __destruct() { $this->inner->close(); }

	public function query_unsafe(string $stmt): bool {
		return $this->inner->query($stmt) !== false;
	}

	public function query(string $stmt, array $args = []): ?array {
		$query = $this->inner->prepare($stmt);
		foreach ($args as $idx => $arg) {
			if (is_bool($arg)) { $arg = (int)$arg; }
			$type = match (gettype($arg)) {
				'NULL' => SQLITE3_NULL,
				'double' => SQLITE3_FLOAT,
				'integer' => SQLITE3_INTEGER,
				'string' => SQLITE3_TEXT,
				default => throw new Exception('Unhandled type: ' . gettype($arg)),
			};
			if (!$query->bindValue($idx + 1, $arg, $type)) { return null; }
		}
		$result = $query->execute();
		if ($result === false) { return null; }
		if (!str_starts_with($stmt, 'SELECT')) { return []; }
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) { $rows[] = $row; }
		return $rows ?? [];
	}

	public function last_id(): int { return $this->inner->lastInsertRowID(); }
}
