<?php
    //13.display old info and update into users table
    include_once 'dbconnect.php';

    // Start the session and check admin permission
    session_start();
    if(!isset($_SESSION['session_admin_name'])) {
        header("Location: admin_login.php");
        exit();
    }

    $err_flag = false;

    // Get user id from GET or POST
    $get_user_id = 0;
    if(isset($_GET['id'])) {
        $get_user_id = intval($_GET['id']);
    } elseif(isset($_POST['user-id-update'])) {
        $get_user_id = intval($_POST['user-id-update']);
    }

    //13.2 Update user data
    if (isset($_POST['update'])) {
        $user_name = mysqli_real_escape_string($conn, trim($_POST['user-name-update']));
        $user_password = mysqli_real_escape_string($conn, $_POST['user-password-update']);
        $user_cpassword = mysqli_real_escape_string($conn, $_POST['user-cpassword-update']);

        // Validate user name
        if (!preg_match("/^[a-zA-Z ]*$/", $user_name)) {
            $error_message = "Name must contain only letters and spaces.";
            $err_flag = true;
        }
        // Validate confirm password
        if ($user_password !== $user_cpassword) {
            $error_message = "Passwords do not match.";
            $err_flag = true;
        }

        if (!$err_flag) {
            // Hash the password before storing it
            $hashed_password = md5($user_password);
            // Update the user data in the database
            $SQL = "UPDATE users SET 
                    user_name='$user_name',
                    user_passwd='$hashed_password'
                    WHERE user_id=" . $get_user_id;
            if (mysqli_query($conn, $SQL)) {
                $success_message = "User updated successfully.";
                // Redirect to show_user.php after successful update
                header("Location: show_user.php");
                exit();
            } else {
                $error_message = "Error updating user: " . mysqli_error($conn);
            }
        }
    }

    //13.1 Get existing user data based on the provided ID
    if($get_user_id > 0) {
        $SQL = "SELECT * FROM users WHERE user_id=" . $get_user_id;
        $result = mysqli_query($conn, $SQL);
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
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
                <?php if (isset($_SESSION['session_admin_name'])): ?>
                    <li><a href="show_user.php">Users List</a></li>
                    <li><span class="navbar-text">Welcome, <?php echo $_SESSION['session_admin_name']; ?>!</span></li>
                    <li><a href="logout.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                    <li class="active"><a href="admin_login.php">Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="updateform">
                <fieldset>
                    <legend>Update</legend>

                    <!--14.display old info in text field -->
                    <div class="form-group">
                        <input type="hidden" name="user-id-update" value="<?php if(isset($row['user_id'])) { echo $row['user_id']; } ?>" />
                        <label for="user-name-update">Name</label>
                        <input type="text" name="user-name-update" placeholder="Enter Full Name" required value="<?php if(isset($row['user_name'])) { echo $row['user_name']; } ?>" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="user-email-update">Email</label>
                        <input type="text" name="user-email-update" placeholder="Email" required readonly value="<?php if(isset($row['user_email'])) { echo $row['user_email']; } ?>" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="user-password-update">Password</label>
                        <input type="password" name="user-password-update" placeholder="Password" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="user-cpassword-update">Confirm Password</label>
                        <input type="password" name="user-cpassword-update" placeholder="Confirm Password" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="submit" name="update" value="Update" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
            <!--15.display message -->
            <?php
                if(isset($error_message)) {
                    echo '<span class="text-danger">' . $error_message . '</span>';
                } elseif(isset($success_message)) {
                    echo '<span class="text-success">' . $success_message . '</span>';
                }
            ?>

        </div>
    </div>
</div>
</body>
</html>
