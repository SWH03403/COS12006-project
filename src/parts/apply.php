<section id="application-header" class="flex-y flex-o">
	<h1>Application Submission</h1>
	<p>To apply for a job, please fill the following form<p>
</section>

<form id="application-form" class="flex-y box" action="formtest.php" method="post" enctype="multipart/form-data">
	<h2>Personal information</h2>
	<div class="flex">
		<label for="input-name">Name</label>
		<input id="input-name" class="fill" type="text" name="name-first" placeholder="First name" required>
		<input class="fill" type="text" name="name-last" placeholder="Last name" required>
	</div>
	<div class="flex">
		<label for="input-address">Address</label>
		<input id="input-address" class="fill" type="text" name="address" placeholder="123 Abc Street, Xyz District" required>
	</div>
	<div class="flex">
		<label for="input-dob">Date of birth</label>
		<input id="input-dob" class="fill" type="date" name="dob" required>
	</div>
	<div class="flex">
		<label for="input-phone">Phone number</label>
		<input id="input-phone" class="fill" type="text" name="phone" placeholder="09XXXXXXXX" pattern="[0-9]+" required>
	</div>
	<div class="flex">
		<label for="input-email">Email</label>
		<input id="input-email" class="fill" type="text" name="email" placeholder="user@example.com" required>
	</div>
	<div class="flex">
		<label for="input-gender">Gender</label>
		<select id="input-gender" class="fill" name="gender" required>
			<option value="">(choose one)</option>
			<option value="male">Male</option>
			<option value="female">Female</option>
			<option value="other">Other</option>
		</select>
	</div>
	<div class="flex input-yesno">
		<label>Are you willing to submit to a background check if selected for employment?</label>
		<input class="fill" type="radio" name="background" value="true" required>
		<input class="fill" type="radio" name="background" value="false">
	</div>
	<div class="flex input-yesno">
		<label>Have you ever been convicted of a felony?</label>
		<input class="fill" type="radio" name="felony" value="true" required>
		<input class="fill" type="radio" name="felony" value="false">
	</div>
	<div class="flex input-yesno">
		<label>Are you a veteran?</label>
		<input class="fill" type="radio" name="veteran" value="true" required>
		<input class="fill" type="radio" name="veteran" value="false">
	</div>
	<div class="flex-y">
		<label for="input-start">When are you available to start in case you are selected for employment?</label>
		<div id="form-start-date" class="flex flex-o">
			<input id="input-start" type="date" name="start-date" required>
		</div>
	</div>

	<h2>Position information</h2>
	<div class="flex">
		<label for="input-company">Company name</label>
		<select id="input-company" class="fill" name="company" required>
			<option value="">(choose one)</option>
			<option value="Aurora Dataworks">Aurora Dataworks</option>
			<option value="Blue Mesa Systems">Blue Mesa Systems</option>
			<option value="Clearview Financial Systems">Clearview Financial Systems</option>
			<option value="Harborlight Mobile">Harborlight Mobile</option>
			<option value="KumoShield Security Corp.">KumoShield Security Corp.</option>
			<option value="LotusGuard CyberTech">LotusGuard CyberTech</option>
			<option value="Meridian Pixelworks">Meridian Pixelworks</option>
			<option value="Meridian Retail Labs">Meridian Retail Labs</option>
			<option value="North Harbor Analytics">North Harbor Analytics</option>
			<option value="Pacific Ridge Insights">Pacific Ridge Insights</option>
			<option value="Red Lantern Infrastructure">Red Lantern Infrastructure</option>
		</select>
	</div>
	<div class="flex">
		<label for="input-refcode">Reference code</label>
		<select id="input-refcode" class="fill" name="refcode" required>
			<option value="">(choose one)</option>
			<option value="AIU64">AIU64</option>
			<option value="COR46">COR46</option>
			<option value="HAO39">HAO39</option>
			<option value="IUC60">IUC60</option>
			<option value="JNW01">JNW01</option>
			<option value="LCI52">LCI52</option>
			<option value="MDS91">MDS91</option>
			<option value="VEE49">VEE49</option>
			<option value="VKE99">VKE99</option>
			<option value="ZBA91">ZBA91</option>
			<option value="ZHA71">ZHA71</option>
		</select>
	</div>
	<div class="flex">
		<label for="input-salary">Desired Salary</label>
		<input id="input-salary" class="fill" type="text" name="salary" placeholder="$120,000 / year" required>
	</div>

	<div class="flex input-multi">
		<label for="input-time-full">Time</label>
		<input id="input-time-full" type="radio" name="time" value="full" required>
		<label for="input-time-full" class="fill">Full-time</label>
		<input id="input-time-part" type="radio" name="time" value="part" required>
		<label for="input-time-part" class="fill">Part-time</label>
		<input id="input-time-temporary" type="radio" name="time" value="temporary" required>
		<label for="input-time-temporary" class="fill">Temporary</label>
	</div>
	<div class="flex-y">
		<label for="input-documents">Additional supporting documents (resume, certificates, e.t.c.)</label>
		<input id="input-documents" type="file" name="documents" multiple>
	</div>
	<button type="submit">Apply</button>
</form>
