<?php
session_start();
include "db_conn.php";
include "encryption_functions.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=Username is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Encrypt input username and password
        $encryptedInputUsername = caesarCipher(atbashCipher($uname));
        $encryptedInputPassword = caesarCipher(atbashCipher($pass));

        // Retrieve encrypted username and password from the database
        $sql = "SELECT * FROM users WHERE user_name='$encryptedInputUsername'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $encryptedPasswordDB = $row['password'];

            // Validate encrypted password
            if ($encryptedPasswordDB === $encryptedInputPassword) {
                // Login successful
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                // Incorrect password
                header("Location: index.php?error=Incorrect username or password");
                exit();
            }
        } else {
            // Incorrect username or no user found
            header("Location: index.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
