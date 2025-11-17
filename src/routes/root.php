<?php
render_page(function() {
	$user = Session::has_user();
	$url = $user? '/apply/edit' : '/user/signup';
	$text = $user? 'Apply Now' : 'Sign Up Now';

	echo <<<TEXT
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
		<a href="$url" class="signup-button">$text!</a>
	</section>

	<div id="fre-asked-ques" class="flex-y flex">
		<section id="fre-asked-ques-head" class="fill flex-o box">
			<h2>Frequently asked questions</h2>
			<p>Expect more to come as we listen for feedbacks.</p>
		</section>

		<section id="questions" class="fill flex">
			<article id="ques-1" class="questions box">
				<h3>How do I create an account?</h3>
				<p>
					Click <span class="important">Sign Up</span> on top and fill out the registration
					form with your info.
				</p>
			</article>
			<article id="ques-2" class="questions box">
				<h3>How do I apply for a job?</h3>
				<p>
					To apply for a job you first need an account. Then, click
					<span class="important">Apply</span> on top to build your personal profile.
				</p>
			</article>
			<article id="ques-3" class="questions box">
				<h3>Where can I find listed jobs?</h3>
				<p>Click <span class="important">Jobs</span> to browse available job listings.</p>
			</article>
		</section>
	</div>
	TEXT;
},
	title: 'Home',
	style: 'home',
);
