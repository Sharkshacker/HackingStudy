<?php
session_start();
include __DIR__ . '/../db.php';

// 관리자 확인
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.');location.href='admin.php';</script>";
    exit();
}

// CSRF 검사
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || !isset($_POST['csrf_token'], $_SESSION['csrf_token'])
    || $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    echo "<script>alert('잘못된 요청입니다.');location.href='admin.php';</script>";
    exit();
}

// 1) DB에서 사용 중인 프로필 & 게시글 파일 경로 수집
$used = [];

// 프로필 이미지
$res = mysqli_query($db_conn,
    "SELECT profile_image
       FROM user_table
      WHERE profile_image IS NOT NULL
        AND profile_image <> 'img/profileshark.png'"
);
while ($row = mysqli_fetch_assoc($res)) {
    $used[] = $row['profile_image'];
}

// 게시글 첨부 파일
$res = mysqli_query($db_conn,
    "SELECT board_file
       FROM board_table
      WHERE board_file IS NOT NULL
        AND board_file <> ''"
);
while ($row = mysqli_fetch_assoc($res)) {
    // board_file 에 파일명만 저장 중이라면:
    $used[] = 'userupload/'.$row['board_file'];
    // (전체 경로 저장 시) $used[] = $row['board_file'];
}

// 2) userupload 디렉터리 순회 → DB에 없으면 삭제
$dir = realpath(__DIR__ . '/../userupload');
foreach (glob($dir.'/*') as $file) {
    $rel = 'userupload/'.basename($file);
    if (!in_array($rel, $used) && !in_array($file, $used)) {
        @unlink($file);
    }
}

// 완료 후 리다이렉트
echo "<script>
        alert('사용되지 않는 파일 정리를 완료했습니다.');
        location.href='admin.php';
      </script>";
exit;