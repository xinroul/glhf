<?php
	// Initialize the session
	session_start();
	
	// Include main functions
	require_once("include/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	echo "Welcome {$_SESSION["username"]}!";
?>