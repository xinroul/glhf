<?php
	require_once("Ticket.php");
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
		
		@return	Array of Ticket objects
	*/
	function get_tickets($user){
		$user = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($user));
		$query = db_query("SELECT `id` FROM `tickets`;");
		$output = [];
		
		while($row = mysqli_fetch_assoc($query)){
			$output[] = new Ticket((int)$row['id'], $user);
		}
		
		return $output;
	}
?>