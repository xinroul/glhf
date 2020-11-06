<?php
	//Current redirects to error are the same; can show different page if required per error type
	
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
	
	$_POST['ticket_id'] = (int)$_POST['ticket_id'];
	
	//Ensure ticket exists
	try{
		$ticket = new Ticket($_POST['ticket_id'], $_SESSION['username']);
	}catch(Exception $e){
		header("location: view_all_tickets.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//Ensure the user has permissions to update the field
	$account = new Account($_SESSION['username']);
	
	if(!$account->is_tri() && !$account->is_admin()){
		header("location: view_ticket_info.php?t={$_POST['ticket_id']}");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//If setting bug as duplicate
	if(isset($_POST['set_as_duplicate'])){
		$ticket->update_dup((int)$_POST['dup_id']);
		
		header("location: view_ticket_info.php?t={$_POST['ticket_id']}");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//If no developer was chosen
	if(empty($_POST['developer'])){
		header("location: view_ticket_info.php?t={$_POST['ticket_id']}");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
	
	//If clearing the assigned developer
	if($_POST['developer'] == "1"){
		$ticket->clear_dev();
		$ticket->update_status('Unassigned');

	}else{
		//If assigning a developer
		if(!$ticket->assign_dev($_POST['developer'])){
			//If error in assigning
			header("location: view_ticket_info.php?t={$_POST['ticket_id']}");
			@mysqli_close($GLOBALS['mysql_link']);
			exit();
		}
		
		//Update the status and redirect
		$ticket->update_status('Assigned');
	}
	
	header("location: view_ticket_info.php?t={$_POST['ticket_id']}");
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>
