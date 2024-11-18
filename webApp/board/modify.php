<?php
session_start();
include '../db.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;
if ($id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='../index.php';</script>";
    exit();
}

$id = $_GET['id'];
$sql = mysqli_query($db_conn, "SELECT * FROM board_table WHERE board_idx = $id");
$board = $sql->fetch_array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title) || empty($content)) {
        echo "빈칸을 채워주세요.";
    } else {
        $modify = "UPDATE board_table SET board_title = '$title', board_content = '$content' WHERE board_idx = $id";
        mysqli_query($db_conn, $modify);
        header("Location: view.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks 게시판</title>
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
        <h1>글을 수정하세요.</h1>
        <hr/>
        <form method="POST" action="modify.php?id=<?php echo $board['board_idx']; ?>">
            <table class="writeTable">
                <tr>
                    <th width="50">제목</th>
                    <td><input type="text" name="title" value="<?php echo $board['board_title']; ?>" required></td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td><textarea name="content" rows="5" cols="40" required><?php echo $board['board_content']; ?></textarea></td>
                </tr>
            </table>
            <input type="hidden" name="id" value="<?php echo $board['board_idx']; ?>">
            <ul>
                <li><input class="button" type="submit" value="수정 완료"></li>
                <li><button type="button" onclick="location.href='view.php?id=<?php echo $board['board_idx']; ?>'">취소</button></li>
            </ul>
        </form>
    </div>
    <script src="../js/modal.js"></script>
</body>
</html>