<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username'])) {
        echo "<script>
            alert('로그인 후 사용 가능합니다.');
            window.location.href = '../passlogic/login.php';
        </script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        if(empty($title) || empty($content)) {
            echo "빈칸을 채워주세요.";
        }else {
            $user_idx = $_SESSION['idx'];
            $sql = "INSERT INTO board_table (board_title, board_content, user_idx) VALUES ('$title', '$content', '$user_idx')";
            mysqli_query($db_conn,$sql);
            header("Location: ../index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sharks writePost</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
    </head>
    <body>
        <nav class="navbar">
            <div class="nav-left">
                <a href="../index.php">Sharks</a>
            </div>
            <div class="nav-right">
                <img src="../img/profileshark.png" alt="Profile Image" class="profile-icon" onclick="openModal()">
                
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="profile-info">
                            <img src="../img/profileshark.png" alt="Profile Image" class="profile-img">
                            <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                            <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            <a href="../mypage.php" class="btn">My Page</a> 
                            <button class="btn" onclick="window.location.href='../passlogic/logout.php'">Logout</button> 
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="write">
            <h1>글을 작성하세요.</h1>
            <hr/>
            <form method="POST" action="write.php">
                <table class="writeTable">
                    <tr>
                        <th width = "50">제목</th>
                        <td><input type = "text" name="title" placeholder="제목을 입력하세요." required></td>
                    </tr>
                    <tr>
                        <th>내용</th>
                        <td><textarea name="content" rows="5" cols="40" placeholder="내용을 입력하세요." required></textarea></td>
                    </tr>
                </table>
                    <ul>
                        <li><input class = "button" type = "submit" value="작성 완료"></li>
                        <li><button type="button" onclick = "location.href = '../index.php'">취소</button></li>
                    </ul>
            </form>
        </div>
        <script src = "../js/modal.js"></script>
    </body>
</html>