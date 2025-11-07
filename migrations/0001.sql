CREATE TABLE job_category (
	id INTEGER PRIMARY KEY,
	name TEXT NOT NULL UNIQUE
);

CREATE TABLE job (
	id TEXT PRIMARY KEY -- Reference Number
		CHECK(length(id) = 5),
	category_id INTEGER NOT NULL REFERENCES job_category(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	company TEXT NOT NULL,
	superior TEXT NOT NULL,

	name TEXT NOT NULL,
	location TEXT NOT NULL,

	salary_min INTEGER NOT NULL,
	salary_max INTEGER NOT NULL,
	salary_currency TEXT NOT NULL
		CHECK(length(salary_currency) = 3),

	description TEXT NOT NULL,
	exp_min INTEGER NOT NULL,
	exp_max INTEGER,

	created DATETIME NOT NULL
		DEFAULT current_timestamp,
	updated DATETIME NOT NULL
		DEFAULT current_timestamp
) WITHOUT ROWID;

CREATE TABLE job_requirement (
	id INTEGER NOT NULL REFERENCES job(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	name TEXT NOT NULL,
	value TEXT NOT NULL,

	PRIMARY KEY(id, name)
) WITHOUT ROWID;
