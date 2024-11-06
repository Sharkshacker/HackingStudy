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
<html>
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
                <img src="img/profileshark.png" alt="Profile Image" class="profile-icon" onclick="openModal()">
                
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="profile-info">
                            <img src="img/profileshark.png" alt="Profile Image" class="profile-img">
                            <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                            <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            <a href="mypage.php" class="btn">My Page</a> 
                            <button class="btn" onclick="window.location.href='logout.php'">Logout</button> 
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="main-box">
            <h1>로그인 성공! 축하합니다.</h1>
            <p><?php echo htmlspecialchars($_SESSION['username']); ?> 님, 환영합니다!</p>
        </div>

        <script src = "js/modal.js"></script>
    </body>
</html>