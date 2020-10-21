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
	
	//If any field is empty
	if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['tags'])){
		header("location: report_bug.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//Prepare the strings for SQL insertion
	str_clean($_POST['title']);
	str_clean($_POST['description']);
	str_clean($_POST['tags']);
	
	db_query(
		"INSERT INTO 
			`tickets` 
				(`id`, `title`, `description`, `created_by`, `created_date`, `tags`, `status`, `assigned_to`, `reviewed_by`, `duplicate_of`) 
			VALUES 
				(NULL, '{$_POST['title']}', '{$_POST['description']}', '{$_SESSION['username']}', CURRENT_TIMESTAMP, '{$_POST['tags']}', 'unassigned', '', '', NULL)"
	);
	
	header("location: view_ticket_info.php?t=". mysqli_insert_id($GLOBALS['mysql_link']) ."");
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>