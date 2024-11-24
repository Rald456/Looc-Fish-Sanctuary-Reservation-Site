<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>SignIn-SignUp</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="session.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or</span>
                <input type="text" name="username" placeholder="Username" required autocomplete="off">
                <input type="email" name="email" placeholder="Email" required autocomplete="off">
                <div class="password-container">
                    <input type="password" name="password" placeholder="Password" id="signup-password" required autocomplete="off">
                    <i class="fa fa-eye" id="toggle-signup-password"></i>
                </div>
                <button type="submit" name="signup">Sign Up</button>
            </form>   
        </div>
        <div class="form-container sign-in">
            <form action="session.php" method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <span>or</span>
                <input type="email" name="email" placeholder="Email" required autocomplete="off">
                <?php if (isset($_GET['error']) && $_GET['error'] === 'email'): ?>
                    <p class="error">No user found with this email</p>
                <?php endif; ?>
                <div class="password-container">
                    <input type="password" name="password" placeholder="Password" id="signin-password" required autocomplete="off">
                    <i class="fa fa-eye" id="toggle-signin-password"></i>
                </div>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'password'): ?>
                    <p class="error">Invalid password</p>
                <?php endif; ?>
                <a href="forgot_password.php">Forgot Your Password?</a>
                <button type="submit" name="signin">Sign In</button>
            </form>   
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>New Here?</h1>
                    <p>Register with your personal information.</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
