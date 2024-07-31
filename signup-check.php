<?php 
session_start(); 
include "db_conn.php";
include "encryption_functions.php"; // Include your encryption functions file

// Function for basic input validation and sanitization
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
    && isset($_POST['email']) && isset($_POST['bday'])) {

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $bday = validate($_POST['bday']);

    // Encrypt username and password using Atbash and Caesar ciphers
    list($encryptedUsername, $encryptedPassword) = encryptUserData($uname, $pass);

    // Additional validation for password matching
    if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match");
        exit();
    }

    // Execute SQL query to check if username already exists
    $sql = "SELECT * FROM users WHERE user_name='$encryptedUsername'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        header("Location: signup.php?error=The username is taken, please try another");
        exit();
    } else {
        // Insert new user into database with encrypted username and password
        $sql2 = "INSERT INTO users (user_name, password, name, email, birthday) 
                 VALUES ('$encryptedUsername', '$encryptedPassword', '$name', '$email', '$bday')";
        $result2 = mysqli_query($con, $sql2);

        if ($result2) {
            header("Location: signup.php?success=Your account has been created successfully");
            exit();
        } else {
            header("Location: signup.php?error=Unknown error occurred");
            exit();
        }
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
