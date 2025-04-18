<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks login</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
    </head>
    <body class="login-page">
        <nav class="navbar">
            <div class="nav-left">
                <a href="../index.php">Sharks</a>
            </div>
            <div class="nav-right">
            <?php if (isset($_SESSION['username'])) : ?> 
            <a href="logout.php">logout</a>
            <?php endif; ?>
        </div>
        </nav>
        <div class="login-box">
            <h2>Sharks</h2>
            <h3> Login </h3>
            <form action="login_proc.php" method="POST">
            <div class="input-group">
                <label for="username">ID</label>
                <input type="text" id="username" name="username" placeholder="ID를 입력하세요" required>
            </div>
            <div class="input-group">
                <label for="password">PW</label>
                <input type="password" id="password" name="password" placeholder="PW를 입력하세요" required>
            </div>
            <button type="submit">submit</button>
            <p class="signup-text"><a href="signup.php">Sign Up</a></p>
            <p class="signup-text"><a href="find.php">계정 찾기</a></p>
            </form>
        </div>
    </body>
</html>