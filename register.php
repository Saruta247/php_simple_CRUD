<?php
		//2.save regist info into database

		//2.1 connect to database
		include_once 'dbconnect.php';

		//2.2 iinitialize variables
		$er_flag = false;

		//2.3 check if form is submitted
		if(isset($_POST['signup'])) {
			$name = $_POST['user_name'];
			$email = $_POST['user_email'];
			$password = $_POST['user_password'];
			$cpassword = $_POST['user_cpassword'];

			//2.4 validate user inputs
			// validate password and confirm password
			if($password != $cpassword) {
				$cpassword_error = "Passwords do not match";
				$er_flag = true;	
			}

			// validate email format
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$email_error = "Invalid email format";
				$er_flag = true;
			}

			// validate password length
			if (strlen($password) < 6) {
				$password_error = "Password must be at least 6 characters long.";
				$er_flag = true;
			}

			// validate name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				$name_error = "Only letters and white space allowed in name.";
				$er_flag = true;
			}

			//2.5 if no errors, insert user into database
			if(!$er_flag) {
				// hash the password before storing it 
				// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$hashed_password = md5($password); 
				// insert user into database
				$SQL = "INSERT INTO users (user_name, user_email, user_passwd, user_type) 
				        VALUES ('$name', '$email', '$hashed_password', 'U')";
				// execute the query
				if (mysqli_query($conn, $SQL)) {
					$success_message = "Registration successful. You can now <a href='login.php'>login</a>.";
				} else {
					$registration_error = "Error: " . mysqli_error($conn);
				}
			}	
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
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
				<li class="active"><a href="register.php">Sign Up</a></li>
				<li><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Sign Up</legend>

					<div class="form-group">
						<label for="user-name">Name</label>
						<input type="text" name="user-name" placeholder="Enter Full Name" required value="" class="form-control" />
						<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
					</div>

					<div class="form-group">
						<label for="user-email">Email</label>
						<input type="text" name="user-email" placeholder="Email" required value="" class="form-control" />
						<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
					</div>

					<div class="form-group">
						<label for="user-password">Password</label>
						<input type="password" name="user-password" placeholder="Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
					</div>

					<div class="form-group">
						<label for="user-cpassword">Confirm Password</label>
						<input type="password" name="user-cpassword" placeholder="Confirm Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
					</div>

					<div class="form-group">
						<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--3.display message -->
			<?php if(isset($success_message)) { ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php } ?>
            <?php if(isset($database_error)) { ?>
                <div class="alert alert-danger"><?php echo $database_error; ?></div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>