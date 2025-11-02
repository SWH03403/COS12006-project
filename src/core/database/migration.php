<?php
class Migration {
	public static function run_all(Database $db) {
		$db->query('CREATE TABLE IF NOT EXISTS ' . MIGRATIONS_TABLE . '(
			idx INTEGER PRIMARY KEY
		) WITHOUT ROWID;');
		$last = $db->query('SELECT MAX(idx) FROM ' . MIGRATIONS_TABLE)[0]['MAX(idx)'] ?? null;
		$next = $last? (intval($last) + 1) : 0;

		foreach (range($next, 9999) as $idx) {
			$base = str_pad("$idx", 4, "0", STR_PAD_LEFT);
			$file = MIGRATIONS_DIR . "/$base.sql";

			if (!is_readable($file)) { break; }
			$data = file_get_contents($file);
			foreach (explode(';', $data) as $stmt) {
				$stmt = trim($stmt);
				if (empty($stmt)) { continue; }
				$db->query("$stmt;");
			}
			$db->query('INSERT INTO ' . MIGRATIONS_TABLE . ' VALUES (?)', [$idx]);
		}
	}
}
