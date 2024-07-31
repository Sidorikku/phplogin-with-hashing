<?php

if (!function_exists('validate')) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

// Atbash Cipher function
function atbashCipher($text) {
    $alphabet = range('A', 'Z');
    $reversedAlphabet = array_reverse($alphabet);

    $result = '';
    foreach (str_split(strtoupper($text)) as $char) {
        if (ctype_alpha($char)) {
            $index = array_search($char, $alphabet);
            $result .= $reversedAlphabet[$index];
        } else {
            $result .= $char; // keep non-alphabetic characters unchanged
        }
    }
    return $result;
}

// Caesar Cipher function with shift 10
function caesarCipher($text, $decrypt = false) {
    $shift = $decrypt ? -10 : 10;
    $result = '';
    foreach (str_split($text) as $char) {
        if (ctype_alpha($char)) {
            $ascii = ord($char);
            $offset = ($ascii <= ord('Z')) ? ord('A') : ord('a');
            $result .= chr(($ascii - $offset + $shift + 26) % 26 + $offset);
        } else {
            $result .= $char; // keep non-alphabetic characters unchanged
        }
    }
    return $result;
}

// Function to encrypt username and password
function encryptUserData($username, $password) {
    $encryptedUsername = caesarCipher(atbashCipher($username));
    $encryptedPassword = caesarCipher(atbashCipher($password));
    return array($encryptedUsername, $encryptedPassword);
}

// Function to decrypt username and password
function decryptUserData($encryptedUsername, $encryptedPassword) {
    $decryptedUsername = atbashCipher(caesarCipher($encryptedUsername, true));
    $decryptedPassword = atbashCipher(caesarCipher($encryptedPassword, true));
    return array($decryptedUsername, $decryptedPassword);
}
?>
