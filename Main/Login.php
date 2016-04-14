<?php
	session_start();
	include '../CodeBehind/database.php';
	
	$pdo = db_connect_pdo();
	$error = "";
	
	if(isset($_POST['submit'])) {
		$username		= $_POST['username'];
		$password 		= $_POST['password'];
		
		if ($username == "")
		{
			$error = "You must enter a Username";
		}
		else if ($password == "")
		{
			$error = "You must enter a Password";
		}
		else {
			$sql = "SELECT Salt FROM Login WHERE Username=:username";
			
			$query = $pdo->prepare($sql);
			$query->execute(array(":username"=>$username));
			$results = $query->fetchAll();
			
			if($results != FALSE && $query->rowCount() > 0) {
				$salt = $results[0][0];
				
				$passwordSalt = $password.$salt;
		
				$passwordHashed = hash( 'sha256', $passwordSalt);
		
				$sql2 = "SELECT UserID FROM Login WHERE Username=:username && Password=:password";
				$query2 = $pdo->prepare($sql2); 
				$query2->execute(array(":username"=>$username,":password"=>$passwordHashed));
				$results2 = $query2->fetchAll();
				
				if($results2 != FALSE && $query ->rowCount() > 0) {
					$userID = $results2[0][0];
				 
					if(isset($userID)) {
						setcookie("LoggedIn", $userID, time()+3600);
						header("Location: ../Main/Default.php");	
					} else {
						$error = "Incorrect Username or Password";
					}
				} else {
					$error = "Incorrect Username or Password";
				}
			} else {
				$error = "Incorrect Username or Password";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<link href="../App_Themes/StyleSheet.css" rel="stylesheet" /> <!--Custom Style Sheet-->
    	<title>Login</title>
	</head>
	<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="../Main/Default.php">
					<img class="img-responsive" src="../Images/YouSpeakTxtLarge.png" alt="YouSpeak Large" width="130"/>
				</a>
			</div>
		</div>
	</nav>
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-1">
					<h1>Login</h1>
				</div>
			</div>
			<form class="form-horizontal" role="form" action="../Main/Login.php" method="post">
				<div class="form-group">
					<label class="control-label col-sm-3" for="Username">Username</label>
					<div class="col-sm-6">
					 	<input type="username" class="form-control" name="username" id="username" placeholder="Enter username">
					 </div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="Username">Password</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
					</div>
				</div>
				<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-6">
						<button type="submit" name="submit" id="submit" class="btn btn-default" value="Login">Submit</button>
					</div>
				</div>
				<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-6" style="color:red;">
						<?php echo $error; ?>
  					</div>
  				</div>
			</form>
		</div>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	</body>
</html>