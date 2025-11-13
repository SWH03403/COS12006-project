<form class="box flex-y flex-o" method="post">
	<?php
	render_input('Email', 'email', value: $data['email']);
	render_input('Password', 'pass', 'password');
	?>
	<button type="submit">Login</button>
</form>
<span><?php var_dump($data['errors']) ?></span>
