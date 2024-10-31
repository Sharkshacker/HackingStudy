<?php 
    session_start();

    if(!isset($_SESSION['username'])) {
        echo "<script>
            alert('로그인 후 사용가능합니다.');
            window.location.href = 'login.php';
        </script>";
        exit();
    }
?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Sharks Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/img/sharks2.jpg" type="image/jpeg">
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="index.php">Sharks</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['username'])) : ?> 
            <a href="logout.php">logout</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="main-box">
        <h1>로그인 성공! 축하합니다.</h1>
        <p><?php echo htmlspecialchars($_SESSION['username']); ?> 님, 환영합니다!</p>
    </div>
</body>