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
	
	$_POST['ticket_id'] = (int)$_POST['ticket_id'];
	
	//Ensure ticket exists
	try{
		$ticket = new Ticket($_POST['ticket_id'], $_SESSION['username']);
	}catch(Exception $e){
		header("location: all_tickets.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//If no developer was chosen
	if($_POST['developer'] == "0"){
		header("location: ticket_info?t={$_POST['ticket_id']}.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//Ensure the user has permissions to update the field
	$account = new Account($_SESSION['username']);
	
	if(!$account->is_tri() && !$account->is_admin()){
		header("location: ticket_info?t={$_POST['ticket_id']}.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//If clearing the assigned developer
	if($_POST['developer'] == "1"){
		//Update the field
		db_query("UPDATE `tickets` SET `assigned_to` = '' WHERE `id` = {$_POST['ticket_id']} LIMIT 1;");
	}else{
		//Ensure developer exists
		$developer = new Account(mysqli_real_escape_string($GLOBALS['mysql_link'], trim($_POST['developer'])));
		
		if(!$developer->is_dev()){
			header("location: ticket_info?t={$_POST['ticket_id']}.php");
			@mysqli_close($GLOBALS['mysql_link']);
			exit();
		}
		
		//Update the field
		db_query("UPDATE `tickets` SET `assigned_to` = '{$developer->id}' WHERE `id` = {$_POST['ticket_id']} LIMIT 1;");
	}
	
	header("location: ticket_info?t={$_POST['ticket_id']}.php");
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>