<?php
	use PHPUnit\Framework\TestCase;
	require_once("include/funcs/sql_funcs.php");
	
	sql_connect();
	
	/*
		Test if ticket exists as seen from triager
	*/
	class TicketExistTest extends TestCase{
		public $ticket_id;
		
		private $created_by;
		private $created_date;
		
		private $title;
		private $description;
		private $tags;
		
		private $status;
		private $duplicate_of;
		private $assigned_to;
		private $reviewed_by;
		
		private $viewed_by;
		
		/*
			Tests the constructor
		*/
		function test_construct(){
			//Declare test variables
			$ticket_id = 1;
			$as_user = "jepo";
			
			$query = db_query("SELECT * FROM `tickets` WHERE `id` = '{$ticket_id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			$this->assertEquals($result['id'], 1);
			$this->assertEqualsIgnoringCase($result['title'], "Cannot update shipping address");
			$this->assertEqualsIgnoringCase($result['description'], "Users cannot update their shipping address from their profile page. No errors were returned on submit.");
			$this->assertEquals(new Account($result['created_by']), new Account("emda"));
			$this->assertEquals($result['created_date'], "2020-10-08");
			$this->assertEquals($result['tags'], "shipping address");
			$this->assertEquals($result['status'], "unassigned");
			$this->assertNull($result['duplicate_of']);
			$this->assertEquals(new Account(str_clean($as_user)), new Account("jepo"));
			
			$this->expectException(Exception::class);
			$test1 = new Account($result['assigned_to']);
			
			$this->expectException(Exception::class);
			$test2 = new Account($result['reviewed_by']);
		}
		
		/*
			Constructor
		*/
		public function setUp() : void{
			$ticket_id = 1;
			$as_user = "admin";
			
			$ticket_id = (int)$ticket_id;
			
			$query = db_query("SELECT * FROM `tickets` WHERE `id` = '{$ticket_id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			//If the ticket exists
			if(mysqli_num_rows($query) == 1){
				$this->ticket_id = $result['id'];
				$this->title = $result['title'];
				$this->description = $result['description'];
				$this->created_by =  new Account($result['created_by']);
				$this->created_date = $result['created_date'];
				$this->tags = $result['tags'];
				$this->status = $result['status'];
				$this->duplicate_of = $result['duplicate_of'];
				
				if(!is_null($as_user)){
					//Get details of the user accessing the ticket
					$this->viewed_by = new Account(str_clean($as_user));
					
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
			Tests the method to get Account object of creator
		*/
		function test_get_created_by(){
			return $this->assertEquals($this->created_by, new Account("emda"));
		}
		
		/*
			Tests the method to get date of ticket creation
		*/
		function test_get_created_date(){
			return $this->assertEquals($this->created_date, "2020-10-08");
		}

		/*
			Tests the method to get title of ticket
		*/
		function test_get_title(){
			return $this->assertEqualsIgnoringCase($this->title, "Cannot update shipping address");
		}

		/*
			Tests the method to get description of ticket
		*/
		function test_get_description(){
			return $this->assertEqualsIgnoringCase($this->description, "Users cannot update their shipping address from their profile page. No errors were returned on submit.");
		}

		/*
			Tests the method to get tags  of ticket
		*/
		function test_get_tags(){
			return $this->assertEquals($this->tags, "shipping address");
		}

		/*
			Tests the method to get status  of ticket
		*/
		function test_get_status(){
			return $this->assertEquals($this->status, "unassigned");
		}

		/*
			Tests the method to get duplicate ID of ticket
		*/
		function test_get_duplicate_of(){
			return $this->assertNull($this->duplicate_of);
		}

		/*
			Tests the method to get developer assigned to ticket
		*/
		function test_get_assigned_to(){
			return $this->assertIsNotObject($this->assigned_to);
		}

		/*
			Tests the method to get reviewer assigned to ticket
		*/
		function test_get_reviewed_by(){
			return $this->assertIsNotObject($this->reviewed_by);
		}
	}
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>