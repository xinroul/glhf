<?php
	require_once("sql_funcs.php");
	
	sql_connect();
	
	/*
		Account class (no inheritance for different user types)
	*/
	class Account{
		public $id;
		public $first_name;
		public $last_name;
		public $dob;
		public $account_type;
		public $experience;
		
		/*
			Constructor
		*/
		function __construct($id){
			$id = mysqli_real_escape_string($GLOBALS['__mysql_link'], trim($id));
			
			$query = db_query("SELECT * FROM `accounts` WHERE `id` = '{$id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			$this->id = $result['id'];
			$this->first_name = $result['first_name'];
			$this->last_name = $result['last_name'];
			$this->dob = $result['dob'];
			$this->account_type = $result['account_type'];
			$this->experience = $result['experience'];
		}
		
		/*
			Checks if the user is a developer
			
			@return bool
		*/
		function is_dev(){
			return $this->account_type == "developer";
		}
		
		/*
			Checks if the user is a reviewer
			
			@return bool
		*/
		function is_rev(){
			return $this->account_type == "reviewer";
		}
		
		/*
			Checks if the user is a triager
			
			@return bool
		*/
		function is_tri(){
			return $this->account_type == "triager";
		}
		
		/*
			Returns all active tickets under the user
			
			@return Ticket object / bool
		*/
		function current_tickets(){
			if($this->is_dev() || $this->is_rev()){
				return; ////////////////////////////////
			}else{
				return false;
			}
		}
		
		/*
			Returns all inactive tickets under the user
			
			@return Ticket object / bool
		*/
		function past_tickets(){
			if($this->is_dev() || $this->is_rev()){
				return; ////////////////////////////////
			}else{
				return false;
			}
		}
		
		/*
			Returns all tickets under the user
			
			@return Ticket object / bool
		*/
		function all_tickets(){
			if($this->is_dev() || $this->is_rev()){
				return; ////////////////////////////////
			}else{
				return false;
			}
		}
	}
	
	//Close connection
	@mysqli_close($GLOBALS['__mysql_link']);
?>