<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    include "db_conn.php";

    // Fetch user's current information from the database
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id=$user_id";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
    <html>
        <head>
            <title>HOME</title>
            <link rel="stylesheet" type="text/css" href="styling.css">
        </head>
    <body>
        <h1>Hello, <?php echo $_SESSION['name']; ?>! Welcome</h1>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <form action="edit-profile.php" method="get">
            <button type="submit" class="update-btn">Edit Profile</button>
        </form>
        
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </body>
    </html>



<?php 
} else {
     header("Location: index.php");
     exit();
}
 ?>
