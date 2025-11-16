<?php
class JobCategory {
	private function __construct(
		public int $id,
		public string $name,
	) {}

	public static function all(): array {
		$db = Database::get();
		foreach ($db->query('SELECT * FROM job_category') as $row) {
			$categories[] = new self($row['id'], $row['name']);
		}
		return $categories ?? [];
	}

	public function section_id(): string {
		return "category-" . strtolower(str_replace(' ', '-', $this->name));
	}
}

class JobRequirement {
	public array $must = [];
	public array $opts = [];
}

class JobSalary {
	public function __construct(public int $min, public int $max, public string $currency) {}
}

class Job {
	private function __construct(
		public string $id,
		public JobCategory $category,
		public string $company,
		public string $superior,
		public string $name,
		public string $location,
		public JobSalary $salary,
		public string $description,
		public Range $experience,
		public JobRequirement $reqs,
		public DateTimeImmutable $created,
		public DateTimeImmutable $updated,
	) {}

	public static function all(): array {
		$mapped_categories = [];
		foreach (JobCategory::all() as $cat) { $mapped_categories[$cat->id] = $cat; }
		$db = Database::get();
		foreach ($db->query('SELECT * FROM job ORDER BY name') as $row) {
			extract($row, EXTR_OVERWRITE); // WARN: Extract SQL row
			$items[$id] = new self(
				$id,
				$mapped_categories[$category_id],
				$company,
				$superior,
				$name,
				$location,
				new JobSalary($salary_min, $salary_max, $salary_currency),
				$description,
				new Range($exp_min, $exp_max),
				new JobRequirement(),
				new DateTimeImmutable($created, new DateTimeZone('UTC')),
				new DateTimeImmutable($updated, new DateTimeZone('UTC')),
			);
			$row['requirements'] = $reqs[$row['id']] ?? [];
			$cates[$row['category_id']]['entries'][] = $row;
		}
		foreach ($db->query('SELECT * FROM job_requirement') as $row) {
			extract($row, EXTR_OVERWRITE); // WARN: Extract SQL row
			if (str_starts_with($row['name'], 'opt-')) { $items[$id]->reqs->opts[] = $value; }
			else { $items[$id]->reqs->must[$name] = $value; }
		}
		return $items;
	}
}

class JobSection {
	private function __construct(public JobCategory $category, public array $entries = []) {}

	public static function all(): array {
		$sections = [];
		foreach (Job::all() as $item) {
			if (!isset($sections[$item->category->id])) {
				$sections[$item->category->id] = new self($item->category);
			}
			$sections[$item->category->id]->entries[] = $item;
		}
		return $sections;
	}

	public function is_empty(): bool { return empty($this->entries); }
}
