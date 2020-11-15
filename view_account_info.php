<?php
	// Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit();
	}
	
	// Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	$account = new Account($_SESSION['username']);
	
	try{
		$view_account = new Account($_GET['a']);
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
		<title>View Account - <?= $view_account->get_full_name() ?></title>
		<link rel='stylesheet' href='include/css/main.css'>
		<link rel='shortcut icon' href='#' /> <!-- Resolving favicon.ico error -->
	</head>
	<body>
		<?php include("include/templates/header.php"); ?>
		<table id='account_details' class='basic_table' style='width:30%;'>
			<tr>
				<td colspan='2'>
					<?= $view_account->get_full_name() ?>'s Profile
				</td>
			</tr>
			<tr>
				<td style='width:25%;'>
					First Name:
				</td>
				<td>
					<?= ucfirst($view_account->get_first_name()) ?>
				</td>
			</tr>
			<tr>
				<td style='width:25%;'>
					Last Name:
				</td>
				<td>
					<?= ucfirst($view_account->get_last_name()) ?>
				</td>
			</tr>
			<tr>
				<td style='width:25%;'>
					Date of birth:
				</td>
				<td>
					<?= date('d-M-Y', strtotime($view_account->get_dob())) ?>
				</td>
			</tr>
			<tr>
				<td style='width:25%;'>
					Account type:
				</td>
				<td>
					<?= ucfirst($view_account->get_account_type()) ?>
				</td>
			</tr>
			<?php
				if(!$account->is_norm()){
			?>
					
					<tr>
						<td style='width:25%;'>
							Experience:
						</td>
						<td>
							<?= $view_account->get_experience() ?>
						</td>
					</tr>
			<?php
				}
			?>
		</table>
		<br />
		<?php
			if($view_account->is_dev() || $view_account->is_rev()){
		?>
			<table id='account_past_tickets' class='basic_table' style='width:30%;'>
				<tr>
					<td colspan='2'>
						Past Tickets
					</td>
				</tr>
				<?php
					$past_tickets = $view_account->past_tickets();
					
					if(count($past_tickets) > 0){
				?>
						<tr>
							<td style='width:25%; text-align:center; background-color:#C9E0EF;'>
								Ticket ID
							</td>
							<td style='text-align:center; background-color:#C9E0EF;'>
								Ticket Title
							</td>
						</tr>
				<?php
						foreach($past_tickets as $this_ticket){
				?>
							<tr>
								<td onclick="location.href='view_ticket_info.php?t=<?= $this_ticket->ticket_id ?>'" style='width:25%; text-align:center; cursor:pointer;'>
									<?= $this_ticket->ticket_id ?>
								</td>
								<td onclick="location.href='view_ticket_info.php?t=<?= $this_ticket->ticket_id ?>'" style='cursor:pointer;'>
									<?= $this_ticket->get_title() ?>
								</td>
							</tr>
				<?php
						}
					}else{
				?>
						<tr>
							<td style='text-align:center; background-color:#C9E0EF;'>
								::: No Tickets :::
							</td>
						</tr>
				<?php
					}
				?>
			</table>
			<br />
			<?php
				if(!$account->is_norm()){
			?>
					<table id='account_active_tickets' class='basic_table' style='width:30%;'>
						<tr>
							<td colspan='2'>
								Active Tickets
							</td>
						</tr>
						<?php
							$active_tickets = $view_account->active_tickets();
							
							if(count($active_tickets) > 0){
						?>
								<tr>
									<td style='width:25%; text-align:center; background-color:#C9E0EF;'>
										Ticket ID
									</td>
									<td style='text-align:center; background-color:#C9E0EF;'>
										Ticket Title
									</td>
								</tr>
						<?php
								foreach($active_tickets as $this_ticket){
						?>
									<tr>
										<td onclick="location.href='view_ticket_info.php?t=<?= $this_ticket->ticket_id ?>'" style='width:25%; text-align:center; cursor:pointer;'>
											<?= $this_ticket->ticket_id ?>
										</td>
										<td onclick="location.href='view_ticket_info.php?t=<?= $this_ticket->ticket_id ?>'" style='cursor:pointer;'>
											<?= $this_ticket->get_title() ?>
										</td>
									</tr>
						<?php
								}
							}else{
						?>
								<tr>
									<td style='text-align:center; background-color:#C9E0EF;'>
										::: No Tickets :::
									</td>
								</tr>
						<?php
							}
						?>
					</table>
					<br />
			<?php
				}
			?>
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