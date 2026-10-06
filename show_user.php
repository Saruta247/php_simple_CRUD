<?php
    //9.fetch and delete record
    include_once 'dbconnect.php';

    //Start the session
    Session_start();

    if(!isset($_SESSION['session_admin_name'])){
        // redirect to admin login page if not logged in as admin
        header("Location: admin_login.php");
        exit();
    }

    //9.1. fetch records
    $SQL = "SELECT * FROM users ORDER BY user_id DESC";
    $result = mysqli_query($conn, $SQL);

    //9.2. delete record
    // check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $get_user_id = intval($_GET['id']); // Sanitize the input to prevent SQL injection
        $SQL = "DELETE FROM users WHERE user_id=" . $get_user_id;
        mysqli_query($conn, $SQL);
        // redirect to show_user.php after deletion 
        header("Location: show_user.php");
        exit();
    }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" >
     <title>PHP Admin | Users</title>
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
         <div class="col-xs-8 col-xs-offset-2">
             <legend>Show All Users</legend>

            <div class="table-responsive">
             <table class="table table-bordered table-hover">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>User Name</th>
                         <th>E-Mail</th>
                         <th>Password</th>
                         <th>User Type</th>
                         <th colspan="2" style="text-align:center">Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                <!--10.show all users in this part of table -->
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['user_email']; ?></td>
                        <td><?php echo $row['user_passwd']; ?></td>   
                        <td>
                           <?php
                           if($row['user_type'] == 'U') {
                                 echo "User"; 
                            } elseif($row['user_type'] == 'A') {
                                 echo "Admin";
                            }
                        ?>
                    </td>
                    <td><a href="update_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-primary">Edit</a></td>
                    <td><input type="button" value="Delete" class="btn btn-danger" onclick="deleteUser(<?php echo $row['user_id']; ?>)" /></td>
                </tr>
             <?php } ?>
            </tbody>
        </table>
    </div>
            <!--12.display number of records -->
            <div class="panel-footer">
                <?php
                  $num_rows = mysqli_num_rows($result);
                  echo "<p>Total Users: " . $num_rows. "</p>";
                ?>
         </div>
     </div>
 </div>
 <!--11.JavaScript for edit and delete actions -->
 <script>
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "show_user.php?id=" + userId;
        }
    }
    </script>
    </body>
</html>