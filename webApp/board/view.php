<?php
session_start();
include '../db.php';

// 로그인 상태 체크
if (!isset($_SESSION['username'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href='../passlogic/login.php';</script>";
    exit();
}

// GET 파라미터로 전달된 게시글 id 확인 및 정수 변환
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='../index.php';</script>";
    exit();
}

// 조회수 증가 처리
mysqli_query($db_conn, "UPDATE board_table SET board_views = board_views + 1 WHERE board_idx = $id");

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
<body class="view-page">
    <?php include __DIR__ . '/../nav.php' ?>

    <div class="view">
        <h2><?php echo htmlspecialchars($board['board_title']); ?></h2>
        <div class="user_info">
            <p>
                <b>작성자</b>
                <?php 
                    $user_sql = mysqli_query($db_conn, "SELECT user_id FROM user_table WHERE user_idx = " . $board['user_idx']);
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
                        // DB에 저장된 원본 파일명이 있으면 그 값을 사용, 없으면 서버 파일명을 사용
                        $displayName = !empty($board['board_file_original_name']) ? $board['board_file_original_name'] : $board['board_file'];
                        // 실제 저장된 파일 경로 (userupload 폴더)
                        $fileUrl = "../userupload/" . $board['board_file'];
                    ?>
                    <!-- 파일 이름에 하이퍼링크 걸어 실제 파일 경로로 이동 (새창) -->
                    <a href="<?php echo htmlspecialchars($fileUrl); ?>" target="_blank">
                        <?php echo htmlspecialchars($displayName); ?>
                    </a>
                    &nbsp;
                    <!-- 다운로드 링크 (download.php를 통한 다운로드 기능) -->
                    ( <a href="download.php?file=<?php echo urlencode($board['board_file']); ?>&origin=<?php echo urlencode($displayName); ?>">다운로드</a> )
                </p>
            </div>
        <?php endif; ?>

        <div class="viewButton">
            <ul>
                <li><button onclick="location.href='../index.php'">목록</button></li>
                <?php if ($board['user_idx'] == $_SESSION['idx'] || $_SESSION['username'] === 'admin') { ?>
                    <li><button onclick="location.href='modify.php?id=<?php echo $board['board_idx']; ?>'">수정</button></li>
                    <li><button onclick="location.href='delete.php?id=<?php echo $board['board_idx']; ?>'">삭제</button></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>