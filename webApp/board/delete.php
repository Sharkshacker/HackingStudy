<?php
session_start();
include '../db.php';

// 게시글 id를 GET 파라미터로 받음 (추가로 로그인/권한 검사하면 더욱 안전합니다)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='../index.php';</script>";
    exit();
}

// DB에서 해당 게시글의 첨부파일 정보 조회
$result = mysqli_query($db_conn, "SELECT board_file FROM board_table WHERE board_idx = $id");
if ($result) {
    $row = mysqli_fetch_array($result);
    if ($row && !empty($row['board_file'])) {
        // 업로드 폴더 경로 (이 경로는 DB에 저장된 값과 같이 지정된 경로여야 함)
        $uploadDir = '../userupload/';
        $filePath = $uploadDir . $row['board_file'];
        // 해당 파일이 존재하면 삭제
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

// DB에서 게시글 삭제
$sql = mysqli_query($db_conn, "DELETE FROM board_table WHERE board_idx = $id");

if ($sql) {
    echo "<script>
        alert('삭제되었습니다.');
        window.location.href = '../index.php';
    </script>";
} else {
    echo "<script>
        alert('삭제에 실패했습니다.');
        window.location.href = '../index.php';
    </script>";
}
?>