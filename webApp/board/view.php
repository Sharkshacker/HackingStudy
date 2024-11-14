<?php
session_start();
include '../db.php';

// ID 값이 있는지 확인하고 정수로 변환
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='../index.php';</script>";
    exit();
}

// 조회수 증가
$views = mysqli_query($db_conn, "UPDATE board_table SET board_views = board_views + 1 WHERE board_idx = $id");

// 게시글 데이터 가져오기
$sql = mysqli_query($db_conn, "SELECT * FROM board_table WHERE board_idx = $id");
$board = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks 게시판</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
</head>
<body class = "view-page">
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

    <div class="view">
        <h2><?php echo $board['board_title']; ?></h2>
        <div class="user_info">
            <p><b>작성자 </b>
                <?php 
                    $user_sql = mysqli_query($db_conn, "SELECT user_id FROM user_table WHERE user_idx = " . $board['user_idx']);
                    $user_data = mysqli_fetch_array($user_sql);
                    $user_name = $user_data['user_id'];
                    echo $user_name; ?> | <?php echo $board['board_date']; ?> | <b>조회수</b> <?php echo $board['board_views'];
                ?>
            </p>
        </div>

        <hr>
        <div class="content">
            <?php echo nl2br($board['board_content']); ?>
        </div>
        
        <div class="viewButton">
            <ul>
                <li><button onclick="location.href='../index.php'">목록</button></li>
                <?php if($board['user_idx'] == $_SESSION['idx'] || $_SESSION['username'] === 'admin') { ?>
                    <li><button onclick="location.href='modify.php?id=<?php echo $board['board_idx']; ?>'">수정</button></li>
                    <li><button onclick="location.href='delete.php?id=<?php echo $board['board_idx']; ?>'">삭제</button></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>