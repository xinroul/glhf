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
	$all_tickets = get_tickets($_SESSION['username']);
	
	//Sort the tickets
	$ticket_order = ["unassigned", "assigned", "pending", "resolved", "closed"];
	
	usort($all_tickets, function($a, $b) use ($ticket_order){
		$pos_a = array_search($a->status, $ticket_order);
		$pos_b = array_search($b->status, $ticket_order);
		
		return $pos_a - $pos_b;
	});
?>

<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Welcome</title>
		<link rel='stylesheet' href='include/css/main.css'>
		<link rel="shortcut icon" href="#" /> <!-- Resolving favicon.ico error -->
	</head>
	<body>
		<div style='float:left;'>
			Welcome <a href="#"><?php echo $account->get_full_name(); ?></a>!
		</div>
		<div style='float:right;'>
			<a href='logout.php'>
				Logout
			</a>
		</div>
		<br />
		<br />
		Search: <input type='text' name='ticket_search' id='ticket_search' placeholder='Search for ticket' /> <span id='cancel_search'>X</span>
		<input type='checkbox' id='search_id' class='search_checkbox' value=0 checked/> ID
		<input type='checkbox' id='search_title' class='search_checkbox' value=1 /> Title
		<input type='checkbox' id='search_tags' class='search_checkbox' value=2 /> Tags
		<input type='checkbox' id='search_status' class='search_checkbox' value=3 /> Status
		<?php
			//Additional table columns based on account type
			if(!$account->is_norm()){
		?>
		<input type='checkbox' id='search_assigned' class='search_checkbox' value=4 /> Assigned
		<input type='checkbox' id='search_reviewer' class='search_checkbox' value=5 /> Reviewer
		<?php
			}
		?>
		<br />
		<br />
		<table id='ticket_table' class='basic_table'>
			<tr>
				<td style='text-align:center;'>
					ID
				</td>
				<td style='text-align:center;'>
					Title
				</td>
				<td style='text-align:center;'>
					Tags
				</td>
				<td style='text-align:center;'>
					Status
				</td>
		<?php
			//Additional table columns based on account type
			if(!$account->is_norm()){
		?>
				<td style='text-align:center;'>
					Assigned
				</td>
				<td style='text-align:center;'>
					Reviewer
				</td>
		<?php
			}
			
			if($account->is_tri() || $account->is_admin()){
		?>
				<td style='text-align:center;'>
					Assign
				</td>
		<?php
			}
		?>
			</tr>
		<?php			
			//For each ticket
			foreach($all_tickets as $ticket){
		?>
			<tr>
				<td onclick="location.href='ticket_info.php?t=<?php echo $ticket->ticket_id; ?>'" class='<?php echo $ticket->status; ?>_ticket' style='text-align:center; cursor:pointer;'>
					<?php printf('%05d', $ticket->ticket_id); ?>
				</td>
				<td onclick="location.href='ticket_info.php?t=<?php echo $ticket->ticket_id; ?>'" class='<?php echo $ticket->status; ?>_ticket' style='text-align:left; cursor:pointer;'>
					<?php echo $ticket->title; ?>
				</td>
				<td class='<?php echo $ticket->status; ?>_ticket' style='text-align:left;'>
					<?php
						$tag_array = explode(",", $ticket->tags);
						
						foreach($tag_array as $tag){
					?>
					<span class='ticket_tag'>
							<?php echo $tag; ?>
					</span>	
					<?php
						}
					?>
				</td>
				<td class='<?php echo $ticket->status; ?>_ticket' style='text-align:center;'>
					<?php echo $ticket->status; ?>
				</td>
			<?php
				//Additional table columns based on account type
				if(!$account->is_norm()){
			?>
				<td class='<?php echo $ticket->status; ?>_ticket' style='text-align:center;'>
					<?php echo $ticket->assigned_to->id; ?>
				</td>
				<td class='<?php echo $ticket->status; ?>_ticket' style='text-align:center;'>
					<?php echo $ticket->reviewed_by->id; ?>
				</td>
			<?php
				}
				
				if($account->is_tri() || $account->is_admin()){
			?>
				<td style='text-align:center;'>
					 <form action='#' method='POST'>
						<select name='developer'>
							<option value=0>Assign developer</option>
							<option value=0>Clear developer</option>
					<?php
						$query = db_query("SELECT * FROM `accounts` WHERE `account_type` = 'developer' ORDER BY `experience`;");
						
						while($row = mysqli_fetch_assoc($query)){
					?>
							 <option value=<?php echo $row['id']; ?>><?php echo $row['first_name'] ." ". $row['first_name'] ." (". $row['experience'] ." Exp)"; ?></option>
					<?php
						}
					?>
						</select>
						<input type='checkbox' name='confirm_assign' value=<?php echo $ticket->ticket_id; ?> />
						<input type='submit' value='Assign' />
					</form>
				</td>
			<?php
				}
			?>
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