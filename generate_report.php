<?php	
	//Initialize the session
	session_start();
	
	//If there is no session
	if(!isset($_SESSION["loggedin"])){
		return false;
	}
	
	//Include main functions
	require_once("include/funcs/sql_funcs.php");
	
	//Connect to database
	sql_connect();
	
	//Ensure the user has permissions to generate reports
	$account = new Account($_SESSION['username']);
	
	if(!$account->is_tri() && !$account->is_admin()){	
		return false;
	}
	
	//Clean incoming data
	$id = str_clean($_POST['staff_id']);
	$start = str_clean($_POST['start_date']);
	$end = str_clean($_POST['end_date']);
	
	//Prepare query arguments
	$args = [];
	
	if(!empty($id)){
		$args['id'] = "(`assigned_to` = '{$id}' OR `reviewed_by` = '{$id}')";
	}
	
	if(!empty($start)){
		$args['start'] = "`created_date` >= '{$start}'";
	}
	
	if(!empty($end)){
		$args['end'] = "`created_date` <= '{$end}'";
	}
	
	$arg_text = (count($args) > 0) ? "WHERE ". implode(" AND ", $args) : "";
	
	//Get results
	$query = db_query("SELECT `status`, COUNT(*) AS `count` FROM `tickets` {$arg_text} GROUP BY `status`;");
	
	$output = [];
	$sum = 0;
	
	while($row = mysqli_fetch_assoc($query)){
		$output[$row['status']] = (int)$row['count'];
		$sum += $row['count'];
	}
	
	$output['total'] = $sum;
	
	//For breakdown per user when all users are selected
	if(empty($id)){
		//Developers
		$query = db_query(
			"SELECT 
				`status`, 
				`assigned_to`, 
				COUNT(*) as `count` 
			FROM 
				`tickets` 
			WHERE 
				`assigned_to` IS NOT NULL 
				AND `assigned_to` != '' 
				". (isset($args['start']) ? "AND {$args['start']}" : "") ."
				". (isset($args['end']) ? "AND {$args['end']}" : "") ."
			GROUP BY 
				`assigned_to`, 
				`status` 
			ORDER BY 
				`status` ASC,
				`count` DESC;");
		
		while($row = mysqli_fetch_assoc($query)){
			$output['developers'][$row['assigned_to']][$row['status']] = $row['count'];
		}
		
		//Reviewers
		$query = db_query(
			"SELECT 
				`status`, 
				`reviewed_by`, 
				COUNT(*) as `count` 
			FROM 
				`tickets` 
			WHERE 
				`reviewed_by` IS NOT NULL 
				AND `reviewed_by` != '' 
				". (isset($args['start']) ? "AND {$args['start']}" : "") ."
				". (isset($args['end']) ? "AND {$args['end']}" : "") ."
			GROUP BY 
				`reviewed_by`, 
				`status` 
			ORDER BY 
				`status` ASC,
				`count` DESC;");
		
		while($row = mysqli_fetch_assoc($query)){
			$output['reviewers'][$row['reviewed_by']][$row['status']] = $row['count'];
		}
	}
		
	echo json_encode($output);
	
	//Close connection
	@mysqli_close($GLOBALS['mysql_link']);
?>
