<?php
session_start();
include __DIR__ . '/db.php';

// CSRF 검증 (POST만 받도록 하고, 토큰 체크)
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || !isset($_POST['csrf_token'], $_SESSION['csrf_token'])
    || $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    echo "<script>alert('잘못된 접근입니다.');history.back();</script>";
    exit();
}

// 로그인 체크
if (!isset($_SESSION['username'], $_SESSION['idx'])) {
    echo "<script>alert('로그인 후 이용하세요.');location.href='index.php';</script>";
    exit();
}

$isAdmin   = ($_SESSION['username'] === 'admin');
$selfUid   = intval($_SESSION['idx']);
$targetUid = $selfUid;              // 기본: 자신

// 관리자가 uid 파라미터를 전달했다면, 대상UID를 바꾼다
if ($isAdmin && isset($_POST['uid'])) {
    $maybe = intval($_POST['uid']);
    if ($maybe > 0) {
        $targetUid = $maybe;
    }
}

// DB에서 회원 삭제
mysqli_query($db_conn, "DELETE FROM user_table WHERE user_idx = {$targetUid}");

// 세션 해제: 자신이 탈퇴할 때만
if (!$isAdmin || $targetUid === $selfUid) {
    session_unset();
    session_destroy();
    echo "<script>
            alert('회원 탈퇴가 완료되었습니다.');
            window.location.href='index.php';
          </script>";
} else {
    // 관리자가 다른 회원을 지웠을 때
    echo "<script>
            alert('회원이 삭제되었습니다.');
            window.location.href='admin/admin.php';
          </script>";
}
exit;
?>