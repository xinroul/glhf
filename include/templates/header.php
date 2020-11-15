<?php
	if(!is_object($account)){
		$account = new Account($_SESSION['username']);
	}
?>
<div style='float:left;'>
	Welcome 
	<a href='#'>
		<a href='view_account_info.php?a=<?= $account->id ?>'>
			<?= $account->get_full_name() ?>
		</a>
	</a>!
	<a href='report_bug.php'>
		[ Report a new bug ]
	</a>
	<?php
		if($account->is_tri() || $account->is_admin()){
	?>
			<a href='view_reports.php'>
				[ Generate reports ]
			</a>
	<?php
		}
	?>
</div>
<div style='float:right;'>
	<a href='logout.php'>
		Logout
	</a>
</div>
<br />
<br />