<?php
session_start();
include "db_conn.php";
include "encryption_functions.php";

if (isset($_SESSION['id']) && isset($_POST['name']) && isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['bday'])) {
    $user_id = $_SESSION['id'];
    $name = validate($_POST['name']);
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $bday = validate($_POST['bday']);

    // Encrypt the username
    $encryptedUsername = encryptUserData($uname, '')[0]; // Only encrypt username

    $sql = "UPDATE users SET name='$name', user_name='$encryptedUsername', email='$email', birthday='$bday' WHERE id='$user_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Update session name if needed
        $_SESSION['name'] = $name;

        // Redirect to home page after successful update
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    // Redirect to edit profile page if session or POST data is not set
    header("Location: edit-profile.php");
    exit();
}
?>
