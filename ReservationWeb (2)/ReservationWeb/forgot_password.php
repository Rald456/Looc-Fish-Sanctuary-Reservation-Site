<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container">
        <form action="send_reset_link.php" method="POST">
            <h1>Forgot Your Password?</h1>
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>