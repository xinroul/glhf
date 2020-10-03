<?php
	//Initialize the session
	session_start();
	
	//If already logged in
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		//header("location: welcome.php");
		//exit;
	}
	
	//Include main functions
	require_once("include/sql_funcs.php");
	
	//Define variables and initialize with empty values
	$username = "";
	$password = "";
	$username_error = "";
	$password_error = "";
	
	// On form submission
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Connect to database
		sql_connect();
		
		//Extra layer of checks
		$username = mysqli_real_escape_string($GLOBALS['__mysql_link'], trim($_POST["username"]));
		$password = mysqli_real_escape_string($GLOBALS['__mysql_link'], trim($_POST["password"]));
		
		//If username is empty
		if(empty($username)){
			$username_error = "Please enter username.";
		}else{
			$username = trim($username);
		}
		
		//Check if password is empty
		if(empty($password)){
			$password_error = "Please enter your password.";
		}else{
			$password = trim($password);
		}
		
		$query = db_query("SELECT * FROM `accounts` WHERE `id` = '{$username}' AND password = '{$password}' LIMIT 1;");
		$result = mysqli_fetch_assoc($query);
		
		if($result != NULL){
			//Start a new session
			session_start();
			
			//Store data in session variables
			$_SESSION["loggedin"] = true;
			$_SESSION["username"] = $username;							
			
			//Redirect user to welcome page
			header("location: welcome.php");
		}
		
		//Close connection
		@mysqli_close($GLOBALS['__mysql_link']);
	}
?>
<!-- For cimplicity sake, form is from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php -->
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Login</title>
		<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css'>
		<style type='text/css'>
			body{ font: 14px sans-serif; }
			.wrapper{ width: 350px; padding: 20px; }
		</style>
	</head>
	<body>
		<div class='wrapper'>
			<h2>Login</h2>
			<p>Please fill in your credentials to login.</p>
			<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
				<div class='form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>'>
					<label>Username</label>
					<input type='text' name='username' class='form-control' value='<?php echo $username; ?>'>
					<span class='help-block'><?php echo $username_error; ?></span>
				</div>	
				<div class='form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>'>
					<label>Password</label>
					<input type='password' name='password' class='form-control'>
					<span class='help-block'><?php echo $password_error; ?></span>
				</div>
				<div class='form-group'>
					<input type='submit' class='btn btn-primary' value='Login'>
				</div>
			</form>
		</div>	
	</body>
</html>