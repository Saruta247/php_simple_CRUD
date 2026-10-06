<?php
		//4.check login info from users table

		//4.1 connect to database
		include_once 'dbconnect.php';

		//4.2 ckeck if form is submitted
		if(isset($_POST['login'])) {
			//4.3 initialize variables
			//4.4 sanitize user inputs , prevent SQL injection
			$user_email = mysqli_real_escape_string($conn, $_POST['user-email']);
			$user_password = mysqli_real_escape_string($conn, $_POST['user-password']);

			//4.5 check if user exists in the database
			$SQL = "SELECT * FROM users WHERE user_email='$user_email' AND user_passwd='" . md5($user_password). "'";
			// execute the query 
			$result = mysqli_query($conn, $SQL);


		 //4.6 if user exists, start session and redirect to index.php
        //convert resultset to array and check if it has any rows
        if($row = mysqli_fetch_array($result)) {
            // user exists, start session
            session_start();
            if ($row['user_type'] == 'A') {
                $_SESSION['session_admin_name'] = $row['user_name'];
                header("Location: show_user.php");
                exit();
            } else {
                $_SESSION['session_user_id'] = $row['user_id'];
                $_SESSION['session_user_name'] = $row['user_name'];
                // redirect to index.php
                header("Location: index.php");
                exit();
            }
        } else {
            $login_error = "Invalid email or password.";
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>PHP Login</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<li><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
				<fieldset>
					<legend>Login</legend>

					<div class="form-group">
						<label for="user-email">Email</label>
						<input type="text" name="user-email" placeholder="Your Email" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="user-password">Password</label>
						<input type="password" name="user-password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--5.display message -->
			<span class="text-danger">
				<?php 
				  if (isset($login_error))  
					 echo $login_error; 
				?>
			</span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
		New User? <a href="register.php">Sign Up Here</a>
		</div>
	</div>
</div>
</body>
</html>
