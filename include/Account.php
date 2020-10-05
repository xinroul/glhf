<?php
	require_once("sql_funcs.php");
	
	sql_connect();
	
	/*
		Account class (no inheritance for different user types)
	*/
	class Account{
		public $id;
		private $first_name;
		private $last_name;
		private $dob;
		private $account_type;
		private $experience;
		
		/*
			Constructor
		*/
		function __construct($id){
			$id = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($id));
			
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
			Get first name
		*/
		function get_first_name(){
			return $this->first_name;
		}
		
		/*
			Get last name
		*/
		function get_last_name(){
			return $this->last_name;
		}
		
		/*
			Get full name
		*/
		function get_full_name(){
			return $this->first_name . " " . $this->last_name;
		}
		
		/*
			Get date of birth
		*/
		function get_dob(){
			return $this->dob;
		}
		
		/*
			Get account type
		*/
		function get_account_type(){
			return $this->account_type;
		}
		
		/*
			Get experience
		*/
		function get_experience(){
			return $this->experience;
		}
		
		/*
			Checks if the user is a normal user
			
			@return bool
		*/
		function is_norm(){
			return ($this->account_type == "user");
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
			Checks if the user is a triager
			
			@return bool
		*/
		function is_admin(){
			return ($this->account_type == "admin" || $this->account_type == "administrator");
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
	@mysqli_close($GLOBALS['mysql_link']);
?>