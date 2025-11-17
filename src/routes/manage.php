<?php
Session::require_user(true);

enum Filter: string {
	case JobId = 'job_id';
	case FirstName = 'first_name';
	case LastName = 'last_name';
	case FullName = 'full_name';

	public function column(): string {
		return match ($this) {
			self::JobId => 'job.id',
			self::FirstName => 'user_applicant.first_name',
			self::LastName => 'user_applicant.last_name',
			self::FullName => "user_applicant.first_name || ' ' || user_applicant.last_name",
		};
	}
}
enum Order: string {
	case Id = 'id';
	case JobId = 'job_id';
	case FirstName = 'first_name';
	case LastName = 'last_name';
	case Salary = 'desired_salary';
	case Experience = 'experience';
	case Start = 'start_date';
	case Create = 'created';
	case Update = 'updated';

	public function column(): string {
		return match ($this) {
			self::Id => 'eoi.id',
			self::JobId => 'job.id',
			self::FirstName => 'user_applicant.first_name',
			self::LastName => 'user_applicant.last_name',
			self::Salary => 'eoi.desired_salary',
			self::Experience => 'eoi.experience',
			self::Start => 'eoi.start_date',
			self::Create => 'eoi.created',
			self::Update => 'eoi.updated',
		};
	}
}

// Read search request parameters
$query = Request::param('query') ?? '';
$filter = Filter::tryFrom(Request::param('filter')) ?? Filter::JobId;
$order = Order::tryFrom(Request::param('order')) ?? Order::Id;
$ascending = parse_bool(Request::param('ascending') ?? '') ?? false;

// Prepare database queries with predefined strings
$filter = $filter->column();
$order = $order->column();
$dir = $ascending? 'ASC' : 'DESC';

$db = Database::get();
$records = $db->query(<<<TEXT
SELECT * FROM eoi
INNER JOIN job ON eoi.job_id = job.id
INNER JOIN user_applicant ON eoi.user_id = user_applicant.id
WHERE $filter LIKE '%' || ? || '%'
ORDER BY $order $dir
TEXT, [$query]);

render_page(function() use (&$records) {
	echo '<form id="search-bar" class="box flex">';
	render('input/select', 'Filter by', 'filter', options: [
		'job_id' => 'Job ID',
		'first_name' => "First name",
		'last_name' => "Last name",
		'full_name' => "Full name",
	], required: false, default: 'job_id');
	render('input', 'Query', required: false);
	render('input/select', 'Sort by', 'order', options: [
		'id' => 'EOI ID',
		'job_id' => 'Job ID',
		'first_name' => "First name",
		'last_name' => "Last name",
		'salary' => 'Desired salary',
	], required: false, default: 'id');
	render('input/submit', 'Search');
	echo '</form>';
},
	title: 'Management',
	style: 'manage',
);
