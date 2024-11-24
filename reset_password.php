<?php
session_start();
include 'database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Token is valid, show the form to reset the password
        if (isset($_POST['reset'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password='$password', reset_token=NULL, reset_expiry=NULL WHERE reset_token='$token'";

            if ($conn->query($sql) === TRUE) {
                echo "Your password has been reset. You can now log in with your new password.";
            } else {
                echo "Error updating password.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <form action="reset_password.php?token=<?php echo $_GET['token']; ?>" method="POST">
            <h1>Reset Your Password</h1>
            <input type="password" name="password" placeholder="Enter new password" required>
            <button type="submit" name="reset">Reset Password</button>
        </form>
    </div>
</body>
</html>