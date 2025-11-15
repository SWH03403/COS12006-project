<?php
render_page(function() {
	echo <<<'TEXT'
	<section id="website-introduction" class="flex flex-o box">
		<img id="company-logo" src="/static/images/logos/duodie.png" alt="Company Logo">
		<div id="company-info">
			<h1>Find your dream job, fast!</h1>
			<p>
				Dive in the world of <span class="important">job hunting</span>.
				Submit your job applicaitions and find vacant positions in a flash with
				<span class="important">&gt;Speed Job</span>, a product of
				<span class="important">DuoOrDxe</span>.
			</p>
			<p>
				<span class="tiny">Spoiler: we've been speedrunning all the sprints and scrims right before
				the deadline.</span>
			</p>
		</div>
	</section>

	<section id="apply-now" class="flex-o flex-y">
		<h2>Ready to take the next step?</h2>
		<p>Create your profile and start applying for jobs now!</p>
		<a href="/user/signup" class="signup-button">Signup Now</a>
	</section>

	<div id="fre-asked-ques" class="flex-y flex">
		<section id="fre-asked-ques-head" class="fill flex-o box">
			<h2>Common questions</h2>
			<p>Questions that are frequently asked about our job application platform.</p>
		</section>

		<section id="questions" class="fill flex">
			<article id="ques-1" class="questions box">
				<h3>How do I create a profile?</h3>
				<p>
					To create an profile, click "Profile" and fill out the registration form with your details.
				</p>
			</article>
			<article id="ques-2" class="questions box">
				<h3>How do I apply for jobs?</h3>
				<p>To apply for jobs, create an account by signing up and create your profile.</p>
			</article>
			<article id="ques-3" class="questions box">
				<h3>Where can i find listed jobs?</h3>
				<p>Navigate to the "Jobs" section to browse available job listings.</p>
			</article>
		</section>
	</div>
	TEXT;
},
	title: 'Home',
	style: 'home',
);
