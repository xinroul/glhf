<?php
	/*
		Connects to the db when required
	*/
	function sql_connect(){
		$GLOBALS['__mysql_link'] = mysqli_connect("localhost", "root", "", "glhf", 3306);
	}
	
	/*
		Connects to the db when required
		
		@param	Query string
		@return	SQL query result / error
	*/
	function db_query($query){
		$result = mysqli_query($GLOBALS['__mysql_link'], $query);
		$error = mysqli_error($GLOBALS['__mysql_link']);
		
		if ($error != ""){
			echo $error;
			echo nl2br(var_export(debug_backtrace(), true));
			exit();
		}
		
		return $result;
	}
?>