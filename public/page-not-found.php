<?php

function not_found_page($group_name): void {
	?>
	<div class="container mt-5">
		<div class="alert alert-warning text-center" role="alert">
			<h4 class="alert-heading">Group Not Found</h4>
			<p>The group <strong><?php echo htmlspecialchars($group_name, ENT_QUOTES, 'UTF-8'); ?></strong> does not exist or is disabled.</p>
		</div>
	</div>
	<?php
}
