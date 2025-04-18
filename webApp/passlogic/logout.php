<?php
    session_start();

    session_unset();             // 세션 변수 제거
    session_destroy();           // 세션 완전히 파괴
    setcookie("PHPSESSID", "", time() - 3600, "/");  // 🔥 쿠키 제거 핵심!

    echo "<script>
        alert('성공적으로 로그아웃 하였습니다!');
        window.location.href = 'login.php';
    </script>";
    exit();
?>