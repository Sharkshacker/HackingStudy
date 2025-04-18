<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];
include __DIR__ . '/../db.php';
// 관리자 권한 확인
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.');location.href='../index.php';</script>";
    exit();
}

$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
if ($uid < 1) {
    echo "<script>alert('잘못된 접근입니다.');history.back();</script>";
    exit();
}

// 회원 아이디 구하기
$nameRes = mysqli_query($db_conn, "SELECT user_id FROM user_table WHERE user_idx = {$uid}");
$userName = mysqli_fetch_assoc($nameRes)['user_id'];

// 게시글 조회
$postRes = mysqli_query(
    $db_conn,
    "SELECT board_idx, board_title, board_date
       FROM board_table
      WHERE user_idx = {$uid}
      ORDER BY board_date DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>관리자 페이지 - <?php echo htmlspecialchars($userName); ?> 게시글</title>
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="index-page">
    <?php include __DIR__ . '/../nav.php'; ?>

    <div class="main-box">
        <h1><?php echo htmlspecialchars($userName); ?> 님의 게시글</h1>
        <table class="index">
            <thead>
                <tr>
                    <th>제목</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($p = mysqli_fetch_assoc($postRes)): ?>
                    <tr>
                        <td>
                            <a href="../board/view.php?id=<?php echo $p['board_idx']; ?>">
                                <?php echo htmlspecialchars($p['board_title']); ?>
                            </a>
                        </td>
                        <td><?php echo $p['board_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="../js/modal.js"></script>
</body>
</html>