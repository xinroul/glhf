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
		header("location: view_all_tickets.php");
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
		<?php include("include/templates/header.php"); ?>
		<table id='ticket_details' class='basic_table' style='width:60%;'>
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
			</tr>
			<tr>
				<td>
					Description:
				</td>
				<td>
					<?php echo $ticket->get_description(); ?>
				</td>
			</tr>
			<tr>
				<td>
					Tags:
				</td>
				<td>
					<?php
						$tag_array = explode(",", $ticket->get_tags());
						
						foreach($tag_array as $tag){
					?>
							<span class='ticket_tag' style='cursor:auto;'>
									<?php echo $tag; ?>
							</span>	
					<?php
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					Created by:
				</td>
				<td>
					<a href='account_info.php?a=<?php echo $ticket->get_created_by()->id; ?>'>
						<?php echo $ticket->get_created_by()->get_full_name(); ?>
					</a>
				</td>
			</tr>
			<tr>
				<td>
					Created on:
				</td>
				<td>
					<?php echo date('d-M-Y', strtotime($ticket->get_created_date())); ?>
				</td>
			</tr>
			<tr>
				<td>
					Current Status:
				</td>
				<td class='<?php echo $ticket->get_status(); ?>_ticket'>
					<?php echo ucfirst($ticket->get_status()); ?>
				</td>
			</tr>
			<?php
				if(!$account->is_norm()){
			?>
					<tr>
						<td>
							Assigned to:
						</td>
						<td>
							<?php echo (is_object($ticket->get_assigned_to()) ? "<a href='account_info.php?a={$ticket->get_assigned_to()->id}'>{$ticket->get_assigned_to()->get_full_name()}</a>" : ""); ?>
						</td>
					</tr>
					<tr>
						<td>
							Reviewed by:
						</td>
						<td>
							<?php echo (is_object($ticket->get_reviewed_by()) ? "<a href='account_info.php?a={$ticket->get_reviewed_by()->id}'>{$ticket->get_reviewed_by()->get_full_name()}</a>" : ""); ?>
						</td>
					</tr>
			<?php
				}
				
				if($account->is_tri() || $account->is_admin()){
			?>
					<tr>
						<td>
							Assign to:
						</td>
						<td>
							 <form action='ticket_assign.php' method='POST'>
								<select name='developer'>
									<option value='0'>Assign developer</option>
									<option value='1'>Clear developer</option>
							<?php
								$query = db_query("SELECT * FROM `accounts` WHERE `account_type` = 'developer' ORDER BY `experience`;");
								
								while($row = mysqli_fetch_assoc($query)){
							?>
									 <option value='<?php echo $row['id']; ?>'><?php echo $row['first_name'] ." ". $row['last_name'] ." (". $row['experience'] ." Exp)"; ?></option>
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
		<br />
		<?php
			$all_comments = get_comments((int)$_GET['t']);
			
			foreach($all_comments as $this_comment){
				$poster = new Account($this_comment['account_id']);
		?>
				<table class='basic_table' style='width:60%;'>
					<tr>
						<td>
							<span style='float:left'>From: <a href='account_info.php?a=<?php echo $this_comment['account_id']; ?>'><?php echo $poster->get_full_name(); ?></a></span> <span style='float:right'><?php echo date('d-M-Y', strtotime($this_comment['created_date'])); ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this_comment['comment']; ?>
						</td>
					</tr>
				</table>
				<br />
		<?php
			}
		?>
		<a href='view_all_tickets.php'>Back to main page</a>
	</body>
</html>
<script src='include/js/jquery-light-v3.5.1.js'></script>
<script src='include/js/global.js'></script>
<?php
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>