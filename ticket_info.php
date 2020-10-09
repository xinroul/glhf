<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit;
	}
	
	// Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
	
	try{
		$ticket = new Ticket((int)$_GET['t'], $_SESSION['username']);
	}catch(Exception $e){
		header("location: all_tickets.php");
		@mysqli_close($GLOBALS['mysql_link']);
		exit();
	}
?>

<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Welcome</title>
		<link rel='stylesheet' href='include/css/main.css'>
		<link rel='shortcut icon' href='#' /> <!-- Resolving favicon.ico error -->
	</head>
	<body>
		<div style='float:left;'>
			Welcome <a href='#'><?php echo $account->get_full_name(); ?></a>!
			<br />
			<a href='all_tickets.php'>Back to main page</a>
		</div>
		<div style='float:right;'>
			<a href='logout.php'>
				Logout
			</a>
		</div>
		<br />
		<br />
		<br />
		<table id='ticket_details' class='basic_table'>
			<tr>
				<td colspan='2'>
					Viewing ticket #<?php echo (int)$_GET['t']; ?>
				</td>
			</tr>
			<tr>
				<td>
					Title:
				</td>
				<td>
					<?php echo $ticket->get_title(); ?>
				</td>
			<tr>
			<tr>
				<td>
					Description:
				</td>
				<td>
					<?php echo $ticket->get_description(); ?>
				</td>
			<tr>
			<tr>
				<td>
					Tags:
				</td>
				<td>
					<?php
						$tag_array = explode(",", $ticket->get_tags());
						
						foreach($tag_array as $tag){
					?>
					<span class='ticket_tag'>
							<?php echo $tag; ?>
					</span>	
					<?php
						}
					?>
				</td>
			<tr>
			<tr>
				<td>
					Created by:
				</td>
				<td>
					<a href='#'>
						<?php echo $ticket->get_created_by()->get_full_name(); ?>
					</a>
				</td>
			<tr>
			<tr>
				<td>
					Current Status:
				</td>
				<td class='<?php echo $ticket->get_status(); ?>_ticket'>
					<?php echo ucfirst($ticket->get_status()); ?>
				</td>
			<tr>
			<?php
				if(!$account->is_norm()){
			?>
			<tr>
				<td>
					Assigned to:
				</td>
				<td>
					<a href='#'>
						<?php echo (is_object($ticket->get_assigned_to()) ? $ticket->get_assigned_to()->get_full_name() : ""); ?>
					</a>
				</td>
			<tr>
			<tr>
				<td>
					Reviewed by:
				</td>
				<td>
					<a href='#'>
						<?php echo (is_object($ticket->get_reviewed_by()) ? $ticket->get_reviewed_by()->get_full_name() : ""); ?>
					</a>
				</td>
			<tr>
			<?php
				}
				
				if($account->is_tri() || $account->is_admin()){
			?>
			<tr>
				<td>
					Assign to:
				</td>
				<td>
					 <form action='assign_ticket.php' method='POST'>
						<select name='developer'>
							<option value='0'>Assign developer</option>
							<option value='1'>Clear developer</option>
					<?php
						$query = db_query("SELECT * FROM `accounts` WHERE `account_type` = 'developer' ORDER BY `experience`;");
						
						while($row = mysqli_fetch_assoc($query)){
					?>
							 <option value='<?php echo $row['id']; ?>'><?php echo $row['first_name'] ." ". $row['first_name'] ." (". $row['experience'] ." Exp)"; ?></option>
					<?php
						}
					?>
						</select>
						<input type='checkbox' class='confirm_checkbox' name='ticket_id' value='<?php echo $ticket->ticket_id; ?>' />
						<input type='submit' id='confirm_<?php echo $ticket->ticket_id; ?>' value='Assign' disabled/>
					</form>
				</td>
			</tr>
			<?php
				}
			?>
		</table>
	</body>
</html>
<script src='include/js/jquery-light-v3.5.1.js'></script>
<script src='include/js/global.js'></script>
<?php
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>