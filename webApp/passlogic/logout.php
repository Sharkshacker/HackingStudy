<?php
    session_start();

    session_unset();             
    session_destroy();           
    setcookie("PHPSESSID", "", time() - 3600, "/"); 

    echo "<script>
        alert('성공적으로 로그아웃 하였습니다!');
        window.location.href = 'login.php';
    </script>";
    exit();
?>