<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('로그인 후 이용해주세요.');
        location.href='../passlogic/login.php';
    </script>";
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo "<script>
        alert('잘못된 접근입니다.');
        location.href='../index.php';
    </script>";
    exit();
}

// 1) 게시글 데이터 가져오기
$sql   = mysqli_query($db_conn, "SELECT * FROM board_table WHERE board_idx = $id");
$board = mysqli_fetch_array($sql);

// 2) 비밀글 접근 제어: board_secret = 1 이면 작성자 또는 관리자만 허용
$is_author = ($board['user_idx'] == $_SESSION['idx']);
$is_admin  = ($_SESSION['username'] === 'admin');

if ($board['board_secret'] == 1 && ! $is_author && ! $is_admin) {
    echo "<script>
        alert('비밀글입니다.');
        location.href='../index.php';
    </script>";
    exit();
}

mysqli_query(
    $db_conn,
    "UPDATE board_table
        SET board_views = board_views + 1
        WHERE board_idx = $id"
);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sharks 게시판</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" href="../img/sharks2.jpg" type="image/jpeg">
</head>
<body class="view-page">
    <?php include __DIR__ . '/../nav.php'; ?>

    <div class="view">
        <h2><?php echo htmlspecialchars($board['board_title']); ?></h2>
        <div class="user_info">
            <p>
                <b>작성자</b>
                <?php 
                    $user_sql  = mysqli_query($db_conn, "SELECT user_id FROM user_table WHERE user_idx = " . $board['user_idx']);
                    $user_data = mysqli_fetch_array($user_sql);
                    echo htmlspecialchars($user_data['user_id']); 
                ?> | <?php echo $board['board_date']; ?> | <b>조회수</b> <?php echo $board['board_views']; ?>
            </p>
        </div>

        <hr>
        <div class="content">
            <?php echo $board['board_content']; ?>
        </div>

        <!-- 첨부파일 영역 -->
        <?php if (!empty($board['board_file'])): ?>
            <div class="attachment">
                <p>
                    <b>첨부파일:</b>
                    <?php
                        $displayName = !empty($board['board_file_original_name']) ? $board['board_file_original_name'] : $board['board_file'];
                        $fileUrl = "../userupload/" . $board['board_file'];
                    ?>
                    <a href="<?php echo htmlspecialchars($fileUrl); ?>" target="_blank">
                        <?php echo htmlspecialchars($displayName); ?>
                    </a>
                    &nbsp;
                    ( <a href="download.php?file=<?php echo urlencode($board['board_file']); ?>&origin=<?php echo urlencode($displayName); ?>">다운로드</a> )
                </p>
            </div>
        <?php endif; ?>

        <div class="viewButton">
            <ul>
                <li><button onclick="location.href='../index.php'">목록</button></li>
                <?php if ($is_author || $is_admin): ?>
                    <li><button onclick="location.href='modify.php?id=<?php echo $board['board_idx']; ?>'">수정</button></li>
                    <li><button onclick="location.href='delete.php?id=<?php echo $board['board_idx']; ?>'">삭제</button></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>