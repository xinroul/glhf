<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit();
	}
	
	// Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
	
	//If not elevated user account
	if(!$account->is_tri() && !$account->is_admin()){
		header("location: view_all_tickets.php");
	}
	
	$query = db_query("SELECT * FROM `accounts` WHERE `account_type` IN ('developer', 'reviewer') ORDER BY `first_name`, `last_name`;");
	$staff_map = [];
?>

<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Generate Reports</title>
		<link rel='stylesheet' href='include/css/main.css'>
		<link rel='shortcut icon' href='#' /> <!-- Resolving favicon.ico error -->
	</head>
	<body>
		<?php include("include/templates/header.php"); ?>
		Staff: 
		<select id='staff_select'>
			<option value='0'>All</option>
			<?php
				while($row = mysqli_fetch_assoc($query)){
					$staff_map[$row['id']] = "{$row['first_name']} {$row['last_name']}";echo "{$row['first_name']} {$row['last_name']}";
			?>
					<option value='<?= $row['id'] ?>'><?= "{$row['first_name']} {$row['last_name']} ({$row['experience']} Exp)" ?></option>
			<?php
				}
			?>
		</select>
		From: <input type='date' id="start_date" />
		To: <input type='date' id="end_date" />
		<input type='button' id='generate_report' value='Generate' />
		<br />
		<br />
		<div id='staff_report'></div>
		<br />
		<a href='view_all_tickets.php'>Back to main page</a>
	</body>
</html>
<script src='include/js/jquery-light-v3.5.1.js'></script>
<script src='include/js/global.js'></script>
<script>
	var staff_map = <?= json_encode($staff_map) ?>;
</script>
<script src='include/js/reports.js'></script>
<?php
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>