<?php
	require_once("include/funcs/sql_funcs.php");
	
	sql_connect();
	
	/*
		Account class (no inheritance for different user types)
	*/
	class Ticket{
		public $ticket_id;
		private $created_by;
		
		private $title;
		private $description;
		private $tags;
		
		private $status;
		private $duplicate_of;
		private $assigned_to;
		private $reviewed_by;
		
		private $viewed_by;
		
		/*
			Constructor
		*/
		function __construct($ticket_id, $as_user = NULL){
			$ticket_id = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($ticket_id));
			
			$query = db_query("SELECT * FROM `tickets` WHERE `id` = '{$ticket_id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			//If the ticket exists
			if(mysqli_num_rows($query) == 1){
				$this->ticket_id = $result['id'];
				$this->title = $result['title'];
				$this->description = $result['description'];
				$this->created_by =  new Account($result['created_by']);
				$this->tags = $result['tags'];
				$this->status = $result['status'];
				$this->duplicate_of = $result['duplicate_of'];
				
				if(!is_null($as_user)){
					//Get details of the user accessing the ticket
					$this->viewed_by = new Account(mysqli_real_escape_string($GLOBALS['mysql_link'], trim($as_user)));
					
					//If not regular user, include the details below
					if(!$this->viewed_by->is_norm()){
						try{
							$this->assigned_to = new Account($result['assigned_to']);
							$this->reviewed_by = new Account($result['reviewed_by']);
						}catch(Exception $e){
							//If account does not exist
						}
					}
				}
			}else{
				throw new Exception("Ticket not found.");
			}
		}
		
		/*
			Get Account object of creator
		*/
		function get_created_by(){
			return $this->created_by;
		}

		/*
			Get title of ticket
		*/
		function get_title(){
			return $this->title;
		}

		/*
			Get description of ticket
		*/
		function get_description(){
			return $this->description;
		}

		/*
			Get tags  of ticket
		*/
		function get_tags(){
			return $this->tags;
		}

		/*
			Get status  of ticket
		*/
		function get_status(){
			return $this->status;
		}

		/*
			Get duplicate ID of ticket
		*/
		function get_duplicate_of(){
			return $this->duplicate_of;
		}

		/*
			Get developer assigned to ticket
		*/
		function get_assigned_to(){
			return $this->assigned_to;
		}

		/*
			Get reviewer assigned to ticket
		*/
		function get_reviewed_by(){
			return $this->reviewed_by;
		}
		
		/*
			Updates the ticket title
			Available to owner of ticket or elevated users
			
			$param	string
		*/
		function update_title($new_title){
			if($this->viewed_by->id == $this->created_by->id || !$this->viewed_by->is_norm()){
				$new_title = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($new_title));
				
				db_query("UPDATE `tickets` SET `title` = '{$new_title}' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket description
			Available to owner of ticket or elevated users
			
			$param	string
		*/
		function update_desc($new_desc){
			if($this->viewed_by->id == $this->created_by || !$this->viewed_by->is_norm()){
				$new_desc = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($new_desc));
				
				db_query("UPDATE `tickets` SET `description` = '{$new_desc}' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket tags
			Available to owner of ticket or elevated users
			
			$param	string with "," delim
		*/
		function update_tags($new_tags){
			if($this->viewed_by->id == $this->created_by || !$this->viewed_by->is_norm()){
				$tag_array = explode(",", $new_tags);
				
				array_walk($tag_array, function(&$value, $key){
					$value = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($value));
				});
				
				$tag_str = implode(",", $tag_array);
				
				db_query("UPDATE `tickets` SET `tags` = '{$tag_str}' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket status
			Available only to developers, reviewers, and triagers
			
			$param	string
		*/
		function update_status($new_status){
			if(!$this->viewed_by->is_norm()){
				$new_status = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($new_status));
				
				db_query("UPDATE `tickets` SET `status` = '{$new_status}' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket duplicate id
			Available only to triagers
			
			$param	int
		*/
		function update_dup($dup_id){
			//Ensure only triagers can update this field
			if($this->viewed_by->is_tri() || $this->viewed_by->admin()){
				db_query("UPDATE `tickets` SET `duplicate_of` = '". (int)$dup_id ."' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket assignment details
			Available only to triagers
			
			$param	string
		*/
		function update_assign($dev_id){
			if($this->viewed_by->is_tri() || $this->viewed_by->admin()){
				$dev_id = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($dev_id));
				
				db_query("UPDATE `tickets` SET `assigned_to` = '{$dev_id}' WHERE .`id` = {$this->id};");
			}
		}
		
		/*
			Updates the ticket reviewer details
			Available only to reviewers and triagers
			
			$param	string
		*/
		function update_review($rev_id){
			if($this->viewed_by->is_rev() || $this->viewed_by->is_tri() || $this->viewed_by->admin()){
				$rev_id = mysqli_real_escape_string($GLOBALS['mysql_link'], trim($rev_id));
				
				db_query("UPDATE `tickets` SET `reviewed_by` = '{$rev_id}' WHERE .`id` = {$this->id};");
			}
		}
	}
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>