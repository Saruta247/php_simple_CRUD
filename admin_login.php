<?php
		//7.check admin username and password

		//7.1 connect to database
		include_once 'dbconnect.php';

		//7.2 check if form is submitted
		if(isset($_POST['login'])) {
			//7.3 initialize variables
			$admin_name = mysqli_real_escape_string($conn, $_POST['admin-name']);
			$admin_password = mysqli_real_escape_string($conn, $_POST['admin-password']);

			//7.4 check if admin exists in the database
			$SQL = "SELECT * FROM admins WHERE admin_name='$admin_name' 
			AND user_passwd='" . md5($admin_password). "'
			AND user_type='A'";
			// execute the query
			$result = mysqli_query($conn, $SQL);

			//7.5. if admin exists, start session and redirect to show_user.php
			if(mysqli_num_rows($result) == 1) {
				// admin exists, start session
				session_start();
				$_SESSION['session_admin_name'] = $admin_name;
				// redirect to show_user.php
				header("Location: show_user.php");
				exit();
			} else {
				$login_error = "Invalid admin name or password";
			}
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Admin | Login</title>
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
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<li class="active"><a href="admin_login.php">Admin</a></li>
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
						<label for="name">Admin Name</label>
						<input type="text" name="admin_name" placeholder="Admin Name" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--8.display message -->
			<?php if(isset($login_error)) { ?>
				<div class="alert alert-danger"><?php echo $login_error; ?></div>
			<?php } ?>	
		</div>
	</div>
</div>
</body>
</html>
