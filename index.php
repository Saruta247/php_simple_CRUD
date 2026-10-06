<?php
		session_start();
		include_once 'dbconnect.php';

		if (!isset($_SESSION['session_user_id'])) {
			header("Location: login.php");
			exit();
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home | PHP Simple CRUD</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<!--6.if already logged in, change menu items -->
				<?php if (isset($_SESSION['session_user_id'])): ?>
					<li><a href="admin_login.php">Admin</a></li>
					<li><span class="navbar-text">Hello, <?php echo $_SESSION['session_user_name']; ?></span></li>
					<li><a href="logout.php">Logout</a></li>
					<?php else: ?>
						<li><a href="login.php">Login</a></li>
						<li><a href="register.php">Sign Up</a></li>
						<li><a href="admin_login.php">Admin</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container text-center" style="margin-top: 50px;">
			<div class="jumbotron">
				<h2>Hello, <?php echo $_SESSION['session_user_name']; ?>!</h2>
				<p>You are logged in as a User.</p>
				<p>
					<a href="admin_login.php" class="btn btn-primary">Go to Admin Login</a>
					<a href="logout.php" class="btn btn-default">Logout</a>
				</p>
			</div>
		</div>
	</body>
</html>

