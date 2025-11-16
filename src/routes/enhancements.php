<?php
Session::require_user(true);

render_page(function() {
	echo '<div id="enhancements-list" class="box flex-y">';
	render('list', 'Implemented Features / Enhancements', [
		[ 'title' => '"Create a manager registration page with server side validation requiring unique
		username and a password rule, and store this information in a table."',
			[ 'title' => 'All accounts are stored on a single database table with extension tables to
			derive roles and associate extra data.',
				'Anyone can create an applicant profile to submit an EOI.',
				'Changes made in a profile will be reflected on all applications made by its owner.',
				'Management privileges can be granted / revoked.',
			],
			[ 'title' => 'All applicants are required to create an account to use our service.',
				"This helps storing data efficiently by using a single table to store common applicant
				infomation, such as one's first and last name.",
				'By using accounts, users can be authorized to make changes to applications they have
				submitted.',
			],
			'A manager can not promote an user to a new manager.',
			[ 'title' => 'Shortcomings / Planned features',
				'Currently, only the first account has the role "manager".',
				'A new account type "admin" with can grant access to the distinct "manager" role.',
			],
		],
		[ 'title' => '"Control access to manage.php by checking username and password."',
			[ 'title' => 'Currently, our website implements authentication methods that can check:',
				'Whether an user is logged in, otherwise, it redirects to the Login page.',
				'Whether an user is a manager (after the previous step), otherwise, a "403 Forbidden"
				message is shown.'
			],
		],
		[ 'title' => '"Provide the manager with the ability to select the field on which to sort the
		order in which the EOI records are displayed."',
			'(unimplemented)',
		],
		[ 'title' => '"Have access to the web site disabled for user a period of time on, say, three or
		more invalid login attempts."',
			'(unimplemented)',
			[ 'title' => 'A new database table is used to store time of the last failed login attempts.',
				'(The database is used as it persists between sessions, and therefore, between different
				machines)',
				'Another column counts the total amount of previously failed attempts.',
				'When the threshold is met, we invalidate all attempts to login as said user.',
				'The lock record is removed when the user successfully logs in or the lock expires.',
			],
			[ 'title' => 'The Login page now shows this system in action.',
				'After a failed login, a messaged containing the number of remaining tries is shown',
				'When the lock is engaged, the message "Account is Locked" is shown.',
				'The duration of the lock is kept hidden for a small layer of obscurity.',
			],
		],
	]);
	echo '</div>';
},
	title: 'Enhancements',
	style: 'enhance',
);
