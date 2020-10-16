<?php
	require_once("include/class/ClassAccount.php");
	require_once("include/class/ClassTicket.php");
	/*
		Connects to the db when required
	*/
	function sql_connect(){
		$GLOBALS['mysql_link'] = mysqli_connect("localhost", "root", "", "glhf", 3306);
	}
	
	/*
		Connects to the db when required
		
		@param	Query string
		@return	SQL query result / error
	*/
	function db_query($query){
		$result = mysqli_query($GLOBALS['mysql_link'], $query);
		$error = mysqli_error($GLOBALS['mysql_link']);
		
		if ($error != ""){
			echo $error;
			echo nl2br(var_export(debug_backtrace(), true));
			exit();
		}
		
		return $result;
	}
	
	/*
		Returns all tickets
		
		@param	User ID
		@return	Array of Ticket objects
	*/
	function get_tickets($as_user){
		$as_user = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($as_user));
		$query = db_query("SELECT `id` FROM `tickets`;");
		$output = [];
		
		while($row = mysqli_fetch_assoc($query)){
			try{
				$output[] = new Ticket((int)$row['id'], $as_user);
			}catch(Exception $e){
				continue;
			}
		}
		
		return $output;
	}
	
	/*
		Gets all comments of a ticket
		
		@param	Ticket ID
		@return	Array of Ticket objects
	*/
	function get_comments($ticket_id){
		$ticket_id = (int)$ticket_id;
		$query = db_query("SELECT * FROM `comments` WHERE `ticket_id` = {$ticket_id} ORDER BY `created_date` DESC;");
		$output = [];
		
		while($row = mysqli_fetch_assoc($query)){
			$output[] = $row;
		}
		
		return $output;
	}
?>