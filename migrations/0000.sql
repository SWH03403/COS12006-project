CREATE TABLE user (
	id INTEGER PRIMARY KEY,
	name TEXT NOT NULL,
	hash TEXT NOT NULL,
	display TEXT NOT NULL,
	email TEXT NOT NULL,

	created DATETIME NOT NULL
		DEFAULT current_timestamp,
	updated DATETIME NOT NULL
		DEFAULT current_timestamp
);

CREATE TABLE user_applicant (
	id PRIMARY KEY REFERENCES user(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	first_name TEXT NOT NULL,
	last_name TEXT NOT NULL,
	dob DATE NOT NULL,
	gender TEXT NOT NULL
		CHECK(gender IN ('m', 'f', '?')),

	can_check_background BOOLEAN NOT NULL,
	is_convict BOOLEAN NOT NULL,
	is_veteran BOOLEAN NOT NULL,

	street TEXT NOT NULL,
	town TEXT NOT NULL,
	state TEXT NOT NULL,
	postcode TEXT NOT NULL,

	phone TEXT NOT NULL
) WITHOUT ROWID;

CREATE TABLE user_manager (
	id PRIMARY KEY REFERENCES user(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
