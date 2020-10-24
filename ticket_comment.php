<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit();
	}
	
	//If any field is empty
	if(empty($_POST['bug_id'])){
		header("location: view_all_tickets.php");
		exit();
	}elseif(empty($_POST['comment'])){
		header("location: view_ticket_info.php?t={$_POST['bug_id']}");
		exit();
	}
	
	// Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	//Prepare the strings for SQL insertion
	$_POST['bug_id'] = (int)$_POST['bug_id'];
	str_clean($_POST['comment']);
	
	db_query(
		"INSERT INTO 
			`comments` 
				(`ticket_id`, `account_id`, `created_date`, `comment`)
			VALUES 
				('{$_POST['bug_id']}', '{$_SESSION['username']}', CURRENT_TIMESTAMP, '{$_POST['comment']}');"
	);
	
	header("location: view_ticket_info.php?t={$_POST['bug_id']}");
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>