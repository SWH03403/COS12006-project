<?php
class Migration {
	private const TABLE = '__migrations';

	public static function run_all(Database $db): bool {
		$db->query('CREATE TABLE IF NOT EXISTS ' . self::TABLE . '(
			idx INTEGER PRIMARY KEY
		) WITHOUT ROWID;');
		$last = $db->query('SELECT MAX(idx) FROM ' . self::TABLE)[0]['MAX(idx)'] ?? null;
		$next = is_null($last)? 0 : ($last + 1);

		foreach (range($next, 9999) as $idx) {
			$base = str_pad("$idx", 4, "0", STR_PAD_LEFT) . '.sql';
			$file = Dirs::MIGRATIONS . "/$base";

			if (!is_readable($file)) { break; }
			echo "Applying $base\n";

			$data = file_get_contents($file);
			foreach (explode(';', $data) as $stmt) {
				$stmt = trim($stmt);
				if (empty($stmt)) { continue; }
				$res = $db->query("$stmt;");
				if (is_null($res)) { return false; }
			}
			$db->query('INSERT INTO ' . self::TABLE . ' VALUES (?)', [$idx]);
			if (is_null($res)) { return false; }
		}

		return true;
	}
}
