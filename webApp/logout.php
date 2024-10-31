<?php
    session_start();

    session_unset();
    session_destroy();

    echo "<script>
        alert('성공적으로 로그아웃 하였습니다!');
        window.location.href = 'login.php';
    </script>";
    exit();
?>