<?php
session_start();

// 세션 데이터 제거
session_unset();

// 세션 파기
session_destroy();

// 세션 쿠키 삭제
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

echo "<script>
    alert('성공적으로 로그아웃 하였습니다!');
    window.location.href = 'logintest.php';
</script>";
exit();
?>