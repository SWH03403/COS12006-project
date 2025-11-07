CREATE TABLE eoi (
	id INTEGER PRIMARY KEY,
	user_id INTEGER NOT NULL REFERENCES user(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	job_id INTEGER NOT NULL REFERENCES job(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	start_date DATE NOT NULL,
	desired_salary INTEGER NOT NULL,
	extra TEXT NOT NULL, -- Additional qualifications

	status TEXT NOT NULL
		CHECK(status IN ('New', 'Current', 'Final'))
		DEFAULT 'New',
	reason TEXT, -- deny/reject reason
	created DATETIME NOT NULL
		DEFAULT current_timestamp,
	updated DATETIME NOT NULL
		DEFAULT current_timestamp
);

CREATE TABLE eoi_accept (
	id INTEGER PRIMARY KEY REFERENCES eoi(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	name TEXT NOT NULL -- References job_requirement(name)
) WITHOUT ROWID;
