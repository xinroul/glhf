<?php
	// Initialize the session
	session_start();
	
	// Include main functions
	require_once("include/sql_funcs.php");
	require_once("include/Account.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
	
	echo "Welcome {$account->first_name} {$account->last_name}!";
	
	//Close connection
	@mysqli_close($GLOBALS['__mysql_link']);
?>