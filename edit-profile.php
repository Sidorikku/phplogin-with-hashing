<?php
session_start();
include "db_conn.php";
include "encryption_functions.php";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Decrypt stored username from the database
        $decryptedUsername = decryptUserData($row['user_name'], '')[0]; // Only decrypt username

        // Populate form fields with decrypted data
    } else {
        header("Location: home.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="styling.css">
</head>
<body>
    <form action="update-profile.php" method="post">
        <h2>Edit Profile</h2>

        <label>Full Name</label>
        <input type="text" name="name" placeholder="Name" value="<?php echo $_SESSION['name']; ?>"><br>

        <label>Username</label>
        <input type="text" name="uname" placeholder="Username" value="<?php echo htmlspecialchars($decryptedUsername); ?>"><br>

        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>

        <label>Birthday</label>
        <input type="date" name="bday" placeholder="Birthday" value="<?php echo htmlspecialchars($row['birthday']); ?>"><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
