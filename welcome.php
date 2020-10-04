<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit;
	}
	
	// Include main functions
	require_once("include/sql_funcs.php");
	require_once("include/Account.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Welcome</title>
	</head>
	<body>
		<div style='float:left;'>
			<?php echo "Welcome {$account->get_full_name()}!"; ?>
		</div>
		<div style='float:right;'>
			<a href='logout.php'>
				Logout
			</a>
		</div>
		<?php
			foreach(get_tickets($_SESSION['username']) as $ticket){
				echo "<br><br><pre>";
				var_dump($ticket);
				echo "</pre>";
			}
		?>
	</body>
</html>
<?php
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>