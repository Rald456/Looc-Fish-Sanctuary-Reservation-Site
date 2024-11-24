<?php
session_start();
include 'database.php';

if (isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token for the password reset
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store the token and expiry in the database
        $sql = "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Send the password reset email with the token
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "To reset your password, click on the following link: $resetLink";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "Password reset link sent to your email.";
            } else {
                echo "Error sending email.";
            }
        }
    } else {
        echo "No user found with this email.";
    }
}

$conn->close();
?>