<?php
	if(!is_object($account)){
		$account = new Account($_SESSION['username']);
	}
?>
<div style='float:left;'>
	Welcome 
	<a href='#'>
		<?php echo $account->get_full_name(); ?>
	</a>!
	<a href='report_bug.php'>
		[ Report a new bug ]
	</a>
</div>
<div style='float:right;'>
	<a href='logout.php'>
		Logout
	</a>
</div>
<br />
<br />