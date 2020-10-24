<?php
	use PHPUnit\Framework\TestCase;
	require_once("include/funcs/sql_funcs.php");
	
	sql_connect();
	
	/*
		Test if ticket exists as seen from triager
	*/
	class AccountExistTest extends TestCase{
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
			$id = "daco";
			
			$query = db_query("SELECT * FROM `accounts` WHERE `id` = '{$id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			$this->assertEquals($result['id'], "daco");
			$this->assertEquals($result['first_name'], "Daniella");
			$this->assertEquals($result['last_name'], "Costa");
			$this->assertEquals($result['dob'], "1984-04-11");
			$this->assertEquals($result['account_type'], "reviewer");
			$this->assertEquals($result['experience'], 5);
		}
		
		/*
			Constructor
		*/
		public function setUp() : void{
			$id = "daco";
			
			$id = str_clean($id);
			
			$query = db_query("SELECT * FROM `accounts` WHERE `id` = '{$id}' LIMIT 1;");
			$result = mysqli_fetch_assoc($query);
			
			//If the user exists
			if(mysqli_num_rows($query) == 1){
				$this->id = $result['id'];
				$this->first_name = $result['first_name'];
				$this->last_name = $result['last_name'];
				$this->dob = $result['dob'];
				$this->account_type = $result['account_type'];
				$this->experience = $result['experience'];
			}else{
				throw new Exception("User not found.");
			}
		}
		
		/*
			Tests the method to get first name
		*/
		function test_get_first_name(){
			return $this->assertEquals($this->first_name, "Daniella");
		}
		
		/*
			Tests the method to get last name
		*/
		function test_get_last_name(){
			return $this->assertEquals($this->last_name, "Costa");
		}
		
		/*
			Tests the method to get full name
		*/
		function test_get_full_name(){
			return $this->assertEquals(($this->first_name . " " . $this->last_name), "Daniella Costa");
		}
		
		/*
			Tests the method to get date of birth
		*/
		function test_get_dob(){
			return $this->assertEquals($this->dob, "1984-04-11");
		}
		
		/*
			Tests the method to get account type
		*/
		function test_get_account_type(){
			return $this->assertEquals($this->account_type, "reviewer");
		}
		
		/*
			Tests the method to get experience
		*/
		function test_get_experience(){
			return $this->assertEquals($this->experience, 5);
		}
		
		/*
			Tests the method to checks if the user is a normal user
			
			@return bool
		*/
		function test_is_norm(){
			return $this->assertNotTrue($this->account_type == "user");
		}
		
		/*
			Tests the method to checks if the user is a developer
			
			@return bool
		*/
		function test_is_dev(){
			return $this->assertNotTrue($this->account_type == "developer");
		}
		
		/*
			Tests the method to checks if the user is a reviewer
			
			@return bool
		*/
		function test_is_rev(){
			return $this->assertTrue($this->account_type == "reviewer");
		}
		
		/*
			Tests the method to checks if the user is a triager
			
			@return bool
		*/
		function test_is_tri(){
			return $this->assertNotTrue($this->account_type == "triager");
		}
		
		/*
			Tests the method to checks if the user is a triager
			
			@return bool
		*/
		function test_is_admin(){
			return $this->assertNotTrue($this->account_type == "admin" || $this->account_type == "administrator");
		}
	}
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>