<?php
class Database {
	private static ?self $instance = null;

	public static function get(): self {
		if (!is_null(self::$instance)) { return self::$instance; }
		self::$instance = new self();
		Migration::run_all(self::$instance);
		return self::$instance;
	}

	private function __construct(
		private SQLite3 $conn = new SQLite3(DATABASE_URL),
	) {}
	public function __destruct() { $this->conn->close(); }

	public function query(string $stmt, array $args = []): ?array {
		$query = $this->conn->prepare($stmt);
		foreach ($args as $idx => $arg) {
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
		$rows = [];
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) { array_push($rows, $row); }
		return $rows;
	}
}
