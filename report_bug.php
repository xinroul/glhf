<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit;
	}
	
	// Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Welcome</title>
		<link rel='stylesheet' href='include/css/main.css'>
		<link rel='shortcut icon' href='#' /> <!-- Resolving favicon.ico error -->
	</head>
	<body>
		<?php include("include/templates/header.php"); ?>
		<form action='ticket_create.php' method='POST'>
			<table id='report_bug' class='basic_table' style='width:30%;'>
				<tr>
					<td colspan='2'>
						Report a new bug
					</td>
				</tr>
				<tr>
					<td style='width:15%;'>
						Title
					</td>
					<td style='width:85%;'>
						<input type='text' name='title' placeholder='Title' maxlength='80' style='width:97%; padding:' required>
					</td>
				</tr>
				<tr>
					<td style='width:15%;'>
						Description
					</td>
					<td style='width:85%;'>
						<textarea name='description' placeholder='Description' rows='8' style='width:97%;' required></textarea>
					</td>
				</tr>
				<tr>
					<td style='width:15%;'>
						Tags
					</td>
					<td style='width:85%;'>
						<input type='text' name='tags' placeholder='Separate tags by commas (eg -> purchases, history, profile)' maxlength=127 style='width:97%;' required>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' name='submit' value='Submit Bug Ticket'>
					</td>
				</tr>
			</table>
		</form>
		<br />
		<a href='view_all_tickets.php'>Back to main page</a>
	</body>
</html>
<script src='include/js/jquery-light-v3.5.1.js'></script>
<script src='include/js/global.js'></script>
<?php
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>