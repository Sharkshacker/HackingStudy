<?php 
    session_start();

    if(!isset($_SESSION['username'])) {
        echo "<script>
            alert('로그인 후 사용가능합니다.');
            window.location.href = 'passlogic/login.php';
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
                            <button class="btn" onclick="window.location.href='passlogic/logout.php'">Logout</button> 
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="index">
            <h1>자유게시판</h1>
            <button onclick="location.href = 'board/write.php'">글쓰기</button>
            <table>
                <tr>
                    <th width="70">번호</th>
                    <th width="500">제목</th>
                    <th width="120">작성자</th>
                    <th width="100">작성일</th>
                    <th width="100">조회수</th>
                </tr>
                <?php
                    include 'board/boardpage.php';
                ?>
            </table>
            <div class="page">
                <?php
                    include 'board/pagenation.php';
                ?>
            </div>
        </div>

        <script src = "js/modal.js"></script>
    </body>
</html>