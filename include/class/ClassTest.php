<?php
	use PHPUnit\Framework\TestCase;
	require_once("include/funcs/sql_funcs.php");
	
	sql_connect();
	
	/*
		Test if ticket exists as seen from triager
	*/
	class TicketTrue extends TestCase{
		function test_existing_ticket(){
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
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>