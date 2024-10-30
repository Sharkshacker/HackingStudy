<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Signup page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
</head>
<body>
<nav class="navbar">
            <div class="nav-left">
                <a href="index.php">Sharks</a>
            </div>
            </nav>
    <div class="signup-box">
        <h2>Sign Up</h2>
        <form action="signup_proc.php" method="POST">
            <div class="input-group">
            <label for="username">ID</label>
            <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
            <label for="password">PW</label>
            <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
            <label for="password_check">Check the PW</label>
            <input type="password" id="password_check" name="password_check" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>